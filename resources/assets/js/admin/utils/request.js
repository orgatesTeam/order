import axios from 'axios'
import {getToken, removeToken} from './auth'
import {Toast} from 'mint-ui';

// create an axios instance
const service = axios.create({
    baseURL: process.env.BASE_API, // api的base_url
    timeout: 5000 // request timeout
})

// request interceptor
service.interceptors.request.use(config => {
    // Do something before request is sent
    //loading 畫面開啟
    app.$store.commit('setLoadingStatus', true)

    //請求帶入 jwt token
    if (getToken()) {
        config.data['token'] = getToken()
    }
    return config
}, error => {
    // Do something with request error
    console.log(error) // for debug
    Promise.reject(error)
})

// response interceptor
service.interceptors.response.use(
    response => {
        console.log(response)
        if (response.data.code != '202') {
            Toast({
                message: response.data.errors.message,
            });
        }

        //remove token
        if (response.data.errors && response.data.errors.status == '100') {
            Toast({
                message: '一段時間未使用,請重新登入',
            });
            removeToken()
            app.$router.push({name: 'login'})
        }
        app.$store.commit('setLoadingStatus', false)
        return response
    },
    error => {
        console.log(error)
        let {status, statusText, data} = error.response
        Toast({
            message: {
                status: status,
                statusText: statusText,
                data: data
            },
            duration: 50000
        });
        console.log('err' + error) // for debug
        return Promise.reject(error)
    })

export default service
