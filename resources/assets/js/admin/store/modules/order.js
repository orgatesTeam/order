const order = {
    state: {
        menus: null,
        showRegulation: false,
        regulateTempMenu: null,
        regulateMenus: []
    },
    mutations: {
        setOrderMenus(state, menus) {
            state.menus = menus
        },
        setShowRegulation(state, show) {
            state.showRegulation = show
        },
        setRegulateTempMenu(state, menu) {
            state.regulateTempMenu = menu
        },
        setRegulateMenus(state, regulateMenu) {

            let exist = false
            state.regulateMenus.forEach((menu, index) => {
                if (menu.id == regulateMenu.id) {
                    exist = true
                    state.regulateMenus[index] = regulateMenu
                }
            })

            if (!false) {
                state.regulateMenus.push(regulateMenu)
            }
        }
    },
    actions: {}
}

export default order
