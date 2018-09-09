import * as menu from '../api/menu'
import store from '../store'

export function getMenus(callback) {
    let page = store.state.menu.page
    if (store.state.menu.cacheMenus[page]) {
        callback(store.state.menu.cacheMenus[page])
    } else {
        let data = {page: page}
        menu.fetchList(data).then(response => {
            if (response.data.code == 202) {
                let menus = response.data.items.menus
                store.commit('setCacheMenus', {page: page, menus: menus})
                callback(menus)
            }
        })
    }
}

export function getMenuTypes(callback) {
    if (store.state.menu.cacheMenuTypes !== null) {
        callback(store.state.menu.cacheMenuTypes)
    } else {
        menu.fetchMenuTypes({}).then(response => {
            let menuTypes = response.data.items.menuTypes
            store.commit('setCacheMenuTypes', menuTypes)
            callback(menuTypes)
        })
    }
}