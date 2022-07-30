<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>

    <body>
        <header>
            <div class="layout__navbar">
                Bemo
                <a class="btn__export btn__primary__outlined" href="{{ route('db.export') }}" target="_blank">Export DB</a>
            </div>
        </header>

        <main class="layout__main">
            <div id="app" class="layout__content">
                {{$slot}}
            </div>
        </main>
    </body>
</html>
