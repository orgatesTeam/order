<style scoped>
    .price > .title {
        font-weight: bold;
        flex: 1
    }

    .price > .math {
        flex: 1;
        color: red;
    }

    .details {
        margin-top: 20px;
    }

    .details > .name {
        flex: 3.5;
    }

    .details > .sum {
        flex: 3;
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
        <div class="function-btn font-8">
            <div @click="storeActionSheet = true" class="inline-dev">
                <mt-button type="danger">優惠</mt-button>
            </div>
            <div @click="storeActionSheet = true" class="inline-dev">
                <mt-button type="primary">總結</mt-button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Total",
        data() {
            return {
                totalPrice: 0
            }
        },
        computed: {
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
                    that.totalPrice += menu.menu_price

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
        methods: {}
    }
</script>