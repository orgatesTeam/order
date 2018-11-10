<style scoped>

    .top-border {
        border-top: 1px solid #eee;
    }

    .order-wrap {
        border-bottom: 1px solid #eee;
    }

    .order-1 > .title {
        font-weight: bold;
        flex: 3.5;
    }

    .order-1 > .money {
        flex: 1.5;
        color: goldenrod;
        font-weight: bold;
    }

    .order-taste {
        color: #888;
    }

    .order-taste > .title {
        flex: 2;
    }

    .order-taste > .content {
        flex: 3;
    }
</style>
<template>
    <div class="main-container">
        <div v-for="order,index in orders">
            <div class="order-wrap container-10" @click="regulate(index)" :class="{'top-border':index == 0}">
                <div class="order-1 flex-container font-6">
                    <div class="title">
                        {{order.menu.menu_name}}
                    </div>
                    <div class="money">
                        {{order.menu.menu_price}}
                    </div>
                </div>
                <div v-for="tasteOption in order.tastesOptions">
                    <div class="order-taste flex-container font-4" v-for="option in tasteOption.options">
                        <div class="title">{{option.name}}</div>
                        <div class="content">{{option.select}}</div>
                    </div>
                </div>
            </div>
        </div>
        <regulation></regulation>
    </div>
</template>

<script>
    import Regulation from './Regulation'

    export default {
        name: "Preview",
        components: {Regulation},
        computed: {
            orders() {
                return this.$store.state.order.orders
            }
        },
        methods: {
            amount(menuID) {
                let amount = 1
                this.$store.state.order.regulateMenus.forEach(menu => {
                    if (menu.id == menuID) {
                        amount = menu.amount
                    }
                })
                return amount
            },
            regulate(index) {
                this.$store.commit('setRegulateOrderIndex', index)
                this.$store.commit('setShowRegulation', true)
            },
        }
    }
</script>