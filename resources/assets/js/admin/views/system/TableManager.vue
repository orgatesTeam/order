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
        <img :src="qrCodeURL" alt="">
    </div>
</template>
<style>
    .range {
        width: 60vw;
    }

</style>
<script>
    import {Range} from 'mint-ui';
    import {Cell} from 'mint-ui';
    import {getQRCode} from '../../utils/qrcode'

    export default {
        name: "TableManager",
        comments: [Range.name, Range, Cell.name, Cell],
        data() {
            return {
                rangeValue: 1,
                start: 1,
                end: 50
            }
        },
        mounted() {
            this.$store.commit('setFormTitle', '桌位管理')
        },
        computed: {
            qrCodeURL() {
                return getQRCode('http://e614f201.ngrok.io/admin/system/table-manager')
            }
        }
    }
</script>

<style scoped>

</style>