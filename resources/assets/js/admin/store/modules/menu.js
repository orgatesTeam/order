const menu = {
    state: {
        page: 1,
        cacheMenus: []
    },
    mutations: {
        setMenuPage(state, page) {
            state.page = page
        },
        setEditMenu(state, menu) {
            state.editMenu = menu
        },
        setCacheMenus(state, response) {
            state.cacheMenus[response.page] = response.menus
        },
        resetMenus(state) {
            state.cacheMenus = [];
        }
    },
    actions: {}
}

export default menu
