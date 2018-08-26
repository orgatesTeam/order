import request from '../utils/request'

export function fetchList(data) {
    return request({
        url: '/admin/taste/list',
        method: 'post',
        data:data
    })
}

export function newTaste(data) {
    return request({
        url: '/admin/taste/new',
        method: 'post',
        data: data
    })
}

export function editTaste(data) {
    return request({
        url: '/admin/taste/edit',
        method: 'post',
        data: data
    })
}