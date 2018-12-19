import request from '../utils/request'

export function checkout(data) {
    return request({
        url: '/admin/order/checkout',
        method: 'post',
        data: data
    })
};