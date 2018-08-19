<template>
    <div>
        <mt-search v-model="searchKey" :show="searchShow">
            <div v-show="haveSearchItems">
                <mt-cell title="全選">
                    <mt-switch v-model="switchAll"></mt-switch>
                </mt-cell>
            </div>
            <div v-for="menu in switchMenus">
                <mt-cell :title="menu.name" v-if="menu.show">
                    <mt-switch v-model="menu.isChecked"></mt-switch>
                </mt-cell>
            </div>
            <div class="btn" @click="save()">
                匯入
            </div>
            <div class="btn" @click="cancel()">
                取消
            </div>
        </mt-search>

    </div>
</template>

<script>
    import {Switch} from 'mint-ui';
    import {Cell} from 'mint-ui';
    import {Search} from 'mint-ui';
    import {listByStoreMenu} from '../../api/menu'
    import {addMenu} from '../../api/store'
    import $ from 'jquery'
    import {Toast} from 'mint-ui';

    export default {
        name: "ImportMenu",
        comments: [Switch.name, Switch, Cell.name, Cell, Search.name, Search],
        data() {
            return {
                searchKey: ' ',
                store: {},
                switchMenus: [],
                switchAll: false,
                searchShow: true
            }
        },
        watch: {
            searchKey(key) {
                this.switchMenus.forEach((menu) => {
                    if (menu.name.includes(key)) {
                        menu.show = true
                    } else {
                        menu.show = false
                    }
                })
            },
            switchAll(status) {
                let switchMenu = Object.keys(this.switchMenus)
                let that = this
                switchMenu.forEach((id) => {
                    that.switchMenus[id]['isChecked'] = status
                })
            }
        },
        mounted() {
            this.store = this.$store.state.storeManager.storeToImportMenu
            if (!this.store) {
                this.$router.push({name: 'store'})
                return
            }
            this.$store.commit('setFormTitle', `匯入${this.store.name}菜單`)
            this.listByStoreMenu()
        },
        computed: {
            haveSearchItems() {
                return Object.keys(this.switchMenus).length > 0
            }
        },
        methods: {
            listByStoreMenu() {
                let data = {store_id: this.store.id}
                listByStoreMenu(data).then(response => {
                    if (response.data.code == 202) {

                        let that = this
                        let menus = response.data.items.menus
                        let index = 0

                        menus.forEach((menu) => {
                            let isChecked = (menu.isChecked == 1)
                            let {name, menu_id} = menu
                            that.$set(that.switchMenus, index++, {
                                menu_id: menu_id,
                                isChecked: isChecked,
                                name: name,
                                show: true
                            })
                        })
                    }
                })
            },
            save() {
                let that = this
                let count = 0
                let menuIDs = ''
                this.switchMenus.forEach((menu) => {
                    if (menu.isChecked == true) {
                        count++
                        menuIDs += `${menu.menu_id},`
                    }
                })
                menuIDs = menuIDs.substr(0, menuIDs.length - 1)
                $.confirm({
                    title: '確定匯入!',
                    content: `總共匯入菜單有${count}個`,
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: '確定',
                            btnClass: 'btn-red',
                            action: function () {
                                let data = {store_id: that.store.id, menu_ids: menuIDs}
                                addMenu(data).then(response => {
                                    if (response.data.code == 202) {
                                        console.log(response)
                                        if (response.data.items.result == true) {
                                            Toast({
                                                message: `匯入成功!`,
                                                position: 'middle',
                                                duration: 800
                                            });
                                            that.$router.push({name: 'store'})
                                        }
                                    }
                                })
                            }
                        },
                        close: function () {
                        }
                    }
                });
            },
            cancel() {
                this.$router.push({name: 'store'})
            }
        }

    }
</script>

<style scoped>
    .btn {
        margin: 10px 5px 0 5px;
    }
</style>