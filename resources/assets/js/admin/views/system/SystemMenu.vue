<template>
    <div>
        <div @click="routerPush('menu')">
            <mt-cell title="菜單管理"></mt-cell>
        </div>
        <div @click="routerPush('system-table-manager')">
            <mt-cell title="桌位管理"></mt-cell>
        </div>
        <div @click="routerPush('store')">
            <mt-cell title="店家管理"></mt-cell>
        </div>
        <div @click="routerPush('order')">
            <mt-cell title="點餐管理"></mt-cell>
        </div>
        <div @click="logout()">
            <mt-cell title="登出"></mt-cell>
        </div>
    </div>
</template>

<script>
    import {removeToken} from '../../utils/auth'

    export default {
        name: "SystemMenu",
        mounted() {
            this.$store.commit('setFormTitle', '選單')
        },
        methods: {
            routerPush(name) {
                this.$router.push({name: name})
            },
            logout() {
                removeToken()
                this.$router.push({name: 'login'})
            }
        }
    }
</script>

<style scoped>

</style>