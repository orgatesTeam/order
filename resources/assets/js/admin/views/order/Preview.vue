<template>
    <div class="main-container">
        <div v-for="menu,index in menus">
            <div @click="regulate(menu)">
                <mt-cell :title="menu.name">
                    <span style="color: green">{{`X${amount(menu.id)}`}}</span>
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
            menus() {
                return this.$store.state.order.menus
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
            regulate(menu) {
                this.$store.commit('setRegulateTempMenu', menu)
                this.$store.commit('setShowRegulation', true)
            },
        }
    }
</script>