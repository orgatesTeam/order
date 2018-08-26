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
                                    <a class="waves-effect tabs btn orange" @click="seeOptionChecks(option)">{{option.name}}</a>
                                </div>
                            </td>
                            <td>
                                <a class="waves-effect waves-light btn" @click="edit(index)">編輯</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <taste-options @close-taste-options="close" v-if="show"></taste-options>
    </div>
</template>

<script>
    import {fetchList} from "../../api/taste"
    import TasteOptions from './taste/TasteOptions'

    export default {
        name: "Taste",
        components: {TasteOptions},
        mounted() {
            this.$store.commit('setFormTitle', '口味管理')
            this.getTastes()
        },
        data() {
            return {
                tastes: {},
                show: true
            }
        },
        methods: {
            getTastes() {
                let that = this
                fetchList({}).then(response => {
                    if (response.data.code == 202) {
                        that.tastes = response.data.items.tastes
                    }
                })
            },
            parseOptions(options) {
                return JSON.parse(options);
            },
            create() {

            },
            edit(index) {
                let taste = this.tastes[index]
                this.$store.commit('setTasteName', taste.name)
                this.$store.commit('setTasteOptions', JSON.parse(taste.options))
                this.show = true
            },
            seeOptionChecks(option) {

            },
            close() {
                this.show = false
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