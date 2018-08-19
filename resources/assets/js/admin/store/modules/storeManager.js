const store = {
    state: {
        cacheStores: null,
        editStore: null,
        //匯入菜單之store
        storeToImportMenu: null,
    },
    mutations: {
        setCacheStores(state, stores) {
            state.cacheStores = stores
        },
        setEditStore(state, store) {
            state.editStore = store
        },
        setStoreToImportMenu(state, store) {
            state.storeToImportMenu = store
        }
    },
    actions: {}
}

export default store
