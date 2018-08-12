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
                    path: '/',
                    name: '/',
                    component: require('../views/menu/Menu')
                },,
                {
                    path: 'hello',
                    name: 'hello',
                    component: require('../views/Hello')
                },
                {
                    path: 'menu',
                    name: 'menu',
                    component: require('../views/menu/Menu')
                },
                {
                    path: 'menu-edit',
                    name: 'menu-edit',
                    component: require('../views/menu/Edit')
                }
            ]
        },
    ]
});

export default router