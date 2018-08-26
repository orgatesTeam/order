export function paddingLeft(str, length) {
    str = str.toString()
    if (str.length >= length)
        return str;
    else
        return paddingLeft("0" + str, length);
}

export function gotoBottom(id) {
    var element = document.getElementById(id);
    element.scrollTop = element.scrollHeight - element.clientHeight;
}

export function deepClone(object) {
    return JSON.parse(JSON.stringify(object))
}