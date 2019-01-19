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
                    <div class="mint-tab-item-label">總計</div>
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
            <div class="menu-options">
                <div v-for="typeMenus,typeID in menus">
                    <div @click="scrollTo(typeID)">
                        <mt-button type="primary">{{menuTypeName(typeID)}}</mt-button>
                    </div>
                </div>
            </div>
            <div v-show="canOrder" class="order" id="order">
                <div v-for="typeMenus,typeID in menus" :class="menuClass(typeID)">
                    <label class="mint-checklist-title">{{menuTypeName(typeID)}}</label>
                    <div v-for="menu in typeMenus" @click="addMenu(menu)">
                        <mt-cell-swipe :title="menu.menu_name+'  $'+menu.menu_price"></mt-cell-swipe>
                    </div>
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
        <div :class="selectedClass('total')">
            <total :position="position"></total>
        </div>
    </div>
</template>

<script>
    import {getStores} from "../../cache/storeManager";
    import {getStoreMenus} from "../../cache/menu";
    import {getMenuTypes} from "../../cache/menu";
    import $ from 'jquery'
    import Preview from './Preview'
    import Total from './Total';
    import {Toast} from 'mint-ui'

    export default {
        name: "Order",
        components: {Preview, Total},
        data() {
            return {
                selected: 'order',
                storeActionSheet: false,
                storeActions: [],
                selectStore: {
                    name: '',
                    id: '',
                    tableTotal: 0
                },
                tableNo: 0,
                menuTypes: null,
                menus: [],
            }
        },
        mounted() {
            console.log(Preview)
            this.$store.commit('setFormTitle', `點餐管理`)
            let that = this

            //上一次選的
            if (this.$store.state.order.selectStore) {
                this.doSelectStore(this.$store.state.order.selectStore)
            }

            getStores(stores => {

                //只有一個
                if (Array.isArray(stores) && stores.length == 1) {
                    that.doSelectStore(stores[0])
                }

                stores.forEach((store) => {
                    that.storeActions.push({
                        name: store.name,
                        method: () => {
                            that.beforeSelectedStore()
                            that.selectStore.id = store.id
                            that.selectStore.name = store.name
                            that.selectStore.tableTotal = store.table_total
                            that.$store.commit('setFormTitle', `${store.name}-點餐管理`)
                            that.$store.commit('setSelectStore', store)
                            that.$store.commit('refreshOrders');
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
            orderMenus() {
                return this.$store.state.order.orders
            },
            checkMenuCount() {
                return this.$store.state.order.orderCount
            },
            position() {
                return {
                    'storeID': this.selectStore.id,
                    'tableNo': this.tableNo
                }
            }
        },
        methods: {
            doSelectStore(store) {
                if (store !== null) {
                    this.selectStore.id = store.id
                    this.selectStore.name = store.name
                    this.selectStore.tableTotal = store.table_total
                    this.afterSelectedStore()
                }
            },
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
                if (!this.menuTypes) {
                    return
                }
                let name = ''
                this.menuTypes.forEach((menuType) => {
                    if (id == menuType.id) {
                        name = menuType.name
                    }
                })
                return name
            },
            menuOptions(menus) {
                let menuOptions = []
                menus.forEach((menu) => {
                    let newMenu = {
                        label: `${menu.menu_name}    $${menu.menu_price}`,
                        value: {
                            id: menu.menu_id,
                            name: menu.menu_name,
                            price: menu.menu_price,
                            menu_type_id: menu.menu_type_id,
                            menu_taste_ids: menu.menu_taste_ids
                        }
                    }
                    menuOptions.push(newMenu)
                })
                return menuOptions
            },
            menuClass(id) {
                return `menu-${id}`
            },
            scrollTo(id) {
                var $container = $('.app-main');
                var $scrollTo = $(`.menu-${id}`);
                $container.animate({
                    scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop() - 50,
                    scrollLeft: 0
                }, 300);

                $('.mint-cell-text').css("color", "black");
                $scrollTo.find('.mint-cell-text').css("color", "#ff9900");
            },
            addMenu(menu) {
                let that = this
                $.confirm({
                    title: '新增菜單:' + menu.menu_name,
                    content: '',
                    buttons: {
                        okSubmit: {
                            text: '確定 +1',
                            btnClass: 'btn-red',
                            action: function () {
                                that.$store.commit('pushOrder', {menu})
                                Toast({
                                    message: `${menu.menu_name} +1`,
                                    position: 'middle',
                                    duration: 2000
                                });
                            }
                        },
                        addThree: {
                            text: '確定 +3',
                            btnClass: 'btn-blue',
                            action: function () {
                                Array.from({length: 3}, index => {
                                    that.$store.commit('pushOrder', {menu})
                                    Toast({
                                        message: `${menu.menu_name} +3`,
                                        position: 'middle',
                                        duration: 2000
                                    });
                                })
                            }
                        },
                        addFive: {
                            text: '確定 +5',
                            btnClass: 'btn-orange',
                            action: function () {
                                Array.from({length: 5}, index => {
                                    that.$store.commit('pushOrder', {menu})
                                    Toast({
                                        message: `${menu.menu_name} +5`,
                                        position: 'middle',
                                        duration: 2000
                                    });
                                })
                            }
                        },
                        cancelSubmit: {
                            text: '取消',
                            btnClass: 'btn-default',
                            action: function () {
                            }
                        },
                    },
                });
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

    .menu-options {
        z-index: 9999999;
        position: fixed;
        top: 30vh;
        right: 10vw;
    }

    .menu-options div {
        margin-bottom: 20px;
    }

</style>