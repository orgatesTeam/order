<template>
    <div class="main-container">
        <div v-for="menu,index in menus">
            <div @click="regulate(index)">
                <mt-cell :title="menu.name">
                    <span style="color: green">{{`X${menu.amount}`}}</span>
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
        data() {
            return {
                menu: null
            }
        },
        computed: {
            menus() {
                return this.$store.state.order.menus
            },
        },
        methods: {
            regulate(index) {
                this.$store.commit('setRegulateMenuIndex', index)
                this.$store.commit('setShowRegulation', true)
            },
        }
    }
</script>

<style scoped>

</style>