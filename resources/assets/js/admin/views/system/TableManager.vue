<template>
    <div>
        <div class="select-container">
            <div @click="storesVisible = true" class="inline-dev">
                <mt-button type="danger">選點店家</mt-button>
            </div>
            <div @click="saveTable()" class="inline-dev">
                <mt-button type="primary">儲存</mt-button>
            </div>
        </div>


        <div v-if="selectStore.id > 0">
            <mt-cell :title="'總桌位:'+rangeValue">
                <mt-range v-model="rangeValue" :min="start"
                          :max="end"
                          :step="1"
                          class="range">
                    <div slot="start">{{start}}</div>
                    <div slot="end">{{end}}</div>
                </mt-range>
            </mt-cell>
            <div class="section">
                <div v-for="index in rangeValue" class="qrcode-select"
                     @click="tableNo = index"
                     :class="tableNo==index?'selected':''">
                    {{paddingLeft(index)}}
                </div>
            </div>
            <div class="section">
                <img :src="qrCodeURL" alt="">
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
<style scoped>
    .range {
        width: 60vw;
    }

    .qrcode-select {
        display: inline-block;
        margin: 6px 6px 0 6px;
        color: #ffffff;
        width: 32px;
        height: 20px;
        background-color: #26a2ff;
        text-align: center;
        border-radius: 5px;
    }

    .qrcode-select.selected {
        background: #ee6e73;
    }

    .select-container {
        padding: 10px 0 10px 20px;
    }

    .inline-dev {
        display: inline;
    }
</style>
<script>
    import {getQRCode} from '../../utils/qrcode'
    import {paddingLeft} from '../../utils/helper'
    import {settingTableTotal} from '../../api/store'
    import {getStores} from "../../cache/storeManager";
    import {Toast} from 'mint-ui';

    export default {
        name: "TableManager",
        data() {
            return {
                rangeValue: 1,
                start: 1,
                end: 50,
                tableNo: 1,
                selectStore: {
                    name: '',
                    id: ''
                },
                storesVisible: false,
                actions: [],
            }
        },
        mounted() {
            this.$store.commit('setFormTitle', '桌位管理')
            this.getStore()
        },
        computed: {
            qrCodeURL() {
                // let url = 'http://order.com.tw/menu/no/1'
                let url = 'http://1d70597a.ngrok.io/admin/system/table-manager'
                let queryString = `table-mode=no&no=${this.tableNo}`
                return getQRCode(`${url}?${queryString}`)
            }
        },
        methods: {
            getStore(force = false) {
                let that = this
                getStores(stores => {
                    stores.forEach((store) => {
                        that.actions.push({
                            name: store.name,
                            method: () => {
                                that.selectStore.id = store.id
                                that.selectStore.name = store.name
                                that.rangeValue = store.table_total
                                that.$store.commit('setFormTitle', `${store.name}-桌位管理`)
                            }
                        })
                    })
                }, force)
            },
            paddingLeft(index) {
                return paddingLeft(index, 2)
            },
            saveTable() {
                let that = this
                let storeID = this.selectStore.id
                if (storeID < 1) {
                    return Toast({
                        message: '請選擇店家',
                        position: 'middle',
                        duration: 3000
                    });
                }
                let tableTotal = this.rangeValue
                let data = {
                    id: storeID,
                    table_total: tableTotal
                }

                settingTableTotal(data).then(response => {
                    if (response.data.code == 202) {
                        Toast({
                            message: '儲存成功',
                            position: 'middle',
                            duration: 2000
                        });
                        //重刷配置
                        that.getStore(true)
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>