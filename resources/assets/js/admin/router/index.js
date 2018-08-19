import Vue from 'vue'
import VueRouter from 'vue-router'
import {getToken} from '../utils/auth';

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
                },
            ]
        },
        //dashboard
        {
            path: '/admin/dashboard', component: require('../views/layout/Layout'),
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: require('../views/dashboard/Dashboard')
                },
            ]
        },
        //menu
        {
            path: '/admin/menu', component: require('../views/layout/Layout'),
            children: [
                {
                    path: '/',
                    name: 'menu',
                    component: require('../views/menu/Menu')
                },
                {
                    path: 'edit',
                    name: 'menu-edit',
                    component: require('../views/menu/Edit')
                },
            ]
        },
        //store
        {
            path: '/admin/store', component: require('../views/layout/Layout'),
            children: [
                {
                    path: '/',
                    name: 'store',
                    component: require('../views/store/Store')
                },
                {
                    path: 'edit',
                    name: 'store-edit',
                    component: require('../views/store/Edit')
                },
                {
                    path: 'import-menu',
                    name: 'store-import-menu',
                    component: require('../views/store/ImportMenu')
                },
            ]
        },
        //report
        {
            path: '/admin/report', component: require('../views/layout/Layout'),
            children: [
                {
                    path: '/',
                    name: 'report',
                    component: require('../views/report/Report')
                }
            ]
        },
        //system
        {
            path: '/admin/system', component: require('../views/layout/Layout'),
            children: [
                {
                    path: '/',
                    name: 'system',
                    component: require('../views/system/System')
                },
                {
                    path: 'menu',
                    name: 'system-menu',
                    component: require('../views/system/SystemMenu')
                },
                {
                    path: 'table-manager',
                    name: 'system-table-manager',
                    component: require('../views/system/TableManager')
                },
            ]
        },
        {
            path: '/admin/login',
            name: 'login',
            component: require('../views/system/Login')
        },
    ]
});

router.beforeEach((to, from, next) => {
    console.log(to.name)
    //未登入 訪問其他頁面
    if (to.name != 'login' && !getToken()) {
        next({name: 'login'})
        return
    }

    //登入 訪問登入頁面
    if (to.name == 'login' && getToken()) {
        next({name: 'menu'})
        return
    }

    next()
})
router.afterEach((to, from) => {
})

export default router