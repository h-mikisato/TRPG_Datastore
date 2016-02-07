<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="/css/uikit.almost-flat.min.css">
    </head>
    <body>
        <div class="uk-container uk-container-center uk-margin-large-top">
            <div class="uk-grid">
                <h1 class="uk-width-1-1">@yield('title')</h1>
            @if (Session::has('flash_message'))
                <div class="uk-width-1-1">
                    <div class="uk-alert" data-uk-alert>
                    <a href="" class="uk-alert-close uk-close"></a>
                    <p>{{ Session::get('flash_message') }}</p>
                    </div>
                </div>
            @endif
            </div>
            @yield('content')
        </div>
        <script src="//code.jquery.com/jquery.min.js"></script>
        <script src="/js/uikit.min.js"></script>
    </body>
</html>
