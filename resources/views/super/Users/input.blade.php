@extends('super.layouts.template')

@section('title', '帳號管理(新增)')

@section('content')
    <div>
        <div class="section no-pad-bot" id="index-banner">
            <div class="container">
                <div class="section">
                </div>
                <div class="section">
                    <a class="waves-effect waves-light btn-small" @click="store">
                        <i class="material-icons right">archive</i>儲存
                    </a>
                </div>
            </div>
        </div>
        <input type="hidden" id="parameters-all" value="{{route('super.parameters.all')}}">
        <input type="hidden" id="parameters-update" value="{{route('super.parameters.update')}}">
    </div>
@endsection
@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                parameters: {},
            },
            mounted: function () {
            },
            methods: {
                store: function () {

                }
            }
        })
    </script>
@endsection