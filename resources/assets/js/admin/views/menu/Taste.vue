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
                                    <div @click="add()">
                                        <mt-palette-button content="＋"
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
                                <div v-for="option in taste.options" class="options">
                                    <a class="waves-effect tabs btn orange" @click="edit(taste)">{{option.name}}</a>
                                </div>
                            </td>
                            <td>
                                <a class="waves-effect waves-light btn" @click="edit(taste)">編輯</a>
                                <a class="waves-effect waves-light btn red" @click="remove(taste)">刪除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <taste-options @close="close" v-if="showEditTaste"></taste-options>
    </div>
</template>

<script>
    import {fetchList} from "../../api/taste"
    import TasteOptions from './taste/TasteOptions'
    import $ from 'jquery'
    import {deleteTaste} from "../../api/taste"
    import {Toast} from 'mint-ui'
    import {deepObjectClone} from "../../utils/helper";

    export default {
        name: "Taste",
        components: {TasteOptions},
        mounted() {
            this.$store.commit('setFormTitle', '口味管理')
            this.getTastes()
        },
        data() {
            return {
                showEditTaste: false
            }
        },
        computed: {
            tastes() {
                return this.$store.state.taste.tastes
            }
        },
        methods: {
            getTastes(force = false) {
                if (this.tastes === null || force === true) {
                    let that = this
                    fetchList({}).then(response => {
                        if (response.data.code == 202) {
                            that.$store.commit('setTastes', response.data.items.tastes)
                        }
                    })
                }
            },
            add() {
                let taste = {
                    options: [],
                    name: '',
                }
                this.$store.commit('setEditTaste', taste)
                this.showEditTaste = true
            },
            edit(taste) {
                taste = deepObjectClone(taste)
                this.$store.commit('setEditTaste', taste)
                this.showEditTaste = true
            },
            close() {
                this.showEditTaste = false
            },
            remove(taste) {
                let that = this

                $.confirm({
                    title: '確定刪除口味!',
                    content: `刪除口味: ${taste.name}`,
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: '確定',
                            btnClass: 'btn-red',
                            action: function () {
                                let id = taste.id
                                deleteTaste({id: id}).then(response => {
                                    if (response.data.code == '202') {
                                        Toast({
                                            message: '刪除成功',
                                            position: 'middle',
                                            duration: 800
                                        });
                                        that.getTastes(true)
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