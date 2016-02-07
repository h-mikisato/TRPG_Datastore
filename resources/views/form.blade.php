@extends('template')

@section('title')
    {{ $is_new ? '新規作成' : '編集' }}
@stop

@section('content')
    <div class="uk-form uk-form-horizontal uk-grid">
        <form method="POST" action="/{{ $is_new ? "new" : "edit/" . $key }}" class="uk-width-1-1">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="uk-form-row">
                <label class="uk-form-label" for="form-title">名称</label>
                <div class="uk-form-controls">
                    <input id="form-title" name="title" type="text" value="{{ $post['title'] or "" }}" placeholder="データの名称">
                </div>
            </div>
            <div class="uk-form-row">
                <label class="uk-form-label" for="form-creator">作成者</label>
                <div class="uk-form-controls">
                    <input id="form-creator" name="creator" type="text" value="{{ $post['creator'] or "" }}"  placeholder="作成者">
                </div>
            </div>
            <div class="uk-form-row">
                <label class="uk-form-label" for="category">カテゴリ</label>
                <div class="uk-form-controls">
                    <input id="form-category" name="category" type="text" value="{{ $post['category'] or "" }}"  placeholder="カテゴリ">
                </div>
            </div>
            <div class="uk-form-row">
                <label class="uk-form-label" for="form-content">内容</label>
                <div class="uk-form-controls">
                    <textarea cols="60" id="form-content" name="content" rows="10" placeholder="データの内容">{{ $post['content'] or "" }}</textarea>
                </div>
            </div>
            @if ($is_new)
                <div class="uk-form-row">
                    <label class="uk-form-label" for="form-password">編集パスワード</label>
                    <div class="uk-form-controls">
                        <input name="password" type="password" value="{{ $post['password'] or "" }}" placeholder="パスワード">
                    </div>
                </div>
            @endif
            <div class="uk-form-row">
                <div class="uk-form-controls">
                    <button type="submit" class="uk-button uk-button-primary uk-button-large">送信</button>
                </div>
            </div>
        </form>
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <a href="/{{ $is_new ? "" : "view/" . $key }}" class="uk-button uk-button">戻る</a>
            </div>
        </div>
    </div>

@stop
