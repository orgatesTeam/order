<template>
    <div>
        <div class="section no-pad-bot" id="index-banner">
            <div class="container">
                <div class="section">
                    <table class="highlight responsive-table">
                        <thead>
                        <tr>
                            <th>口味名稱</th>
                            <th></th>
                            <th>項目</th>
                            <th>
                                <div class="section">
                                    <div @click="show = true">
                                        <mt-palette-button content="+"
                                                           mainButtonStyle="color:#fff;background-color:#26a2ff;">
                                            <div class="my-icon-button"></div>
                                            <div class="my-icon-button"></div>
                                            <div class="my-icon-button"></div>
                                        </mt-palette-button>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="taste,index in tastes">
                            <td>{{taste.name}}</td>
                            <td></td>
                            <td>
                                <div v-for="option in parseOptions(taste.options)" class="options">
                                    <a class="waves-effect tabs btn orange" @click="edit(index)">{{option.name}}</a>
                                </div>
                            </td>
                            <td>
                                <a class="waves-effect waves-light btn" @click="edit(index)">編輯</a>
                                <a class="waves-effect waves-light btn red" @click="remove(index)">刪除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <taste-options @close-taste-options="closeTasteOptions" v-if="show"></taste-options>
    </div>
</template>

<script>
    import {fetchList} from "../../api/taste"
    import TasteOptions from './taste/TasteOptions'
    import $ from 'jquery'
    import {deleteTaste} from "../../api/taste"
    import {Toast} from 'mint-ui'

    export default {
        name: "Taste",
        components: {TasteOptions},
        mounted() {
            this.$store.commit('setFormTitle', '口味管理')
            this.getTastes()
        },
        data() {
            return {
                show: false
            }
        },
        computed: {
            tastes() {
                return this.$store.state.taste.tastes
            }
        },
        methods: {
            getTastes() {
                if (this.tastes === null) {
                    let that = this
                    fetchList({}).then(response => {
                        if (response.data.code == 202) {
                            that.$store.commit('setTastes', response.data.items.tastes)
                        }
                    })
                }
            },
            parseOptions(options) {
                return JSON.parse(options);
            },
            edit(index) {
                let taste = this.tastes[index]
                this.$store.commit('setEditTaste', taste)
                this.$store.commit('setEditTasteOptions', JSON.parse(taste.options))
                this.show = true
            },
            closeTasteOptions() {
                this.show = false
            },
            remove(index) {
                let that = this

                $.confirm({
                    title: '確定刪除口味!',
                    content: `刪除口味: ${that.tastes[index].name}`,
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: '確定',
                            btnClass: 'btn-red',
                            action: function () {
                                let id = that.tastes[index].id
                                deleteTaste({id: id}).then(response => {
                                    if (response.data.code == '202') {
                                        Toast({
                                            message: '刪除成功',
                                            position: 'middle',
                                            duration: 800
                                        });
                                        if (that.tastes.length == 1) {
                                            that.tastes = []
                                        } else {
                                            that.tastes.splice(index, 1)
                                        }
                                    }
                                })
                            }
                        },
                        close: {
                            text: '取消',
                        }
                    }
                })
            }
        }
    }
</script>

<style scoped>
    .options {
        display: inline-block;
        margin: 0 2px 0 2px;
    }
</style>