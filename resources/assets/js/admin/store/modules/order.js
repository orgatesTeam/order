const order = {
    state: {
        orders: [],
        orderCount: 0,
        showRegulation: false,
        regulateOrderIndex: 0,
    },
    mutations: {
        pushOrder(state, {menu, tastesOptions}) {
            state.orders.push({menu, tastesOptions})
            state.orderCount = state.orders.length
        },
        setShowRegulation(state, show) {
            state.showRegulation = show
        },
        setRegulateOrderIndex(state, index) {
            state.regulateOrderIndex = index
        },
    },
    actions: {}
}

export default order
