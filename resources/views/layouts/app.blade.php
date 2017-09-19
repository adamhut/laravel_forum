<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">   
    

    <style type="text/css">
    .list-group-item >  .label{
        margin-right: 1em;
    }
    .level {display: flex;align-items: center;}
    .flex{
        flex:1;
    }

    .mr-1{
        margin-right: 1em;
    }
    .ml-a{
        margin-left:auto;
    }
    [v-cloak]{
        display: none;
    }
    </style>
    <!-- Scripts -->
    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::user(),
            'signedIn'=> Auth::check(),
        ]) !!};
    </script>
    <style>
        body {
            padding-bottom: 100px;
        }
        .level{
            display: flex;
            align-items: center;
        }
    </style>
    @yield('header')
</head>
<body>
    <div id="app">
        @include('layouts.nav')
        <div class="container">
            @include('flash::message')
            @yield('content')
        </div>


        <flash message="{{ session('falsh') }}" cate="success"></flash>
        
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $('div.alert').not('alert-important').delay(3000).fadeOut(350);
        $('#flash-overlay-modal').modal();
    </script>
    @yield('footerScript')
</body>
</html>
