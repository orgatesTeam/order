import {getTastes} from "../../cache/taste";
import {deepObjectClone} from "../../utils/helper";

const order = {
    state: {
        orders: [],
        orderCount: 0,
        showRegulation: false,
        regulateOrderIndex: 0,
        selectStore: null,
    },
    mutations: {
        pushOrder(state, {menu, tastesOptions}) {

            //口味
            if (tastesOptions === undefined) {
                tastesOptions = []
                getTastes(tastes => {
                    let tasteIDs = menu.menu_taste_ids.split(',')
                    tastes.forEach(taste => {
                        if (tasteIDs.includes(String(taste.id))) {
                            let tasteTemp = deepObjectClone(taste)
                            let options = [];
                            tasteTemp.options.forEach(option => {
                                option.showActionsheet = false;
                                //預設口味第一個
                                let selectCheck = option.checks[0];
                                let price = selectCheck.price == undefined ? 0 : selectCheck.price;
                                let name = selectCheck.name;
                                option.select = {name, price};
                                options.push(option)
                            })
                            tasteTemp.options = options
                            tastesOptions.push(tasteTemp)
                        }
                    })
                })
            }

            state.orders.push({menu, tastesOptions})
            //排序
            let orders = state.orders.sort(function (a, b) {
                return (a.menu.menu_id < b.menu.menu_id) ? -1 : 0
            })

            state.orders = orders
            state.orderCount = state.orders.length
        },
        removeOrdersByIndex(state, index) {
            if (state.orders[index]) {
                console.log(state.orders)
                console.log(index)
                state.orders.splice(index, 1)
            }
        },
        setShowRegulation(state, show) {
            state.showRegulation = show
        },
        setRegulateOrderIndex(state, index) {
            state.regulateOrderIndex = index
        },
        setSelectStore(state, store) {
            state.selectStore = store
        },
        refreshOrders(state) {
            state.orders = [];
            state.orderCount = 0;
            state.showRegulation = false;
            state.regulateOrderIndex = 0;
            state.selectStore = null;
        }
    },
    actions: {}
}

export default order
