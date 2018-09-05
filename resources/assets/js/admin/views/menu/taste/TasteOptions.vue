<template>
    <div class="regulation">
        <div class="bg"></div>
        <div class="table" @click="shake">
            <div class="row">
                <div class="cell">
                    <div class="container" :class="containerShake">
                        <div class="box">
                            <div class="box-title">
                                <span>{{title}}</span>
                            </div>
                            <div class="box-content">
                                <div>
                                    <mt-field label="口味名稱:" v-model="taste.name"></mt-field>
                                </div>
                                <div>
                                    <a class="mint-cell mint-field">
                                        <div class="mint-cell-wrapper">
                                            <a class="waves-effect waves-light btn blue" @click="addOption()">新增項目</a>
                                            <div class="btn-option">
                                                <a v-for="option,index in options"
                                                   class="waves-effect waves-light btn orange"
                                                   @click="editOption(index)">{{option.name}}</a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="box-buttons-right">
                                <a class="waves-effect waves-light btn" @click="save()" :disabled="!canStore">儲存</a>
                                <a class="waves-effect waves-light btn" @click="close()">取消</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showTasteOption">
            <taste-option @close-taste-option="closeOption"></taste-option>
        </div>
    </div>
</template>

<script>
    import TasteOption from './TasteOption'
    import {newTaste} from "../../../api/taste"
    import {deepObjectClone} from "../../../utils/helper"
    import {hackReset} from "../../../utils/helper"
    import {Toast} from 'mint-ui'
    import {updateTaste} from "../../../api/taste"
    import {fetchList} from "../../../api/taste";

    export default {
        name: "TasteOptions",
        components: {TasteOption},
        data() {
            return {
                containerShake: '',
                showTasteOption: false,
                //編輯模式origin data
                edit: {
                    originTaste: null,
                    originOptions: []
                },
                mode: 'new',
                taste: {
                    name: '',
                },
                title: ''
            }
        },
        mounted() {
            //編輯預設定
            this.checkEditSetting()
        },
        computed: {
            vuexTaste() {
                return this.$store.state.taste
            },
            options() {
                return this.vuexTaste.editTasteOptions
            },
            canStore() {
                return true
            }
        },
        methods: {
            getTastes() {
                fetchList({}).then(response => {
                    if (response.data.code == 202) {
                        that.$store.commit('setTastes', response.data.items.tastes)
                    }
                })
            },
            checkEditSetting() {
                let taste = this.vuexTaste.editTaste
                if (taste.name == '') {
                    this.title = '新增口味:'
                } else {
                    this.title = `編輯-${taste.name}`
                    this.taste.name = taste.name
                    this.edit.originTaste = deepObjectClone(taste)
                    this.edit.originOptions = deepObjectClone(this.vuexTaste.editTasteOptions)
                    this.mode = 'edit'
                }
            },
            shake(event) {
                if (event.target.className == 'cell') {
                    this.containerShake = 'shake'
                    let that = this
                    setTimeout(() => {
                        that.containerShake = ''
                    }, 520)
                }
            },
            close() {
                this.$emit('close-taste-options')
                this.$store.commit('cancelEditTasteOptions')
            },
            save() {

                if (this.mode == 'new') {
                    this.newTaste()
                }

                if (this.mode == 'edit') {
                    this.updateTaste()
                }

                //強制刷新元件
                hackReset(this)
            },
            newTaste() {
                let taste = {
                    name: this.taste.name,
                    options: JSON.stringify(this.options)
                }
                let that = this
                newTaste(taste).then(response => {
                    if (response.data.code == '202') {
                        that.getTastes()
                    }
                    let toastMessage = (response.data.code == '202') ? '完成!' : '失敗!'
                    Toast({
                        message: toastMessage,
                        position: 'middle',
                        duration: 800
                    });
                    that.close()
                })
            },
            updateTaste() {
                let taste = {
                    id: this.vuexTaste.editTaste.id,
                    name: this.taste.name,
                    options: JSON.stringify(this.vuexTaste.editTasteOptions)
                }
                let that = this
                updateTaste(taste).then(response => {
                    if (response.data.code == '202') {
                        that.getTastes()
                    }
                    let toastMessage = (response.data.code == '202') ? '完成!' : '失敗!'
                    Toast({
                        message: toastMessage,
                        position: 'middle',
                        duration: 800
                    });
                    that.close()
                })
            },
            closeOption() {
                this.showTasteOption = false
            },
            editOption(index) {
                this.$store.commit('setTasteOptionIndex', index)
                this.showTasteOption = true
            },
            addOption() {
                this.$store.commit('setTasteOptionIndex', null)
                this.showTasteOption = true
            }
        }
    }
</script>

<style scoped>

    .btn-option {
        padding-left: 13px;
    }

    .shake {
        -webkit-animation: shake .82s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        animation: shake .82s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        -webkit-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
    }

    .bg {
        position: fixed;
        top: 0;
        height: 100%;
        width: 100%;
        background-color: #444;
        opacity: .2;
    }

    .regulation {
        position: fixed;
        top: 0;
        height: 100%;
        width: 100%;
        z-index: 99999999;
    }

    .regulation .table {
        -webkit-perspective: 500px;
        perspective: 500px;
        -webkit-perspective-origin: center;
        perspective-origin: center;
        display: table;
        width: 100%;
        height: 100%;
    }

    .regulation .row {
        display: table-row;
        width: 100%;
    }

    .regulation .cell {
        display: table-cell;
        vertical-align: middle;
    }

    .regulation .container {
        margin: 0 auto;
        max-width: 1280px;
        width: 90%;
    }

    .regulation .box {
        background: white;
        border-radius: 4px;
        position: relative;
        outline: 0;
        padding: 15px 15px 0;
        overflow: hidden;
        margin-left: auto;
        margin-right: auto;
        border-top: solid 7px rgb(38, 162, 255);
    }

    .box-title {
        display: block;
        font-size: 22px;
        line-height: 20px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        cursor: default;
        padding-bottom: 15px;
    }

    .box-content {
        margin-bottom: 15px;
        height: auto;
        -webkit-transition: height .4s ease-in;
        transition: height .4s ease-in;
        display: inline-block;
        width: 100%;
        position: relative;
        overflow-x: hidden;
        overflow-y: auto;
    }

    .box-buttons-right {
        float: right;
        adding-bottom: 11px;
        padding-bottom: 10px;
    }

    .box-buttons-left {
        float: left;
        adding-bottom: 11px;
        padding-bottom: 10px;
    }

    .orange {
        margin: 0 2px 0 2px;
    }
</style>