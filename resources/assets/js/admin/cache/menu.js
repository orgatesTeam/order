import * as menu from '../api/menu'
import store from '../store'

export function getMenus(callback, force = false) {
    let page = store.state.menu.page
    if (store.state.menu.cacheMenus[page] === undefined || force === true) {
        menu.fetchList({page: page}).then(response => {
            if (response.data.code == 202) {
                let menus = response.data.items.menus
                store.commit('setCacheMenus', {page: page, menus: menus})
                callback(menus)
            }
        })
    } else {
        callback(store.state.menu.cacheMenus[page])
    }
}

export function getMenuTypes(callback, force = false) {
    if (store.state.menu.cacheMenuTypes === null || force === true) {
        menu.fetchMenuTypes({}).then(response => {
            let menuTypes = response.data.items.menuTypes
            store.commit('setCacheMenuTypes', menuTypes)
            callback(menuTypes)
        })
    } else {
        callback(store.state.menu.cacheMenuTypes)
    }
}