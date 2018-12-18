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
