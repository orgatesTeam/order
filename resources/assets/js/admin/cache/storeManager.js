import * as storeManager from '../api/store'
import store from '../store'

export function getStores(callback) {
    if (store.state.storeManager.cacheStores !== null) {
        callback(store.state.storeManager.cacheStores)
    } else {
        storeManager.fetchList({}).then(response => {
            if (response.data.code == '202') {
                let stores = response.data.items.stores
                store.commit('setCacheStores', stores)
                callback(stores)
            }
        })
    }
}