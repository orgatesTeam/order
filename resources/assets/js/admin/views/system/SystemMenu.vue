<template>
    <div>
        <div v-for="(menu,key,index) in menus" @click="routerPush(key)" class="box">
            {{menu}}
        </div>
        <div @click="logout()" class="box">
            登出
        </div>
    </div>
</template>

<script>
    import {removeToken} from '../../utils/auth'

    export default {
        name: "SystemMenu",
        data() {
            return {
                menus: {
                    'menu': '菜單管理',
                    'menu-type': '菜單種類管理',
                    'menu-taste': '口味管理',
                    'system-table-manager': '桌位管理',
                    'order': '點餐管理',
                    'store': '店家管理',
                }
            }
        },
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
    .box {
        border-bottom: 0.5px black solid;
        padding: 10px 10px;
        font-size: 16px;
    }
</style>