@extends('template')

@section('title', 'データ倉庫')
@stop

@section('content')
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <a href="/new" class="uk-button uk-button-large">新規作成</a>
        </div>
        <form method="GET" action="/" class="uk-form uk-width-1-2 uk-text-right">
            <input name="category" type="text" value="{{ $category }}" placeholder="分類絞り込み">
            <button type="submit" class="uk-button uk-button-primary">絞り込み</button>
        </form>
    </div>
    <div class="uk-grid">
        <div class="uk-width-1-1">
            <table class="uk-table uk-table-hover">
                <thead>
                    <tr>
                        <th class="uk-text-large uk-text-bold uk-width-2-4">名前</th>
                        <th class="uk-text-large uk-text-bold uk-width-1-4">分類</th>
                        <th class="uk-text-large uk-text-bold uk-widht-1-4">作成者</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td><a href="/view/{{ $post->access_key }}"> {{ $post->title }}</a></td>
                            <td>{{ $post->category }}</td>
                            <td>{{ $post->creator }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="uk-text-center uk-text-large"><em>No Data</em></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-1-1">
            <a href="/new" class="uk-button uk-button-large">新規作成</a>
        </div>
    </div>
@stop
