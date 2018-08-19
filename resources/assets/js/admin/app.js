import Vue from 'vue'
import App from './views/App'
import router from './router'
import store from './store'
import MintUI from 'mint-ui'
require('./bootstrap');

Vue.use(MintUI)

window.app = new Vue({
    data: {
        sideNav: null
    },
    el: '#app',
    router,
    store,
    created() {
    },
    render: h => h(App),
});
