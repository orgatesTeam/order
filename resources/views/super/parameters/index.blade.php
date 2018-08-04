@extends('super.layouts.template')

@section('title', '參數管理')

@section('content')
    <div>
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
                this.getParameters();
            },
            methods: {
                getParameters: function () {
                    var that = this;
                    var url = $('#parameters-all').val();
                    $.get({
                        url: url,
                        success: function (result) {
                            if (result.items) {
                                that.parameters = result.items;
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
                            if (response.data.errors) {
                                alert('更新失敗');
                                return;
                            }
                            if (response.data.items) {
                                alert('更新成功');
                                console.log(response.data.items);
                                that.parameters = response.data.items;
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
@endsection