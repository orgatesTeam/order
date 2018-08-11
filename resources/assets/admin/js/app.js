import Vue from 'vue'
import App from './views/App'
import router from './router'
import store from './store'
import MintUI from 'mint-ui'

Vue.use(MintUI)

window.app = new Vue({
    data: {
        sideNav: null
    },
    el: '#app',
    router,
    store,
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
window.app = app;