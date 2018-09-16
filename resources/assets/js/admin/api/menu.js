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

export function createMenu(data) {
    return request({
        url: '/admin/menu/create-menu',
        method: 'post',
        data: data
    })
}

export function searchMenuByName(data) {
    return request({
        url: '/admin/menu/search-by-name',
        method: 'post',
        data: data
    })
}

export function listByStoreMenu(data) {
    return request({
        url: '/admin/menu/list-by-store-menu',
        method: 'post',
        data: data
    })
}

export function listByStore(data) {
    return request({
        url: '/admin/menu/list-by-store',
        method: 'post',
        data: data
    })
}

export function createMenuType(data) {
    return request({
        url: '/admin/menu/create-menu-type',
        method: 'post',
        data: data
    })
}

export function updateMenuType(data) {
    return request({
        url: '/admin/menu/update-menu-type',
        method: 'post',
        data: data
    })
}

export function deleteMenuType(data) {
    return request({
        url: '/admin/menu/delete-menu-type',
        method: 'post',
        data: data
    })
}


