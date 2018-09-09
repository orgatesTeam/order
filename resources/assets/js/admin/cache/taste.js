import * as taste from '../api/taste'
import store from '../store'

export function getTastes(callback, force = false) {
    if (store.state.taste.cacheTastes === null || force === true) {
        taste.fetchList({}).then(response => {
            if (response.data.code == '202') {
                let tastes = response.data.items.tastes
                store.commit('setCacheTastes', tastes)
                callback(tastes)
            }
        })
    } else {
        callback(store.state.taste.cacheTastes)
    }
}