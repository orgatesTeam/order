@extends('super.layouts.template')

@section('title', '帳號管理(列表)')

@section('content')
    <!-- Modal Trigger -->

    <!-- Modal Structure -->
    <div v-show="modalShow">
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4>Modal Header</h4>
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="col s12">
                                <label>帳號</label>
                                <input v-model="modalUser.email" id="modalEmail" type="text">
                            </div>
                            <div class="col s6">
                                <label>姓名</label>
                                <input v-model="modalUser.name" id="modalName" type="text">
                            </div>
                            <div class="col s6">
                                <label>啟用</label>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in"
                                               :checked="modalUser.enable==1?'checked':''"/>
                                        <span>Filled in</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">關閉</a>
            </div>
        </div>
    </div>



    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <div class="section">
                <p> @{{ '總數:'+ total }}</p>
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
@endsection
@section('js')
    <script>
        var vm = new Vue({
            el: '#app',
            data: {
                users: {},
                paginate: {
                    pageCount: 1,
                    currentPage: 1,
                    range: 5,
                },
                total: 0,
                modalUser: {},
                modalShow: false
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
                },
                edit: function (index) {
                    this.modalShow = false;
                    this.modalShow = true;
                    var user = this.users[index];
                    this.modalUser = user;
                }
            }
        })

        $(document).ready(function () {
            $('.modal').modal();
        });
    </script>
@endsection