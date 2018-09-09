import * as storeManager from '../api/store'
import store from '../store'

export function getStores(callback, force = false) {
    if (store.state.storeManager.cacheStores === null || force === true) {
        storeManager.fetchList({}).then(response => {
            if (response.data.code == '202') {
                let stores = response.data.items.stores
                store.commit('setCacheStores', stores)
                callback(stores)
            }
        })
    } else {
        callback(store.state.storeManager.cacheStores)
    }
}