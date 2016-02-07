@extends('template')

@section('title', $post['title'])
@stop

@section('content')
    <div class="uk-grid">
        <div class="uk-width-1-1">
            <div class="uk-panel uk-panel-box uk-article">
                {!! nl2br($post['content']) !!}
                <div class="uk-article-meta uk-text-right">
                    <div>作成者：{{ $post['creator'] }}<br>
                        最終更新：{{ date('Y/m/d H:i:s', $post['updated_at']) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <a href="/" class="uk-button">トップに戻る</a>
        </div>
        <form method="POST" action="/edit/{{ $key }}" class="uk-form uk-width-1-2 uk-text-right">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input name="is_auth" type="hidden" value="1">
            <input name="password" type="password" placeholder="パスワード">
            <button type="submit" class="uk-button uk-button-large uk-button-primary">編集</button>
        </form>
    </div>
@stop
