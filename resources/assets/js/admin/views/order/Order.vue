<template>
    <div>
        <div class="sticky">
            <div class="mint-navbar">
                <a class="mint-tab-item" :class="isSelected('order')" @click="setSelected('order')">
                    <div class="mint-tab-item-icon"></div>
                    <div class="mint-tab-item-label">點餐</div>
                </a>
                <a class="mint-tab-item" :class="isSelected('preview')" @click="setSelected('preview')">
                    <div class="mint-tab-item-icon"></div>
                    <div class="mint-tab-item-label">預覽調整</div>
                </a>
                <a class="mint-tab-item" :class="isSelected('total')" @click="setSelected('total')">
                    <div class="mint-tab-item-icon"></div>
                    <div class="mint-tab-item-label">總結</div>
                </a>
            </div>
        </div>

        <div class="sticky-container">

        </div>

        <!-- tab-container -->
        <div :class="selectedClass('order')">
            <div class="section select-store">
                <div>
                    <div @click="storeActionSheet = true" class="inline-dev">
                        <mt-button type="danger">選點店家</mt-button>
                    </div>
                    <div @click="selectTable()" class="inline-dev">
                        <mt-button type="primary">選點桌號</mt-button>
                    </div>
                    <div v-if="tableNo > 0" class="inline-dev">
                        <mt-button type="default">桌號:{{tableNo}}</mt-button>
                    </div>
                    <div v-if="checkMenuCount > 0" class="inline-dev">
                        <mt-button type="default">選項:{{checkMenuCount}}</mt-button>
                    </div>
                </div>
            </div>
            <div v-show="canOrder" class="order">
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
                        :actions="storeActions"
                        v-model="storeActionSheet">
                </mt-actionsheet>
            </div>

        </div>
        <div :class="selectedClass('preview')">
            <preview></preview>
        </div>
    </div>
</template>

<script>
    import {getStores} from "../../cache/storeManager";
    import {getStoreMenus} from "../../cache/menu";
    import {getMenuTypes} from "../../cache/menu";
    import $ from 'jquery'
    import Preview from './Preview'

    export default {
        name: "Order",
        components: {Preview},
        data() {
            return {
                selected: 'order',
                checkMenus: [],
                storeActionSheet: false,
                storeActions: [],
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
            getStores(stores => {
                stores.forEach((store) => {
                    that.storeActions.push({
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
            })
        },
        computed: {
            canOrder() {
                return this.tableNo > 0
            },
            checkMenuCount() {
                return this.checkMenus.length
            },
        },
        watch: {
            checkMenuCount() {
                this.$store.commit('setOrderMenus', this.checkMenus)
            }
        },
        methods: {
            selectedClass(selected) {
                return this.selected == selected ? 'show' : 'not-show'
            },
            isSelected(selected) {
                return this.selected == selected ? 'is-selected' : ''
            },
            setSelected(selected) {
                this.selected = selected
            },
            getMenus(callback) {
                let that = this
                getMenuTypes(menuTypes => {
                    that.menuTypes = menuTypes
                })
                getStoreMenus(menus => {
                    that.menus = menus
                    callback()
                }, this.selectStore.id)
            },
            //選擇店家 hook
            afterSelectedStore() {
                let that = this
                that.checkMenus = []
                this.getMenus(() => {

                    //未匯入菜單
                    if (that.menus.length < 1) {
                        return that.toImportMenu()
                    }
                    //選擇桌位
                    that.selectTable()
                })

            },
            //選擇店家 hook
            beforeSelectedStore() {
                this.tableNo = ''
            },
            toImportMenu() {
                let store = this.selectStore
                let that = this
                $.confirm({
                    title: '提醒! 店家未匯入菜單',
                    content: `前往『${store.name}』店家管理匯入菜單`,
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        go: {
                            text: '前往',
                            btnClass: 'btn-red',
                            action: function () {
                                that.$store.commit('setStoreToImportMenu', store)
                                that.$router.push({name: 'store-import-menu'})
                            }
                        },
                        close: {
                            text: '取消',
                            action: function () {
                            }
                        }
                    }
                });
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
    .show {
        display: block;
    }

    .not-show {
        display: none;
    }

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