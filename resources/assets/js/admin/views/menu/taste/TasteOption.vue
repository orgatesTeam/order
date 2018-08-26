<template>
    <div class="regulation">
        <div class="bg"></div>
        <div class="table" @click="shake">
            <div class="row">
                <div class="cell">
                    <div class="container" :class="containerShake">
                        <div class="box">
                            <div class="box-title">
                                <span>新增項目</span>
                            </div>
                            <div class="box-content max-content" id="max-content">
                                <div>
                                    <mt-field label="項目名稱:" v-model="option.name"></mt-field>
                                </div>
                                <div v-for="check,index in option.checks">
                                    <mt-field :label="`程度${index+1}`" v-model="check.name">
                                        <a class="waves-effect waves-light btn red" @click="cancelCheck(index)">取消</a>
                                    </mt-field>
                                </div>
                                <div>
                                    <mt-field label="輸入口味:" v-model="tempCheck">
                                        <a class="waves-effect waves-light btn blue" @click="addCheck()">增加</a>
                                    </mt-field>
                                </div>
                            </div>
                            <div class="box-buttons-right">
                                <a class="waves-effect waves-light btn" @click="save()">儲存</a>
                                <a class="waves-effect waves-light btn" @click="close()">取消</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {gotoBottom} from '../../../utils/helper'
    import {deepClone} from "../../../utils/helper";

    export default {
        name: "TasteOption",
        data() {
            return {
                containerShake: '',
                option: {
                    name: '',
                    checks: [],
                },
                tempCheck: '',
                mode: 'add'
            }
        },
        computed: {
            editIndex() {
                return this.$store.state.taste.tasteOptionsIndex
            }
        },
        mounted() {
            let index = this.editIndex
            if (index != null) {
                this.option = deepClone(this.$store.state.taste.options[index])
                this.mode = 'edit'
            }
        },
        methods: {
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
                this.$store.commit('setTasteOptionsIndex', null)
                this.$emit('close-taste-option')
            },
            save() {
                this.$store.commit('setTasteOption', this.option)
                this.close()
            },
            addCheck() {
                if (this.tempCheck == '') {
                    return
                }
                this.option.checks.push({name: this.tempCheck})
                this.tempCheck = ''
                this.$nextTick(() => {
                    gotoBottom('max-content')
                })
            },
            cancelCheck(index) {
                this.option.checks.splice(index, 1)
            },
        }
    }
</script>

<style scoped>

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
        border-top: solid 7px #ff9800;
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

    .max-content {
        max-height: 300px;
        overflow: auto;
    }
</style>