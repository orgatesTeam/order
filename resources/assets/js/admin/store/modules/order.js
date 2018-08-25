const order = {
    state: {
        menus: null,
        showRegulation: false,
        regulateMenuIndex: null,
        regulateMenus: []
    },
    mutations: {
        setOrderMenus(state, menus) {
            state.menus = menus
        },
        setShowRegulation(state, show) {
            state.showRegulation = show
        },
        setRegulateMenuIndex(state, index) {
            state.regulateMenuIndex = index
        },
        setRegulateMenus(state, regulateMenu) {
            state.regulateMenus.push(regulateMenu)
        }
    },
    actions: {}
}

export default order
