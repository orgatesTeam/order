const menu = {
    state: {
        page: 1,
        cacheMenus: [],
        cacheMenuTypes: null,
        editMenu: null
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
        setCacheMenuTypes(state, menuTypes) {
            state.cacheMenuTypes = menuTypes
        },
        refreshMenus(state) {
            state.cacheMenus = [];
        }
    },
    actions: {}
}

export default menu
