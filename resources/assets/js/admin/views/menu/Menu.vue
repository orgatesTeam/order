<template>
    <div>
        <div class="section no-pad-bot" id="index-banner">
            <div class="container">
                <div class="section">
                    <table class="highlight responsive-table">
                        <thead>
                        <tr>
                            <th>菜單名稱</th>
                            <th>價格</th>
                            <th>種類</th>
                            <th>口味</th>
                            <th>建立時間</th>
                            <th>更新時間</th>
                            <th>
                                <div class="section">
                                    <div @click="create()">
                                        <mt-palette-button content="+"
                                                           mainButtonStyle="color:#fff;background-color:#26a2ff;">
                                            <div class="my-icon-button"></div>
                                            <div class="my-icon-button"></div>
                                            <div class="my-icon-button"></div>
                                        </mt-palette-button>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="menu,index in menus">
                            <td>{{menu.name}}</td>
                            <td>{{menu.price}}</td>
                            <td>{{menu.type}}</td>
                            <td>
                                <div class="tastes">
                                    <a class="waves-effect tabs btn orange" @click="showTastes(menu)">{{getTastesCount(menu.taste_ids)}}種</a>
                                </div>
                            </td>
                            <td>{{menu.created_at}}</td>
                            <td>{{menu.updated_at}}</td>
                            <td>
                                <a class="waves-effect waves-light btn" @click="edit(index)">編輯</a>
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
    import {fetchList as fetchTastes} from "../../api/taste"

    import $ from 'jquery'

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
            this.$store.commit('setFormTitle', '菜單管理')
            this.getMenus()
            this.getTastes()
        },
        computed: {
            mapTastes() {
                let mapTastes = {}
                this.tastes.forEach(taste => {
                    mapTastes[taste.id] = taste
                })
                return mapTastes
            },
            tastes() {
                return this.$store.state.taste.tastes
            }
        },
        methods: {
            getMenus(callback) {
                let that = this
                let page = that.$store.state.menu.page
                if (that.$store.state.menu.cacheMenus[page]) {
                    that.pushMenus(that.$store.state.menu.cacheMenus[page])
                    if (callback) {
                        callback()
                    }
                    return
                }

                let data = {page: page}
                fetchList(data).then(response => {
                    if (response.data.code == 202) {
                        console.log(response)
                        let menus = response.data.items.menus
                        that.pushMenus(menus)
                        that.$store.commit('setCacheMenus', {page: page, menus: menus})
                        if (callback) {
                            callback()
                        }
                    }
                })
            },
            pushMenus(menus) {
                this.menus = menus.data
                this.paginate.pageCount = menus.last_page;
                this.paginate.currentPage = menus.current_page;
                this.total = menus.total;
            },
            clickPage: function (pageNum) {
                this.paginate.currentPage = pageNum;
                this.$store.commit('setMenuPage', pageNum)
                this.getMenus(() => {
                    Toast({
                        message: `切換到第${pageNum}頁`,
                        position: 'middle',
                        duration: 800
                    });
                });
            },
            edit: function (index) {
                let menu = Object.assign({}, this.menus[index])
                this.$store.commit('setEditMenu', menu)
                this.$router.push({name: 'menu-edit', query: {from: 'edit'}})
            },
            create: function () {
                this.$store.commit('setEditMenu', null)
                this.$router.push({name: 'menu-edit', query: {from: 'create'}})
            },
            getTastes() {
                let that = this
                if (this.tastes === null) {
                    fetchTastes({}).then(response => {
                        if (response.data.code == '202') {
                            let tastes = response.data.items.tastes
                            that.$store.commit('setTastes', tastes)
                        }
                    })
                }
            },
            getTastesCount(tasteIDs) {
                if (!tasteIDs) {
                    return 0
                }

                return tasteIDs.split(',').length
            },
            showTastes(menu) {
                if (!menu.taste_ids) {
                    return
                }

                let tasteIds = this.parseTastes(menu.taste_ids)
                let showTastes = []

                tasteIds.forEach(taste => {
                    showTastes.push({
                        text: taste.name
                    })
                })
                $.confirm({
                    closeIcon: true,
                    type: 'orange',
                    title: `${menu.name} 口味選擇類型:`,
                    content: ' ',
                    typeAnimated: true,
                    buttons: showTastes
                })
            },
            parseTastes(tasteIDs) {
                if (!tasteIDs) {
                    return []
                }

                let tasteIds = tasteIDs.split(',')
                let tastes = []

                tasteIds.forEach(id => {
                    tastes.push(this.mapTastes[id])
                })
                return tastes
            }
        }
    }
</script>
<style scoped>
    .tastes {
        display: inline-block;
        margin: 0 2px 0 2px;
    }
</style>