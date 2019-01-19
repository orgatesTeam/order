import request from '../utils/request'

export function check(data) {
    return request({
        url: '/admin/order/check',
        method: 'post',
        data: data
    })
};