const habit = {
    state: {
        //order total function 功能按鈕 座標
        orderTotalMoveLastPt: null
    },
    mutations: {
        setOrderTotalMoveLastPt(state, lastPt) {
            state.orderTotalMoveLastPt = lastPt
        },
    },
    actions: {}
}

export default habit
