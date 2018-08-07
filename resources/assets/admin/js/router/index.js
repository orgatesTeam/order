import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/admin', component: require('../views/layout/Layout'),
            children: [
                {
                    path: 'hello',
                    name: 'hello',
                    component: require('../views/Hello')
                },
                {
                    path: 'order',
                    name: 'order',
                    component: require('../views/order/Order')
                }
            ]
        }
    ]
});

export default router