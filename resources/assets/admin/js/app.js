import Vue from 'vue'
import App from './views/App'
import router from './router'

const app = new Vue({
    data: {
        sideNav: null
    },
    el: '#app',
    router,
    created() {
        let that = this
        $(document).ready(function () {
            document.addEventListener('DOMContentLoaded', function () {
                let elements = document.querySelectorAll('.sidenav');
                that.instances = M.Sidenav.init(elements, {});
            });

            $('.sidenav').sidenav();
            $(".dropdown-trigger").dropdown();
        });
    },
    watch: {
        '$route': function () {
        }
    },
    render: h => h(App),
});

var Paginate = require('vuejs-paginate')
Vue.component('paginate', Paginate)