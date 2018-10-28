<template>
    <div v-if="show" class="regulation">
        <div class="bg"></div>
        <div class="table" @click="shake">
            <div class="row">
                <div class="cell">
                    <div class="container" :class="containerShake">
                        <div class="box">
                            <div class="box-title">
                                <span>{{selectedOrder.menu.menu_name}}</span>
                            </div>
                            <div class="box-content">
                                <div v-for="tasteOptions in tastesOptions">
                                    <div v-for="option,optionIndex in tasteOptions.options">
                                        <div @click="option.showActionsheet = !option.showActionsheet">
                                            <mt-field :label="option.name" type="tel" v-model="option.select">
                                                <mt-actionsheet
                                                        :actions="buildActionsByTasteOption(tasteOptions.id,optionIndex,option)"
                                                        v-model="option.showActionsheet">
                                                </mt-actionsheet>
                                            </mt-field>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-buttons">
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
    import {getTastes} from "../../cache/taste";
    import {deepObjectClone} from "../../utils/helper";

    export default {
        name: "Regulation",
        data() {
            return {
                containerShake: '',
                tastes: null,
                tastesOptions: [],
            }
        },
        watch: {
            show() {
                let that = this
                let getTastesOptions = () => {
                    let tastesOptions = []
                    if (that.selectedOrder.tastesOptions !== undefined) {
                        tastesOptions = that.selectedOrder.tastesOptions
                    } else {
                        getTastes(tastes => {
                            let tasteIDs = that.selectedOrder.menu.menu_taste_ids.split(',')
                            tastes.forEach(taste => {
                                if (tasteIDs.includes(String(taste.id))) {
                                    let tasteTemp = deepObjectClone(taste)
                                    let options = [];
                                    tasteTemp.options.forEach(option => {
                                        option.showActionsheet = false;
                                        //預設口味第一個
                                        option.select = option.checks[0].name;
                                        options.push(option)
                                    })
                                    tasteTemp.options = options
                                    tastesOptions.push(tasteTemp)
                                }
                            })
                        })
                    }
                    that.tastesOptions = tastesOptions
                }

                getTastesOptions()
            }
        },
        computed: {
            order() {
                return this.$store.state.order
            },
            show() {
                return this.order.showRegulation
            },
            selectedOrder() {
                let index = this.order.regulateOrderIndex
                return this.order.orders[index]
            },
        },
        methods: {
            close() {
                this.$store.commit('setShowRegulation', false)
                this.amount = 1
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
            save() {
                this.selectedOrder.tastesOptions = this.tastesOptions
                this.close()
            },
            buildActionsByTasteOption(tasteOptionsID, tasteOptionIndex, tasteOption) {
                let actions = []
                let that = this
                tasteOption.checks.forEach((check) => {
                    actions.push({
                        name: check.name, method: () => {
                            that.selectTasteOptions(tasteOptionsID, tasteOptionIndex, check.name)
                        }
                    })
                })
                return actions
            },
            selectTasteOptions(tasteOptionsID, tasteOptionIndex, checkName) {
                this.tastesOptions.forEach(tasteOptions => {
                    if (tasteOptionsID == tasteOptions.id) {
                        tasteOptions.options[tasteOptionIndex].select = checkName;
                    }
                })
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
        border-top: solid 7px #e74c3c;
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

    .box-buttons {
        float: right;
        adding-bottom: 11px;
        padding-bottom: 10px;
    }

    .amount-regulation {
        float: right;
    }
</style>