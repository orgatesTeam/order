<template>
    <div>
        <div class="input-area">
            <div class="company-img">
                <img src="/images/admin/order.jpg" alt="" width="150" height="auto">
            </div>
            <mt-field label="帳號" placeholder="請輸入帳號" type="email" v-model="email"></mt-field>
            <mt-field label="密碼" placeholder="請輸入密碼" type="password" v-model="password"></mt-field>
        </div>
        <div class="login-area" @click="login">
            <mt-button type="primary" size="large">登入</mt-button>
        </div>
    </div>
</template>
<style scoped>

    .company-img {
        margin-bottom: 20px;
    }

    label {
        color: #ffffff;
    }

    .input-area {
        padding: 18vh 0 5vh 0;
        text-align: center;
    }

    .login-area {
        padding: 0 20vw 0 20vw;
    }

</style>
<script>
    import {login} from '../../api/auth'
    import {setToken, setEmail, getEmail} from '../../utils/auth'
    import {getMenus} from "../../cache/menu";
    import {getTastes} from "../../cache/taste";
    import {getStores} from "../../cache/storeManager";

    export default {
        data() {
            return {
                email: '',
                password: ''
            }
        },
        name: "Login",
        mounted() {
            this.email = getEmail()
        },
        methods: {
            login() {
                setEmail(this.email)
                let that = this
                let data = {
                    email: this.email,
                    password: this.password
                }
                login(data).then(response => {
                    if (response.data.code == 202) {
                        setToken(response.data.items.token)
                        that.initCache()
                    }
                })
            },
            async initCache() {
                let callback = () => {
                }
                await getTastes(callback)
                await getMenus(callback)
                await getStores(callback)
                await this.$router.push({name: 'menu'})
            }
        }
    }
</script>