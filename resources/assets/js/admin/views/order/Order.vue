<template>
    <div>
        <div class="sticky">
            <mt-navbar v-model="selectedNavbar">
                <mt-tab-item id="order">點餐</mt-tab-item>
                <mt-tab-item id="preview">預覽調整</mt-tab-item>
                <mt-tab-item id="3">總結</mt-tab-item>
            </mt-navbar>
        </div>

        <div class="sticky-container">

        </div>

        <!-- tab-container -->
        <mt-tab-container v-model="selectedNavbar">

            <mt-tab-container-item id="order">
                <div class="section select-store">
                    <div>
                        <div @click="storesVisible = true" class="inline-dev">
                            <mt-button type="danger">選點店家</mt-button>
                        </div>
                        <div @click="selectTable()" class="inline-dev">
                            <mt-button type="primary">選點桌號</mt-button>
                        </div>
                        <div v-if="tableNo > 0" class="inline-dev">
                            <mt-button type="default">{{tableNo}}桌</mt-button>
                        </div>
                        <div v-if="checkMenuCount > 0" class="inline-dev">
                            <mt-button type="default">點選:{{checkMenuCount}}</mt-button>
                        </div>
                    </div>
                </div>
                <div v-if="canOrder" class="order">
                    <div v-for="typeMenus,typeID in menus">
                        <mt-checklist
                                :title=menuTypeName(typeID)
                                v-model="checkMenus"
                                :options=optionFormatter(typeMenus)>
                        </mt-checklist>
                    </div>
                </div>
                <div>
                    <mt-actionsheet
                            :actions="actions"
                            v-model="storesVisible">
                    </mt-actionsheet>
                </div>
            </mt-tab-container-item>

            <mt-tab-container-item id="preview">
                <preview></preview>
            </mt-tab-container-item>

        </mt-tab-container>


    </div>
</template>

<script>
    import {fetchList} from '../../api/store'
    import {listByStore} from '../../api/menu'
    import $ from 'jquery'
    import Preview from './Preview'

    export default {
        name: "Order",
        components: {Preview},
        data() {
            return {
                selectedNavbar: 'order',
                checkMenus: [],
                storesVisible: false,
                actions: [],
                selectStore: {
                    name: '',
                    id: '',
                    tableTotal: 0
                },
                tableNo: 0,
                menuTypes: null,
                menus: []
            }
        },
        mounted() {
            console.log(Preview)
            this.$store.commit('setFormTitle', `點餐管理`)
            let that = this
            fetchList({}).then(response => {
                if (response.data.code == 202) {
                    console.log(response)
                    let stores = response.data.items.stores
                    stores.forEach((store) => {
                        that.actions.push({
                            name: store.name,
                            method: () => {
                                that.beforeSelectedStore()
                                that.selectStore.id = store.id
                                that.selectStore.name = store.name
                                that.selectStore.tableTotal = store.table_total
                                that.$store.commit('setFormTitle', `${store.name}-點餐管理`)
                                that.afterSelectedStore()
                            }
                        })
                    })
                }
            })
        },
        computed: {
            canOrder() {
                return this.tableNo > 0
            },
            checkMenuCount() {
                return this.checkMenus.length
            }
        },
        watch: {
            checkMenuCount() {
                this.$store.commit('setOrderMenus', this.checkMenus)
            }
        },
        methods: {
            getMenus() {
                let that = this
                let data = {store_id: this.selectStore.id}
                listByStore(data).then(response => {
                    if (response.data.code == 202) {
                        console.log(response)
                        that.menuTypes = response.data.items.menuTypes
                        that.menus = response.data.items.menus
                    }
                })
            },
            //hook
            afterSelectedStore() {
                this.selectTable()
                this.getMenus()
            },
            //hook
            beforeSelectedStore() {
                this.tableNo = ''

            },
            selectTable() {
                let storeName = this.selectStore.name
                let that = this
                let confirm = {
                    title: `店家: ${storeName}`,
                    content: '請選擇桌號:',
                    buttons: {
                        '取消': {
                            btnClass: 'btn-dark',
                            action: function () {
                            }
                        }
                    }
                }
                let range = this.selectStore.tableTotal
                Array.from({length: range}, (x, i) => {
                    let tableNo = i + 1
                    confirm.buttons[tableNo] = {
                        btnClass: 'btn-blue',
                        action: function () {
                            that.tableNo = tableNo
                        }
                    }
                });
                $.confirm(confirm);
            },
            menuTypeName(id) {
                let name = ''
                this.menuTypes.forEach((menuType) => {
                    if (id == menuType.id) {
                        name = menuType.name
                    }
                })
                return name
            },
            optionFormatter(menus) {
                console.log(menus)
                let formatter = []
                menus.forEach((menu) => {
                    let newMenu = {
                        label: `${menu.menu_name}    $${menu.menu_price}`,
                        value: {
                            id: menu.menu_id,
                            name: menu.menu_name,
                            price: menu.menu_price,
                            amount: 1
                        }
                    }
                    formatter.push(newMenu)
                })
                return formatter
            }
        }
    }
</script>

<style scoped>
    .select-store {
        padding-left: 20px;
    }

    .inline-dev {
        display: inline;
    }

    .order {
        overflow: auto;
    }

    .sticky {
        position: fixed;
        width: 100%;
        top: 49px;
        z-index: 99;
    }

    .sticky-container {
        width: 100%;
        height: 50px;
    }
</style>