import request from '../utils/request'

export function fetchList(data) {
    return request({
        url: '/admin/menu/list',
        method: 'post',
        data: data
    })
}