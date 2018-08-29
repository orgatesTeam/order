<template>
    <div>
        <mt-navbar v-model="mode">
            <mt-tab-item id="edit">編輯</mt-tab-item>
            <mt-tab-item id="create">新增</mt-tab-item>
        </mt-navbar>

        <!-- tab-container -->
        <mt-tab-container v-model="mode">
            <mt-tab-container-item id="edit">
                <div class="section">
                    <mt-field label="菜單名稱" v-model="editMenu.name"></mt-field>
                    <mt-field label="價格" type="tel" v-model="editMenu.price"
                              :state="editPriceError"></mt-field>
                    <div @click="triggerMenuTypes=true">
                        <mt-field label="種類" v-model="editMenu.type" class="unselectable"></mt-field>
                    </div>
                    <mt-checklist
                            title='添加口味'
                            v-model="checkTasteIDs"
                            :options=optionTastesFormatter(tastes)>
                    </mt-checklist>
                </div>
                <mt-button :disabled="!canStoreEdit" type="primary" size="large" @click="storeEditMenu()">儲存</mt-button>
            </mt-tab-container-item>
            <mt-tab-container-item id="create">
                <div class="section">
                    <mt-field label="菜單名稱" v-model="createMenu.name"></mt-field>
                    <mt-field label="價格" type="number" v-model="createMenu.price"></mt-field>
                    <div @click="triggerMenuTypes=true">
                        <mt-field label="種類" v-model="createMenu.type" class="unselectable"></mt-field>
                    </div>
                    <mt-checklist
                            title='添加口味'
                            v-model="checkTasteIDs"
                            :options=optionTastesFormatter(tastes)>
                    </mt-checklist>
                </div>
                <mt-button :disabled="!canStoreCreate" type="primary" size="large" @click="storeCreateMenu()">儲存
                </mt-button>
            </mt-tab-container-item>
            <mt-actionsheet
                    :actions="actionMenuTypes"
                    v-model="triggerMenuTypes">
            </mt-actionsheet>
        </mt-tab-container>
    </div>
</template>

<script>
    import {fetchMenuTypes, updateMenu, createMenu} from '../../api/menu'
    import {Toast} from 'mint-ui';
    import {fetchList as fetchTastes} from "../../api/taste"

    export default {
        name: "Edit",
        data() {
            return {
                //菜單種類彈窗
                triggerMenuTypes: false,
                //用來比對是否資料變更
                originEditMenu: {},
                editMenu: {
                    name: '',
                    price: '',
                    type: '',
                    menu_type_id: '',
                    tasteIDs: ''
                },
                createMenu: {
                    name: '',
                    price: '',
                    type: '',
                    menu_type_id: '',
                    tasteIDs: ''
                },
                mode: '',
                menuTypes: [],
                editErrors: [],

                tastes: [],
                checkTasteIDs: []
            }
        },
        computed: {
            editPriceError() {
                if (this.editMenu.price > 3000) {
                    return 'error';
                }
                return 'success'
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
            editMode() {
                return this.$store.state.menu.editMenu instanceof Object && this.mode == 'edit'
            },
            createMode() {
                return this.mode === 'create'
            },
            canStoreEdit() {

                if (!this.editMode) {
                    return false
                }

                let status = false
                //判斷跟資料是否差異,儲存按鈕開啟
                for (let key in this.originEditMenu) {
                    if (this.originEditMenu[key] != this.editMenu[key]) {
                        console.log({ori: this.originEditMenu[key], edit: this.editMenu[key]})
                        status = true;
                    }
                }
                if (JSON.stringify(this.checkTasteIDs) != JSON.stringify(this.originEditMenu.taste_ids.split(','))) {
                    status = true;
                }
                return status;
            },
            canStoreCreate() {

                let menu = this.createMenu

                if (menu.menu_type_id < 1) {
                    return false
                }

                if (menu.name == '') {
                    return false
                }

                if (menu.price < 1) {
                    return false
                }
                return true
            }
        },
        watch: {
            mode() {

                //設定選單 title
                if (this.editMode) {
                    this.$store.commit('setFormTitle', '編輯菜單')
                    return
                }
                if (this.createMode) {
                    this.$store.commit('setFormTitle', '新增菜單')
                    return
                }
            },
            checkTasteIDs() {
                let sortCheckIDs = Object.assign([], this.checkTasteIDs)
                this.createMenu.tasteIDs = sortCheckIDs.sort().join()
            }
        },
        mounted() {
            this.mode = this.$route.query.from;

            //預設值
            if (this.mode === '') {
                this.mode = 'create'
            }

            //有編輯 menu 帶入
            if (this.$store.state.menu.editMenu) {
                this.editMenu = this.$store.state.menu.editMenu
                this.originEditMenu = Object.assign({}, this.editMenu)
                this.checkTasteIDs = this.editMenu.taste_ids.split(',')
            } else {
                this.mode = 'create'
            }

            //取得菜單種類
            this.getMenuTypes()

            //取得口味
            this.getTastes()
        },
        methods: {
            getTastes() {
                let tastes = this.$store.state.taste.tastes
                let that = this
                if (tastes.length > 0) {
                    that.tastes = tastes
                    return
                }

                fetchTastes({}).then(response => {
                    if (response.data.code == '202') {
                        tastes = response.data.items.tastes
                        that.$store.commit('setTastes', tastes)
                        that.tastes = tastes
                    }
                })
            },
            selectMenuType(item) {
                if (this.editMode) {
                    this.editMenu.type = item.name
                    this.editMenu.menu_type_id = item.id
                }

                if (this.createMode) {
                    this.createMenu.type = item.name
                    this.createMenu.menu_type_id = item.id
                }
            },
            getMenuTypes() {
                let that = this
                fetchMenuTypes({}).then(response => {
                    console.log(response)
                    that.menuTypes = (response.data.items.menuTypes)
                })
            },
            storeEditMenu() {
                let that = this
                let {id, name, price, menu_type_id, tasteIDs} = this.editMenu
                let data = {
                    id: id,
                    name: name,
                    price: price,
                    menu_type_id: menu_type_id,
                    taste_ids: tasteIDs
                }
                updateMenu(data).then(response => {
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
                let {name, price, menu_type_id, tasteIDs} = this.createMenu
                let data = {
                    name: name,
                    price: price,
                    menu_type_id: menu_type_id,
                    taste_ids: tasteIDs
                }
                createMenu(data).then(response => {
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
                this.$store.commit('resetMenus')
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