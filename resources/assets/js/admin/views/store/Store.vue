<template>
    <div>
        <div class="section no-pad-bot" id="index-banner">
            <div class="container">
                <div class="section">
                    <table class="highlight responsive-table">
                        <thead>
                        <tr>
                            <th>名稱</th>
                            <th>電話</th>
                            <th>地址</th>
                            <th>配置菜單數</th>
                            <th>建立時間</th>
                            <th>更新時間</th>
                            <th>
                                <div class="section">
                                    <div @click="create()">
                                        <mt-palette-button content="+"
                                                           mainButtonStyle="color:#fff;background-color:#26a2ff;">
                                            <div class="my-icon-button"></div>
                                            <div class="my-icon-button"></div>
                                            <div class="my-icon-button"></div>
                                        </mt-palette-button>
                                    </div>
                                </div>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="store,index in stores">
                            <td>{{store.name}}</td>
                            <td>{{store.tel}}</td>
                            <td>{{store.address}}</td>
                            <td>0</td>
                            <td>{{store.created_at}}</td>
                            <td>{{store.updated_at}}</td>
                            <td>
                                <a class="waves-effect waves-light btn" @click="edit(index)">編輯</a>
                            </td>
                            <td>
                                <a class="waves-effect waves-light btn" @click="importMenu(store)">配置菜單</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {fetchList} from '../../api/store'
    import {PaletteButton} from 'mint-ui';

    export default {
        name: "store",
        comments: [PaletteButton.name, PaletteButton],
        data() {
            return {
                stores: []
            }
        },
        mounted() {
            this.$store.commit('setFormTitle', '店家管理')
            this.getStore()
        },
        methods: {
            getStore() {

                if (this.$store.state.storeManager.cacheStores) {
                    this.stores = this.$store.state.storeManager.cacheStores
                    return
                }

                let that = this
                fetchList({}).then(response => {
                    if (response.data.code == 202) {
                        console.log(response)
                        let stores = response.data.items.stores
                        that.stores = stores
                        this.$store.commit('setCacheStores', stores)
                    }
                })
            },
            edit(index) {
                let store = Object.assign({}, this.stores[index])
                this.$store.commit('setEditStore', store)
                this.$router.push({name: 'store-edit', query: {from: 'edit'}})
            },
            create() {
                this.$router.push({name: 'store-edit', query: {from: 'create'}})
            },
            importMenu(store) {
                this.$store.commit('setStoreToImportMenu', store)
                this.$router.push({name: 'store-import-menu'})
            },
        }
    }
</script>

<style scoped>

</style>