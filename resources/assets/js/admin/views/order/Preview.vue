<template>
    <div class="main-container">
        <div v-for="order,index in orders">
            <div @click="regulate(index)">
                <mt-cell :title="order.menu.menu_name" value="編輯口味">
                </mt-cell>
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