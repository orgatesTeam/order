import axios from 'axios'
import {getToken} from './auth'
import {Toast} from 'mint-ui';

// create an axios instance
const service = axios.create({
    baseURL: process.env.BASE_API, // api的base_url
    timeout: 5000 // request timeout
})

// request interceptor
service.interceptors.request.use(config => {
    // Do something before request is sent
    app.$store.commit('setLoadingStatus', true)
    // if (store.getters.token) {
    //     // 让每个请求携带token-- ['X-Token']为自定义key 请根据实际情况自行修改
    //     config.headers['X-Token'] = getToken()
    // }
    return config
}, error => {
    // Do something with request error
    console.log(error) // for debug
    Promise.reject(error)
})

// respone interceptor
service.interceptors.response.use(
    response => {
        if (response.data.code != '202') {
            Toast({
                message: response.data.errors.message,
            });
        }
        app.$store.commit('setLoadingStatus', false)
        return response
    },
    error => {
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
