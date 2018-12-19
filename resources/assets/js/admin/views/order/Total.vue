<style scoped lang="scss">

    #drag {
        position: fixed;
        width: 150px;
        height: 70px;
        padding: 10px;
        bottom: 300px;
        right: 10px;
        z-index: 9999999;
        .offer {
            position: absolute;
            top: 0;
        }
        .sum {
            position: absolute;
            top: 0;
            left: 80px;
        }
    }

    .price {
        .title {
            font-weight: bold;
            flex: 1
        }
        .math {
            flex: 1;
            color: red;
        }
    }

    .details {
        margin-top: 20px;
        .name {
            flex: 3.5;
        }
        .sum {
            flex: 3;
        }
    }

    .over-auto {
        overflow: auto;
        height: 60vh;
    }

    .function-btn {
        position: fixed;
        bottom: 80px;
    }

    .inline-dev {
        display: inline;
    }
</style>
<template>
    <div class="container-10">
        <div class="price font-8 flex-container">
            <div class="title">總金額:</div>
            <div class="math">${{totalPrice}}</div>
        </div>
        <div class="over-auto">
            <div class="font-5 flex-middle details" v-for="detail,index in details" :class="{blue:index%2==0}">
                <div class="name">{{detail.name}}</div>
                <div class="sum"> x {{detail.number}}</div>
            </div>
        </div>
        <div id="drag" class="function-btn">
            <div class="inline-dev sum" @click="checkout()">
                <mt-button type="primary">結算</mt-button>
            </div>
        </div>
    </div>
</template>

<script>
    import {tastesOptionsCountPrice} from "../../utils/orderService";
    import {checkout} from "../../api/order";
    import {formatOrderCheckoutDetails} from "../../utils/orderService";
    import {Toast} from 'mint-ui';

    export default {
        props: ['position'],
        name: "Total",
        data() {
            return {
                totalPrice: 0,
            }
        },
        mounted() {

            //註冊move
            let lastPt = null;
            let el = this.moveElement
            let that = this
            el.addEventListener("touchmove", handleMove, false);

            function handleMove(e) {
                e.preventDefault();
                if (lastPt != null) {
                }
                lastPt = {x: e.touches[0].pageX, y: e.touches[0].pageY};
                el.style.top = `${lastPt.y}px`
                el.style.left = `${lastPt.x}px`
                that.$store.commit('setOrderTotalMoveLastPt', lastPt)
            }

            this.setMoveLastPt()
        },
        watch: {
            moving(value) {
                if (value === true) {
                    console.log(1)
                } else {
                    console.log(2)
                }
            }
        },
        computed: {
            moveElement() {
                return document.getElementById('drag');
            },
            orders() {
                return this.$store.state.order.orders
            },
            details() {
                let details = {}
                let that = this
                that.totalPrice = 0
                this.orders.forEach(order => {

                    let menu = order.menu
                    let menuName = menu.menu_name
                    let menuID = menu.menu_id

                    //總金額
                    that.totalPrice += (menu.menu_price + tastesOptionsCountPrice(order.tastesOptions));

                    //各個菜單數量
                    if (details[menuID] === undefined) {
                        details[menuID] = {name: menuName, number: 1, id: menuID}
                    } else {
                        details[menuID]['number'] += 1
                    }
                })

                console.log(details)
                var sortable = [];
                for (let index in details) {
                    sortable.push(details[index]);
                }
                return sortable.sort((a, b) => {
                    return (a.id > b.id) ? 0 : -1
                })
            }
        },
        methods: {
            setMoveLastPt() {
                let lastPt = this.$store.state.habit.orderTotalMoveLastPt
                let el = this.moveElement
                if (lastPt !== null) {
                    el.style.top = `${lastPt.y}px`
                    el.style.left = `${lastPt.x}px`
                }
            },
            checkout() {
                let details = formatOrderCheckoutDetails(this.orders);
                let tableNo = this.position.tableNo;
                let storeID = this.position.storeID;
                let data = {tableNo, details, storeID};
                checkout(data).then(response => {
                    console.log(response);
                    if (response.data.code == 202) {
                        Toast({
                            message: `點餐成功,請耐心等待～`,
                            position: 'middle',
                            duration: 5000
                        });
                    }
                })
            }
        }
    }
</script>