<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    @yield('css')
</head>
<style>
    [v-cloak] {
        display: none;
    }

    .text-danger {
        color: red;
    }
</style>
<body>
<div id="app" v-cloak>
    <nav class="light-blue lighten-1">
        <div class="nav-wrapper">
            <a class="brand-logo center">@yield('title')</a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="left hide-on-med-and-down">
                <li><a href="{{route('super.parameters.index')}}">參數管理</a></li>
                <li><a href="{{route('super.users.index')}}">帳號管理</a></li>
                <li><a class="dropdown-trigger" href="#!" data-target="dropdown-users">XXXX<i
                                class="material-icons right">arrow_drop_down</i></a></li>
                <ul id="dropdown-users" class="dropdown-content">
                    <li><a href="{{route('super.users.index')}}">列表</a></li>
                    <li><a href="{{route('super.users.create')}}">新增</a></li>
                    <li><a href="{{route('super.users.update')}}">修改</a></li>
                </ul>
            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
        <li><a href="{{route('super.parameters.index')}}">參數管理</a></li>
        <li><a href="{{route('super.users.index')}}">帳號管理</a></li>
        <li><a class="dropdown-trigger" href="#!" data-target="dropdown-users-m">XXXXX<i class="material-icons right">arrow_drop_down</i></a>
        </li>
        <ul id="dropdown-users-m" class="dropdown-content">
            <li><a href="{{route('super.users.index')}}">列表</a></li>
            <li><a href="{{route('super.users.create')}}">新增</a></li>
            <li><a href="{{route('super.users.update')}}">修改</a></li>
        </ul>
    </ul>

    @yield('content')
</div>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
<script src="{{asset('/super/js/app.js')}}"></script>

<script>
    // Or with jQuery
    $(document).ready(function () {
        $('.sidenav').sidenav();
        $(".dropdown-trigger").dropdown();
    });
</script>
@yield('js')
</body>
</html>
