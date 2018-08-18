<template>
    <div>
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
</template>
<style>
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
</style>
<script>
    import {Badge} from 'mint-ui';
    import {Range} from 'mint-ui';
    import {Cell} from 'mint-ui';
    import {getQRCode} from '../../utils/qrcode'
    import {paddingLeft} from '../../utils/helper'

    export default {
        name: "TableManager",
        comments: [Range.name, Range, Cell.name, Cell, Badge.name, Badge],
        data() {
            return {
                rangeValue: 1,
                start: 1,
                end: 50,
                tableNo: 1
            }
        },
        mounted() {
            this.$store.commit('setFormTitle', '桌位管理')
        },
        computed: {
            qrCodeURL() {
                // let url = 'http://order.com.tw/menu/no/1'
                let url = 'http://aedd7ebb.ngrok.io/admin/system/table-manager'
                let queryString = `table-mode=no&no=${this.tableNo}`
                return getQRCode(`${url}?${queryString}`)
            }
        },
        methods: {
            paddingLeft(index) {
                return paddingLeft(index, 2)
            }
        }
    }
</script>

<style scoped>

</style>