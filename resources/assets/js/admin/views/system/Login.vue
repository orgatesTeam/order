<template>
    <div>
        <div class="input-area">
            <mt-field label="帳號" placeholder="請輸入帳號" type="email" v-model="email"></mt-field>
            <mt-field label="密碼" placeholder="請輸入密碼" type="password" v-model="password"></mt-field>
        </div>
        <div class="login-area" @click="login">
            <mt-button type="primary" size="large">登入</mt-button>
        </div>
    </div>
</template>
<style scoped>
    label {
        color: #ffffff;
    }

    .input-area {
        padding: 30vh 0 5vh 0;
    }

    .login-area {
        padding: 0 20vw 0 20vw;
    }

</style>
<script>
    import {login} from '../../api/auth'
    import {setToken, setEmail, getEmail} from '../../utils/auth'

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
                        that.$router.push({name: 'menu'})
                    }
                })
            }
        }
    }
</script>