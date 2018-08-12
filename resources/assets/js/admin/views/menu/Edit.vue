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
                    <div @click="triggerMenuTypes=true" >
                        <mt-field label="種類" v-model="editMenu.type" class="unselectable"></mt-field>
                    </div>
                </div>
                <mt-button :disabled="!canStoreEdit" type="primary" size="large" @click="editStore">儲存</mt-button>
            </mt-tab-container-item>
            <mt-tab-container-item id="create">
                <div class="section">
                    <mt-field label="菜單名稱" v-model="createMenu.name"></mt-field>
                    <mt-field label="價格" type="number" v-model="createMenu.price"></mt-field>
                    <div @click="triggerMenuTypes=true">
                        <mt-field label="種類" v-model="createMenu.type" class="unselectable"></mt-field>
                    </div>
                </div>
                <mt-button :disabled="!canStoreCreate" type="primary" size="large" class="store">儲存</mt-button>
            </mt-tab-container-item>
            <mt-actionsheet
                    :actions="actionMenuTypes"
                    v-model="triggerMenuTypes">
            </mt-actionsheet>
        </mt-tab-container>
    </div>
</template>
<style scope>
    label {
        color: #ffffff;
    }
</style>
<script>
    import {Field} from 'mint-ui';
    import {Navbar, TabItem} from 'mint-ui';
    import {fetchMenuTypes, updateMenu} from '../../api/menu'
    import {Actionsheet} from 'mint-ui';
    import {Button} from 'mint-ui';
    import {Toast} from 'mint-ui';

    export default {
        name: "Edit",
        comments: [Field.name, Field, Navbar.name, Navbar, TabItem.name, TabItem, Button.name, Button],
        data() {
            return {
                triggerMenuTypes: false,
                //用來比對是否資料變更
                originEditMenu: {},
                editMenu: {
                    name: '',
                    price: '',
                    type: '',
                },
                createMenu: {
                    name: '',
                    price: '',
                    type: '',
                    menu_type_id: ''
                },
                mode: '',
                menuTypes: [],
                editErrors: [],
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
                return this.mode === 'edit'
            },
            createMode() {
                return this.mode === 'create'
            },
            canStoreEdit() {
                let status = false
                //判斷跟資料是否差異,儲存按鈕開啟
                for (let key in this.originEditMenu) {
                    if (this.originEditMenu[key] != this.editMenu[key]) {
                        console.log({ori: this.originEditMenu[key], edit: this.editMenu[key]})
                        status = true;
                    }
                }
                return status;
            },
            canStoreCreate() {

            }
        },
        watch: {
            mode() {

                //設定選單 title
                if (this.editMode) {
                    this.$store.commit('setFormTitle', '編輯菜單')
                }
                if (this.createMode) {
                    this.$store.commit('setFormTitle', '新增菜單')
                }
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
            } else {
                this.mode = 'create'
            }

            //取得菜單種類
            this.getMenuTypes()
        },
        methods: {
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
            editStore() {
                let that = this
                let {id, name, price, menu_type_id} = this.editMenu
                let data = {
                    id: id,
                    name: name,
                    price: price,
                    menu_type_id: menu_type_id
                }
                updateMenu(data).then(response => {
                    if (response.data.code == '202') {
                        Toast({
                            message: '操作成功',
                            iconClass: 'icon icon-success'
                        });
                        that.$router.push({name: 'menu'})
                    }
                })
                console.log('store')
            },
            createStore() {

            }
        }
    }
</script>

<style scoped>

</style>