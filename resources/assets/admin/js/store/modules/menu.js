const menu = {
    state: {
        page: 1,
    },
    mutations: {
        setMenuPage(state, page) {
            state.page = page
        },
        setEditMenu(state, menu) {
            state.editMenu = menu
        }
    },
    actions: {}
}

export default menu
