import Cookies from 'js-cookie'

const TokenKey = 'Admin-Token'
const Email = 'Admin-Email'

export function getToken() {
    return Cookies.get(TokenKey)
}

export function setToken(token) {
    return Cookies.set(TokenKey, token)
}

export function removeToken() {
    return Cookies.remove(TokenKey)
}

export function getEmail() {
    return Cookies.get(Email)
}

export function setEmail(email) {
    return Cookies.set(Email, email)
}