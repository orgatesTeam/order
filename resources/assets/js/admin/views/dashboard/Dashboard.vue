<template>
    <div>
        <div class="comming-soon">
            <a  @click="menu">請選擇右下選單按鈕</a>
        </div>
    </div>
</template>

<script>
    import {getMenus} from "../../cache/menu";
    import {getTastes} from "../../cache/taste";
    import {getStores} from "../../cache/storeManager";
    import {getMenuTypes} from "../../cache/menu";

    export default {
        name: "Dashboard",
        mounted() {
            let callback = () => {
            }
            getTastes(callback)
            getMenus(callback)
            getStores(callback)
            getMenuTypes(callback)

            this.$store.commit('setFormTitle', '主頁')
        },
        methods: {
            menu() {
                this.$router.push({name: 'system-menu'})
            }
        }
    }
</script>

<style scoped>

</style>