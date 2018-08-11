<template>
    <div>
        <div class="section no-pad-bot" id="index-banner">
            <div class="container">
                <div class="section">
                    <table class="highlight responsive-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>菜單名稱</th>
                            <th>價格</th>
                            <th>種類</th>
                            <th>建立時間</th>
                            <th>更新時間</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="menu,index in menus">
                            <td>{{menu.id}}</td>
                            <td>{{menu.name}}</td>
                            <td>{{menu.price}}</td>
                            <td>{{menu.menu_type_id}}</td>
                            <td>{{menu.created_at}}</td>
                            <td>{{menu.updated_at}}</td>
                            <td>
                                <a class="waves-effect waves-light btn modal-trigger btn-floating btn cyan pulse" @click="edit(index)">
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
    </div>
</template>

<script>
    import {fetchList} from '../../api/menu'
    import {Toast} from 'mint-ui';

    let Paginate = require('vuejs-paginate')
    export default {
        name: "Menu",
        components: {Paginate},
        data() {
            return {
                errors: '',
                menus: {},
                total: 0,
                paginate: {
                    pageCount: 1,
                    currentPage: 1,
                    range: 5,
                },
            }
        },
        mounted() {
            this.$store.commit('setFormTitle','菜單管理')
            this.getMenus(this)
        },
        methods: {
            getMenus: (that) => {
                let data = {page: that.$store.state.menu.page}
                fetchList(data).then(response => {
                    console.log(response)
                    that.menus = (response.data.items.menus.data)
                    let menus = response.data.items.menus;
                    that.paginate.pageCount = menus.last_page;
                    that.paginate.currentPage = menus.current_page;
                    that.total = menus.total;
                })
            },
            clickPage: function (pageNum) {
                this.paginate.currentPage = pageNum;
                this.$store.commit('setMenuPage', pageNum)
                this.getMenus(this);
                Toast({
                    message: `切換到第${pageNum}頁`,
                    position: 'bottom',
                    duration: 2000
                });
            },
            edit: function (index) {
                let menu = Object.assign({}, this.menus[index])
                this.$store.commit('setEditMenu', menu)
                // 命名的路由
                this.$router.push({ name: 'menu-edit'})
            },
        }
    }
</script>