import request from '../utils/request'

export function fetchList(data) {
    return request({
        url: '/admin/menu/list',
        method: 'post',
        data: data
    })
}

export function fetchMenuTypes(data) {
    return request({
        url: '/admin/menu/menu-types',
        method: 'post',
        data: data
    })
}

export function updateMenu(data) {
    return request({
        url: '/admin/menu/update-menu',
        method: 'post',
        data: data
    })
}