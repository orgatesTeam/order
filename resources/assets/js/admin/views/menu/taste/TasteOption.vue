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
                                        <div>
                                            <a class="waves-effect waves-light btn red"
                                               @click="editCheck(index)">金額 / 移除</a>
                                        </div>
                                    </mt-field>
                                </div>
                                <div>
                                    <mt-field label="輸入口味:" v-model="tempCheck">
                                        <a class="waves-effect waves-light btn blue" @click="addCheck()">增加</a>
                                    </mt-field>
                                </div>
                            </div>
                            <div class="box-buttons-left">
                                <a v-if="mode==='edit'" class="waves-effect waves-light btn red"
                                   @click="remove()">刪除</a>
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
        <mt-actionsheet
                :actions="actionCheckTypes"
                v-model="tasteAction">
        </mt-actionsheet>

    </div>
</template>

<script>
    import {gotoBottom} from '../../../utils/helper'
    import {deepObjectClone} from "../../../utils/helper";
    import $ from 'jquery'

    export default {
        name: "TasteOption",
        data() {
            return {
                containerShake: '',
                option: {
                    name: '',
                    checks: []
                },
                tempCheck: '',
                mode: 'new',
                tasteAction: false,
                editCheckIndex: null
            }
        },
        computed: {
            options() {
                return this.$store.state.taste.editTaste.options
            },
            editIndex() {
                return this.$store.state.taste.tasteOptionIndex
            },
            canStore() {
                if (this.option.name.length > 0 && this.option.checks.length > 0) {
                    return true
                }
                return false
            },
            actionCheckTypes() {
                let that = this
                let check = this.option.checks[this.editCheckIndex]
                let types = [
                    {
                        name: `增加金額(目前金額: $ ${check ? (check.price ? check.price : '0') : '0'})`,
                        method: () => {
                            that.addPrice()
                        }
                    },
                    {
                        name: '移除',
                        method: () => {
                            that.cancelCheck()
                        }
                    }
                ]
                return types
            },
        },
        mounted() {
            //編輯 OR 新增
            this.initSession()
        },
        methods: {
            editCheck(index) {
                this.editCheckIndex = index
                this.tasteAction = true
            },
            initSession() {
                let index = this.editIndex
                if (index === null) {
                    this.mode = 'new'
                    return
                }
                this.option = deepObjectClone(this.options[index])
                this.mode = 'edit'
                return
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
                this.$store.commit('setTasteOptionIndex', null)
                this.$emit('close-taste-option')
            },
            save() {
                let options = deepObjectClone(this.options)
                //編輯會有editIndex 新增項目不會用
                if (this.mode === 'new') {
                    options.push(this.option)
                }
                if (this.mode === 'edit') {
                    options[this.editIndex] = this.option
                }
                this.updateOptions(options)
                this.close()
            },
            remove() {
                this.options.splice(this.editIndex, 1)
                this.updateOptions(deepObjectClone(this.options))
                this.close()
            },
            updateOptions(options) {
                let taste = this.$store.state.taste.editTaste
                taste.options = options
                this.$store.commit('setEditTaste', taste)
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
            cancelCheck() {
                let index = this.editCheckIndex
                this.option.checks.splice(index, 1)
            },
            addPrice() {
                let index = this.editCheckIndex
                let check = this.option.checks[index]
                $.confirm({
                    title: `${check.name}所需增加金額`,
                    content: '' +
                        '<form action="" class="formName">' +
                        '<div class="form-group">' +
                        '<input type="text" placeholder="輸入金額" style="font-size: 18px" class="price form-control" required />' +
                        '</div>' +
                        '</form>',
                    buttons: {
                        formSubmit: {
                            text: '確定',
                            btnClass: 'btn-blue',
                            action: function () {
                                var price = this.$content.find('.price').val();
                                check.price = price
                            }
                        },
                        cancel: {
                            text: '取消',
                            btnClass: 'btn-default',
                            action: function () {
                            }
                        },
                    },
                    onContentReady: function () {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            }
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