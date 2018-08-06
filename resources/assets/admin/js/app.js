import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import Login from './views/Login'
import Hello from './views/Hello'

import App from './views/App'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/admin/login',
            name: 'login',
            component: Login
        },
        {
            path: '/admin/hello',
            name: 'hello',
            component: Hello
        },
    ],
});

const app = new Vue({
    el: '#app',
    created() {
        $(document).ready(function () {
            $('.sidenav').sidenav();
            $(".dropdown-trigger").dropdown();
        });
    },
    watch: {
        '$route': function () {
            alert(1)
        }
    },
    components: {App},
    router,
});

var Paginate = require('vuejs-paginate')
Vue.component('paginate', Paginate)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });
