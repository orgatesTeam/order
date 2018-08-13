import Vue from 'vue'
import VueRouter from 'vue-router'
import {getToken} from "../utils/auth";

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
                }, ,
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
                },
                {
                    path: 'system-menu',
                    name: 'system-menu',
                    component: require('../views/system/SystemMenu')
                },
                {
                    path: 'system',
                    name: 'system',
                    component: require('../views/system/System')
                },
                {
                    path: 'report',
                    name: 'report',
                    component: require('../views/report/Report')
                }
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

    //防呆還沒初始好
    if (app instanceof Object &&
        app.hasOwnProperty('$store') &&
        app.$store.hasOwnProperty('commit')) {
        let checkFooterMenu = () => {
            let checkPath = ['menu', 'report', 'system', 'system-menu']
            checkPath.forEach(path => {
                if (path == to.name) {
                    app.$store.commit('setFooterMenu', path)
                }
            })
        }

        checkFooterMenu()
    }
})

export default router