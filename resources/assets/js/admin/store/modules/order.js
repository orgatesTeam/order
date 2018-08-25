const order = {
    state: {
        menus: null,
        showRegulation: false,
        regulateMenuIndex: 0
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
        }
    },
    actions: {}
}

export default order
