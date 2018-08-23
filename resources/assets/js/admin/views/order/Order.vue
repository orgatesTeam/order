<template>
    <div>
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
            </div>
        </div>
        <div>
            <mt-actionsheet
                    :actions="actions"
                    v-model="storesVisible">
            </mt-actionsheet>
        </div>
    </div>
</template>

<script>
    import {Actionsheet} from 'mint-ui'
    import {fetchList} from '../../api/store'
    import {Button} from 'mint-ui';
    import $ from 'jquery'

    export default {
        name: "Order",
        data() {
            return {
                storesVisible: false,
                actions: [],
                selectStore: {
                    name: '',
                    id: '',
                    tableTotal: 0
                },
                tableNo: 0,
            }
        },
        mounted() {
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
                                that.selectStore.id = store.id
                                that.selectStore.name = store.name
                                that.selectStore.tableTotal = store.table_total
                                that.$store.commit('setFormTitle', `${store.name}-點餐管理`)
                            }
                        })
                    })
                }
            })
        },
        methods: {
            selectTable() {

                let confirm = {
                    title: '選擇桌號',
                    buttons: {}
                }
                let that = this
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
</style>