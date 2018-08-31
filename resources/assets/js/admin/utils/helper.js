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

export function deepObjectClone(object) {
    return JSON.parse(JSON.stringify(object))
}

//強制刷新元件
//layout.vue 會預設刷新 v-if
//透過 vuex 變動裡面布林
export function hackReset(instance, component = 'appMain') {
    if (component == 'appMain') {
        instance.$store.commit('setHackAppMainResetStatue', false)
        instance.$nextTick(() => {
            instance.$store.commit('setHackAppMainResetStatue', true)
        })
    }
}