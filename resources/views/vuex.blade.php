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
            display: flex;
            justify-content: center;

        }
        .level{
            display: flex;
            align-items: center;
        }
        .mr-1{
            margin-right: 1rem;
        }
    </style>

</head>
    <body>
       <div id="app">
            <div class="level">
                <h1 class="mr-1">Todos</h1>
                <button @click="completeAll" v-show="! allComplete">Complete All</button>
                <button @click="uncompleteAll">Uncomplete All</button>
            </div>
            <p>
                <input type="text" placeholder="do this" @keyup.enter="addTodo"/>
            </p>
            <todo v-for="(todo,index) in todos" :todo='todo' :key="index">

            </todo>

       </div>
       <script src="/js/vuextodo.js"></script>
    </body>
</html>
