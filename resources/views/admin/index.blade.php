<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>--}}
    <!-- 引入样式 -->
    <link rel="stylesheet" href="https://unpkg.com/mint-ui/lib/style.css">
    {{--刪減版--}}
    <link rel="stylesheet" href="{{asset('css/materialize.css')}}">
    <link rel="icon" href="/images/admin/order.jpg">
    <link rel="stylesheet" href="{{asset('css/admin/main.css')}}">
    {{--jq confirm--}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
</head>
<style>
</style>
<body>
<div id="app" class="main-app">
    <template>
        <div>
            <transition name="fade">
                <keep-alive>
                    <router-view></router-view>
                </keep-alive>
            </transition>
        </div>
    </template>
</div>
<script src="{{mix('/js/admin/app.js')}}"></script>
</body>
</html>
