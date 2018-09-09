<template>
    <div>
        <div class="container">
            <div class="section">
                <mt-field label="菜單名稱" v-model="menu.name"></mt-field>
                <mt-field label="價格" type="tel" v-model="menu.price"></mt-field>
                <div @click="triggerMenuTypes=true">
                    <mt-field label="種類" v-model="menu.type" class="unselectable"></mt-field>
                </div>
                <mt-checklist
                        title='添加口味'
                        v-model="checkTasteIDs"
                        :options=optionTastesFormatter(tastes)>
                </mt-checklist>
            </div>
            <mt-button :disabled="!canStore" type="primary" size="large" @click="store()">儲存</mt-button>
            <mt-actionsheet
                    :actions="actionMenuTypes"
                    v-model="triggerMenuTypes">
            </mt-actionsheet>

        </div>
    </div>
</template>

<script>
    import {updateMenu, createMenu} from '../../api/menu'
    import {getMenuTypes} from "../../cache/menu";
    import {getTastes} from "../../cache/taste";
    import {Toast} from 'mint-ui';

    export default {
        name: "Edit",
        data() {
            return {
                //菜單種類彈窗
                triggerMenuTypes: false,
                menu: {
                    name: '',
                    price: '',
                    type: '',
                    menu_type_id: '',
                    tasteIds: ''
                },

                menuTypes: [],

                editErrors: [],
                tastes: [],
                checkTasteIDs: [],
                originMenu: {}
            }
        },
        mounted() {

            this.$store.commit('setFormTitle', `新增菜單`)

            //取得菜單種類
            this.getMenuTypes()

            //取得口味
            this.getTastes()

            //編輯帶入資料
            this.editInit()
        },
        computed: {
            mode() {
                let edit = this.$store.state.menu.editMenu
                if (edit) {
                    return 'edit'
                }
                return 'create'
            },
            actionMenuTypes() {
                let types = []
                let that = this
                this.menuTypes.forEach((item) => {
                    types.push({
                        name: item.name, method: () => {
                            that.selectMenuType(item)
                        }
                    })
                })
                return types
            },
            canEdit() {

                if (!this.mode == 'edit') {
                    return false
                }

                //判斷跟資料是否差異,儲存按鈕開啟
                for (let key in this.originMenu) {
                    if (this.originMenu[key] != this.menu[key]) {
                        return true;
                    }
                }

                if (this.originMenu.taste_ids && JSON.stringify(this.checkTasteIDs.sort()) != JSON.stringify(this.originMenu.taste_ids.split(',').sort())) {
                    return true;
                }

                return false;
            },
            canCreate() {
                return true
            },
            canStore() {
                if (this.mode == 'edit') {
                    return this.canEdit
                }
                return this.canCreate
            }
        },
        watch: {
            checkTasteIDs() {
                let sortCheckIDs = Object.assign([], this.checkTasteIDs)
                this.menu.taste_ids = sortCheckIDs.sort().join()
            }
        },
        methods: {
            selectMenuType(type) {
                this.menu.type = type.name
                this.menu.menu_type_id = type.id
            },
            editInit() {
                let menu = this.$store.state.menu.editMenu
                if (menu) {
                    this.originMenu = Object.assign(menu)
                    this.menu = {...menu}
                    this.$store.commit('setFormTitle', `編輯菜單-${menu.name}`)
                    if (this.menu.taste_ids) {
                        this.checkTasteIDs = this.menu.taste_ids.split(',')
                    }
                }
            },
            getTastes() {
                let that = this
                getTastes(tastes => {
                    that.tastes = tastes
                })
            },
            getMenuTypes() {
                let that = this
                getMenuTypes(menuTypes => {
                    that.menuTypes = menuTypes
                })
            },
            store() {
                if (this.mode == 'edit') {
                    this.storeEditMenu()
                } else {
                    this.storeCreateMenu()
                }

            },
            storeEditMenu() {
                let that = this
                updateMenu(this.menu).then(response => {
                    if (response.data.code == '202') {
                        Toast({
                            message: '操作成功',
                            iconClass: 'icon icon-success'
                        });
                        that.refreshCacheMenus()
                        that.$router.push({name: 'menu'})
                    }
                })
            },
            storeCreateMenu() {
                let that = this

                createMenu(this.menu).then(response => {
                    if (response.data.code == '202') {
                        Toast({
                            message: '操作成功',
                            iconClass: 'icon icon-success'
                        });
                        that.refreshCacheMenus()
                        that.$router.push({name: 'menu'})
                    }
                })
            },
            refreshCacheMenus() {
                this.$store.commit('refreshMenus')
            },
            optionTastesFormatter(tastes) {
                console.log(tastes)
                let formatter = []
                tastes.forEach((taste) => {
                    let newTaste = {
                        label: taste.name,
                        value: taste.id
                    }
                    formatter.push(newTaste)
                })
                return formatter
            }
        }
    }
</script>

<style scoped>
    label {
        color: #ffffff;
    }

    .mint-cell-wrapper {
        display: none;
    }
</style>