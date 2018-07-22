<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
    <title>參數管理</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div id="app">
    <nav class="light-blue lighten-1" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" href="#" class="brand-logo">參數管理</a>
        </div>
    </nav>

    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <div class="section">
                <div class="row" v-for="parameter, parameterKey in parameters">

                    <div class="input-field col s3">
                        <i class="material-icons prefix">account_circle</i>
                        <label for="icon_prefix">@{{ parameter.name }}</label>
                    </div>
                    <div class="input-field col s9">

                        <div v-if="parameter.type == 'boolean'">
                            <p>
                                <label>
                                    <input name="group1" type="radio"
                                           :checked="parameter.value=='true'?'checked':''"
                                    @click="parameter.value='true'"
                                    />
                                    <span>開啟(TRUE)</span>
                                </label>
                                <label>
                                    <input name="group1" type="radio"
                                           :checked="parameter.value=='true'?'':'checked'"
                                    @click="parameter.value='false'"
                                    />
                                    <span>關閉(FALSE)</span>
                                </label>
                            </p>
                        </div>

                        <div v-if="parameter.type == 'select'">
                            <select :id="parameterKey" @change="updateSelect(parameterKey)">
                            <option :value="value" v-for="value,key in parameter.options"
                                    :selected="parameter.value==value?'selected':''">
                                @{{ key }}
                            </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section">
                <a class="waves-effect waves-light btn-small" @click="store">
                <i class="material-icons right">archive</i>儲存
                </a>
            </div>
        </div>
    </div>
    <input type="hidden" id="parameters-all" value="{{route('parameters.all')}}">
    <input type="hidden" id="parameters-update" value="{{route('parameters.update')}}">

</div>

<script src="{{asset('/super/js/app.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>

<script>

    var app = new Vue({
        el: '#app',
        mode: 'develop',
        data: {
            test: 'test',
            parameters: {},
        },
        mounted: function () {
            this.getParameters();
        },
        methods: {
            getParameters: function () {
                var that = this;
                var url = $('#parameters-all').val();
                $.get({
                    url: url,
                    success: function (result) {
                        if (result.parameters) {
                            that.parameters = result.parameters;
                            that.$nextTick(function () {
                                $('select').show();
                            });
                        }
                    }
                })
            },
            updateSelect: function (parameterKey) {
                var value = $(`#${parameterKey}`).val();
                this.parameters[parameterKey].value = value;
            },
            store: function () {
                var that = this;
                var url = $('#parameters-update').val();
                var data = that.getStoreData();
                axios.post(url, data, {})
                        .then(function (response) {
                            if (response.data.status == 'fail') {
                                alert('更新失敗');
                                return;
                            }
                            if (response.data.parameters) {
                                alert('更新成功');
                                console.log(response.data);
                                that.parameters = response.data.parameters;
                                that.$nextTick(function () {
                                    $('select').show();
                                });
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
            },
            getStoreData: function () {
                var that = this;
                var data = {};
                Object.keys(that.parameters).forEach(function (key) {
                    data[key] = that.parameters[key].value;
                });
                console.log(data);
                return data;
            }
        }
    })
</script>
</body>
</html>
