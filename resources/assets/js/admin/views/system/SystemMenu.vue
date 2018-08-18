<template>
    <div>
        <div @click="routerPush('menu')">
            <mt-cell title="菜單選單"></mt-cell>
        </div>
        <div @click="routerPush('table-manager')">
            <mt-cell title="桌位管理"></mt-cell>
        </div>
        <div @click="logout()">
            <mt-cell title="登出"></mt-cell>
        </div>
    </div>
</template>

<script>
    import {CellSwipe} from 'mint-ui';
    import {removeToken} from '../../utils/auth'

    export default {
        name: "SystemMenu",
        mounted() {
            this.$store.commit('setFormTitle', '選單')
        },
        comments: [CellSwipe.name, CellSwipe],
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