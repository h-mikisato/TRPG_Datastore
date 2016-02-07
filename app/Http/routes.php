<?php

use Illuminate\Support\Facades\Hash;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/', function() use ($app) {
        $input = \Request::all();
        $category = "";
        if (!empty($input['category'])) {
            $category = $input['category'];
            $posts = \DB::select('select * from posts where category like ? order by updated_at desc',
                                 ["%" . $input['category'] . "%"]);
        } else {
            $posts = \DB::select('select * from posts order by updated_at desc');
        }
        return view('list', ['posts' => $posts, 'category' => $category]);
    });

$app->get('/view/{key}', function($key) use ($app) {
        $post = \DB::select('select * from posts where access_key = ?', [$key]);
        if (empty($post)) { abort(404); }
        return view('article', ['post' => (array)$post[0], 'key' => $key]);
    });

$app->get('/new', function() use ($app) {
        return view('form', ['is_new' => true]);
    });

$app->post('/new', function() use ($app) {
        $input = \Request::all();
        $validator = \Validator::make(
            $input,
            [
                'title' => 'required',
                'creator' => 'required',
                'category' => 'required',
                'content' => 'required',
                'password' => 'required',
            ]
        );
        if ($validator->fails()) {
            Session::flash('flash_message', "空の項目があります");
            $input['password'] = '';
            return view('form', ['is_new' => true, 'post' => $input]);
        }
        $now = time();
        $access_key = hash('md5', $input['title'] . $input['creator'] . $now);
        $hashed_pass = Hash::make($input['password']);
        try {
            \DB::insert(
                'insert into posts ' .
                '(access_key, creator, category, title, content, password, created_at, updated_at) ' .
                'values (?, ?, ?, ?, ?, ?, ?, ?)',
                [$access_key, htmlspecialchars($input['creator']),
                 htmlspecialchars($input['category']), htmlspecialchars($input['title']),
                 htmlspecialchars($input['content']), $hashed_pass, $now, $now]
            );
        } catch (\Exception $e) {
            Session::flash('flash_message', "エラーが発生しました。何度も失敗するようでしたら管理者に報告してください。");
            $input['password'] = '';
            return view('form', ['is_new' => true, 'post' => $input]);
        }
        return redirect('/view/' . $access_key)->with('flash_message', '保存しました');
    });

$app->post('/edit/{key}', function($key) use ($app) {
        $input = \Request::all();
        if (!empty($input['is_auth'])) {
            $post = \DB::select('select * from posts where access_key = ?', [$key]);
            if (empty($post)) { abort(404); }
            if (!(Hash::check($input["password"], $post[0]->password) ||
                  $input["password"] == $_ENV["APP_ADMIN_PASS"])) {
                return redirect("/view/" . $key)->with('flash_message', "パスワードが違います");
            }
            return view('form', ['is_new' => false, 'post' => (array)$post[0], 'key' => $key]);
        } else {
            $validator = \Validator::make(
                $input,
                [
                    'title' => 'required',
                    'creator' => 'required',
                    'category' => 'required',
                    'content' => 'required',
                ]
            );
            if ($validator->fails()) {
                \Session::flash('flash_message', "空の項目があります");
                return view('form', ['is_new' => false, 'post' => $input, 'key' => $key]);
            }
            $now = time();
            try {
                \DB::update(
                    'update posts set ' .
                    'creator = ?, category = ?, title = ?, content = ?, updated_at = ?' .
                    'where access_key = ?',
                    [htmlspecialchars($input['creator']), htmlspecialchars($input['category']),
                     htmlspecialchars($input['title']), htmlspecialchars($input['content']), $now, $key]
                );
            } catch (\Exception $e) {
                Session::flash('flash_message', "エラーが発生しました。何度も失敗するようでしたら管理者に報告してください。");
                $input['password'] = '';
                return view('form', ['is_new' => false, 'post' => $input, 'key' => $key]);
            }
            return redirect('/view/' . $key)->with('flash_message', "更新しました");
        }
    });

// $app->get('/chpass', function() use ($app) {
//         return "admin chpass\n";
//     });

// $app->post('/chpass', function() use ($app) {
//         if ($_ENV["APP_ADMIN_PASS"] != \Request::input("password")) {
//             return redirect('/chpass')->with('flash_message', "管理者パスワードが違います");
//         }
//         return "OK\n";
//         //return redirect('/chpass')->with('flash_message', "パスワードを変更しました");
//     });
