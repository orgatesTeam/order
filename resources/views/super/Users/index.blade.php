@extends('super.layouts.template')

@section('title', '帳號管理')

@section('content')
    <!-- Modal Trigger -->

    <!-- Modal Structure -->
    <div v-show="modalShow">
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4 v-html="modalActiveMode == 'add' ? '新增':'修改'"></h4>
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="col s12">
                                <label>帳號</label>
                                <p class="text-danger" v-if="errors.email">@{{ errors.email }}</p>
                                <input v-model="modalUser.email" id="modalEmail" type="text"
                                       @keyup="checkValueExist('email',modalUser)">
                            </div>
                            <div class="col s12" v-if="modalActiveMode == 'add'">
                                <label>密碼</label>
                                <p class="text-danger" v-if="errors.password">@{{ errors.password }}</p>
                                <input v-model="modalUser.password" id="modalPassword" type="password">
                            </div>
                            <div class="col s6">
                                <label>姓名</label>
                                <p class="text-danger" v-if="errors.name">@{{ errors.name }}</p>
                                <input v-model="modalUser.name" id="modalName" type="text"
                                       @keyup="checkValueExist('name',modalUser)">
                            </div>
                            <div class="col s6">
                                <label>啟用</label>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in"
                                               @click="modalUser.enable = (modalUserEnable?'0':'1')"
                                               :checked="modalUserEnable ?'checked':''"/>
                                        <span>Filled in</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="waves-effect waves-green btn-flat" @click="store()" :disabled="!canStore">儲存</a>
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">關閉</a>
            </div>
        </div>
    </div>



    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <div class="section">
                <p>
                    <a class="waves-effect waves-light btn modal-trigger btn-floating btn red  pulse"
                       href="#modal1" @click="add()">
                        <i class="material-icons">add</i>
                    </a>
                    <span> @{{ '總數:'+ total }}</span>
                </p>
            </div>
            <div class="section">
                <table class="highlight responsive-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>姓名</th>
                        <th>帳號</th>
                        <th>啟用狀態</th>
                        <th>建立時間</th>
                        <th>更新時間</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user,index in users">
                        <td>@{{ user.id }}</td>
                        <td>@{{ user.name }}</td>
                        <td>@{{ user.email }}</td>
                        <td>@{{ user.enable == 1 ? '啟用':'關閉' }}</td>
                        <td>@{{ user.created_at }}</td>
                        <td>@{{ user.updated_at }}</td>
                        <td>
                            <a class="waves-effect waves-light btn modal-trigger btn-floating btn cyan pulse"
                               href="#modal1" @click="edit(index)">
                                <i class="material-icons">edit</i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <paginate
                    :page-count="paginate.pageCount"
                    :click-handler="clickPage"
                    :prev-text="'上一頁'"
                    :next-text="'下一頁'"
                    :container-class="'pagination'"
                    :value="paginate.currentPage"
                    :page-range="paginate.range"
            >
            </paginate>
        </div>
    </div>
    <input type="hidden" id="users-ajax-list" value="{{route('super.users.ajax.list')}}">
    <input type="hidden" id="check-value-exist" value="{{route('super.users.ajax.check')}}">
    <input type="hidden" id="store" value="{{route('super.users.ajax.store')}}">

@endsection
@section('js')
    <script>
        var vm = new Vue({
            el: '#app',
            data: {
                errors: {
                    name: '',
                    email: ''
                },
                users: {},
                userIndex: null,
                paginate: {
                    pageCount: 1,
                    currentPage: 1,
                    range: 5,
                },
                total: 0,
                modalUser: {
                    email: '',
                    name: '',
                    enable: 1,
                    password: ''
                },
                modalShow: false,
                modalActiveMode: '',
                queue: null,
            },
            mounted: function () {
                this.getList(1);
            },
            methods: {
                getList: function (page) {
                    var that = this;
                    var url = $('#users-ajax-list').val();
                    $.ajax({
                        url: url,
                        type: 'get',
                        data: {page: page},
                        success: function (response) {
                            if (response.code == 202) {
                                var users = response.items.users;
                                that.users = users.data;
                                that.paginate.pageCount = users.last_page;
                                that.paginate.currentPage = users.current_page;
                                that.total = users.total;
                            }
                        }
                    })
                },
                clickPage: function (pageNum) {
                    this.paginate.currentPage = pageNum;
                    this.getList(pageNum);
                    M.toast({html: `切換到第${pageNum}頁`});
                },
                openTop() {
                    this.$toast.top('top');
                },
                checkValueExist: function (column, user) {
                    var that = this;
                    clearTimeout(this.queue);
                    this.queue = setTimeout(function () {
                        var url = $('#check-value-exist').val();
                        var repeatMessages = {
                            name: '姓名已重複',
                            email: '帳號已重複'
                        };

                        $.ajax({
                            'url': url,
                            'method': 'get',
                            data: {
                                column: column,
                                value: user[column],
                                id: user.id
                            },
                            'success': function (response) {
                                if (response.code != '202') {
                                    alert('錯誤');
                                }

                                if (response.items.exist) {
                                    that.errors[column] = repeatMessages[column];
                                    return;
                                }

                                that.errors[column] = '';
                            }
                        });
                    }, 500);
                },
                refreshAndShowModal: function () {
                    this.modalShow = false;
                    this.modalShow = true;
                },
                add: function () {
                    this.modalActiveMode = 'add';
                    this.refreshAndShowModal();
                },
                edit: function (index) {
                    this.modalActiveMode = 'edit';
                    this.refreshAndShowModal();
                    //避免 object reference
                    var user = Object.assign({}, this.users[index]);
                    this.modalUser = user;
                    this.userIndex = index;
                },
                store: function () {
                    var that = this;
                    var storeData = this.modalUser;
                    var url = $('#store').val();

                    axios.post(url, {
                        ...storeData
                    }, {})
                        .then(function (response) {
                            response = response.data;
                            if (response.code != 202) {
                                M.toast({html: '請求失敗'});
                                return;
                            }

                            if (that.modalActiveMode == 'add') {
                                location.reload();
                            }

                            if (that.modalActiveMode == 'edit') {
                                that.users[that.userIndex] = response.items;
                            }

                            M.toast({html: '請求成功'});
                            that.modalShow = false;

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            computed: {
                canStore: function () {
                    return this.errors.name == '' && this.errors.email == '';
                },
                modalUserEnable: function () {
                    return this.modalUser.enable == 1;
                }
            },
            watch: {
                modalActiveMode: function () {
                    if (this.modalActiveMode == 'add') {
                        this.modalUser = {
                            email: ' ',
                            name: '',
                            enable: 1,
                            password: ''
                        };
                    }
                }
            }
        })

        $(document).ready(function () {
            $('.modal').modal();
        });
    </script>
@endsection