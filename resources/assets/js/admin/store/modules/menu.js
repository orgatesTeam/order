const menu = {
    state: {
        page: 1,
        menus: []
    },
    mutations: {
        setMenuPage(state, page) {
            state.page = page
        },
        setEditMenu(state, menu) {
            state.editMenu = menu
        },
        setMenus(state, response) {
            state.menus[response.page] = response.menus
        },
        resetMenus(state) {
            state.menus = [];
        }
    },
    actions: {}
}

export default menu
