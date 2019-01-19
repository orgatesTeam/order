import {deepObjectClone} from "./helper";

export function tastesOptionsCountPrice(tastesOptions) {
    let totalPrice = 0;
    tastesOptions.forEach(tasteOptions => {
        tasteOptions.options.forEach(option => {
            let checkPrice = option.select.price;
            checkPrice = checkPrice == undefined ? 0 : parseInt(checkPrice, 10);
            totalPrice += checkPrice;
        })
    })
    return totalPrice;
}

function parseTastesOptions(tastesOptions) {
    let tastesName = [];
    let tastesPrice = 0;
    tastesOptions.forEach(tasteOption => {
        tasteOption.options.forEach(option => {
            let {name, price} = option.select;
            tastesName.push(name);
            tastesPrice += parseInt(price, 10);
        })
    })
    return {tastesName, tastesPrice};
}

export function formatOrderCheckoutDetails(orders) {
    let totalPrice = 0;
    let orderSpec = {
        menuName: '',
        menuPrice: 0,
        tastesName: []
    }
    let orderCheckDetails = [];
    orders.forEach(order => {
        let tempOrderSpec = deepObjectClone(orderSpec);
        let {menu, tastesOptions} = order;
        let {tastesName, tastesPrice} = parseTastesOptions(tastesOptions);
        tempOrderSpec.menuName = menu.menu_name;
        tempOrderSpec.menuPrice = menu.menu_price + tastesPrice;
        tempOrderSpec.tastesName = tastesName;
        totalPrice += tempOrderSpec.menuPrice;
        orderCheckDetails.push(tempOrderSpec)
    })

    return {totalPrice, orderCheckDetails};
}