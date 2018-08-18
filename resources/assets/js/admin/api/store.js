import request from '../utils/request'

export function fetchList(data) {
    return request({
        url: '/admin/store/list',
        method: 'post',
        data: data
    })
}

export function createStore(data) {
    return request({
        url: '/admin/store/create',
        method: 'post',
        data: data
    })
}

export function updateStore(data) {
    return request({
        url: '/admin/store/update',
        method: 'post',
        data: data
    })
}

export function addMenu(data) {
    return request({
        url: '/admin/store/add-menu',
        method: 'post',
        data: data
    })
}
