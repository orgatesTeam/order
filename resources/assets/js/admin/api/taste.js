import request from '../utils/request'

export function fetchList(data) {
    return request({
        url: '/admin/taste/list',
        method: 'post',
        data: data
    })
}

export function newTaste(data) {
    return request({
        url: '/admin/taste/new',
        method: 'post',
        data: data
    })
}

export function updateTaste(data) {
    return request({
        url: '/admin/taste/update',
        method: 'post',
        data: data
    })
}

export function deleteTaste(data) {
    return request({
        url: '/admin/taste/delete',
        method: 'post',
        data: data
    })
}