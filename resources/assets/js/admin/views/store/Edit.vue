<template>
    <div>
        <mt-navbar v-model="mode">
            <mt-tab-item id="edit">編輯</mt-tab-item>
            <mt-tab-item id="create">新增</mt-tab-item>
        </mt-navbar>

        <mt-tab-container v-model="mode">
            <mt-tab-container-item id="edit">
                <div class="section">
                    <mt-field label="名稱" v-model="editStore.name"></mt-field>
                    <mt-field label="電話" type="tel" v-model="editStore.tel"></mt-field>
                    <mt-field label="地址" v-model="editStore.address"></mt-field>
                    <mt-field label="總桌數" type="tel" v-model="editStore.table_total"></mt-field>

                </div>
                <mt-button :disabled="!canEdit" type="primary" size="large" @click="storeEdit">儲存</mt-button>
            </mt-tab-container-item>
            <mt-tab-container-item id="create">
                <div class="section">
                    <mt-field label="名稱" v-model="createStore.name"></mt-field>
                    <mt-field label="電話" type="tel" v-model="createStore.tel"></mt-field>
                    <mt-field label="地址" v-model="createStore.address"></mt-field>
                    <mt-field label="總桌數" type="tel" v-model="createStore.tableTotal"></mt-field>
                </div>
                <mt-button :disabled="!canCreate" type="primary" size="large" @click="storeCreate">儲存</mt-button>
            </mt-tab-container-item>
        </mt-tab-container>

    </div>
</template>
<style scoped>
    label {
        color: #ffffff;
    }
</style>
<script>
    import {Field} from 'mint-ui';
    import {Button} from 'mint-ui';
    import {Toast} from 'mint-ui';

    import {Navbar, TabItem} from 'mint-ui';
    import {createStore, updateStore} from '../../api/store'

    export default {
        name: "Edit",
        data() {
            return {
                editStore: {},
                originEditStore: {},
                mode: '',
                createStore: {
                    name: '',
                    tel: '',
                    address: '',
                    tableTotal: 1
                }
            }
        },
        comments: [Field.name, Field, Navbar.name, Navbar, TabItem.name, TabItem, Button.name, Button],
        mounted() {
            this.mode = this.$route.query.from;

            //預設值
            if (this.mode === '') {
                this.mode = 'create'
            }

            //有編輯 menu 帶入
            if (this.$store.state.storeManager.editStore) {
                this.editStore = this.$store.state.storeManager.editStore
                this.originEditStore = Object.assign({}, this.editStore)
            } else {
                this.mode = 'create'
            }
        },
        computed: {
            editMode() {
                return this.mode === 'edit'
            },
            createMode() {
                return this.mode === 'create'
            },
            canEdit() {
                let status = false
                //判斷跟資料是否差異,儲存按鈕開啟
                for (let key in this.originEditStore) {
                    if (this.originEditStore[key] != this.editStore[key]) {
                        console.log({ori: this.originEditStore[key], edit: this.editStore[key]})
                        status = true;
                    }
                }
                return status;
            },
            canCreate() {
                let store = this.createStore

                if (store.name == '') {
                    return false
                }

                if (store.tel == '') {
                    return false
                }

                if (store.address == '') {
                    return false
                }
                return true
            }
        },
        watch: {
            mode() {
                if (this.editMode) {
                    this.$store.commit('setFormTitle', '編輯店家')
                }
                if (this.createMode) {
                    this.$store.commit('setFormTitle', '新增店家')
                }
            }
        },
        methods: {
            storeEdit() {
                let that = this
                let {id, name, tel, address, table_total} = this.editStore
                let data = {
                    id: id,
                    name: name,
                    tel: tel,
                    address: address,
                    table_total: table_total
                }

                updateStore(data).then(response => {
                    if (response.data.code == '202') {
                        Toast({
                            message: '操作成功',
                            iconClass: 'icon icon-success'
                        });
                        that.refreshCacheStores()
                        that.$router.push({name: 'store'})
                    }
                })
            },
            storeCreate() {

                let that = this
                let {name, tel, address, tableTotal} = this.createStore
                let data = {
                    name: name,
                    tel: tel,
                    address: address,
                    table_total: tableTotal
                }

                createStore(data).then(response => {
                    if (response.data.code == '202') {
                        Toast({
                            message: '操作成功',
                            iconClass: 'icon icon-success'
                        });
                        that.refreshCacheStores()
                        that.$router.push({name: 'store'})
                    }
                })
            },
            refreshCacheStores() {
                this.$store.commit('setCacheStores', null)
            }
        }
    }
</script>
