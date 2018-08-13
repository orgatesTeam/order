<template>
    <div>
        <div @click="toMenu()">
            <mt-cell title="菜單選單"></mt-cell>
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
            toMenu() {
                this.$router.push({name: 'menu'})
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