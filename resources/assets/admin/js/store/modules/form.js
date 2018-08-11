//畫面參數
const form = {
    state: {
        title: '後台管理',
        linkName: {name: 'menu'},
    },
    mutations: {
        setFormTitle(state, title) {
            state.title = title
        },
        setRouterLinkName(state, name) {
            state.linkName = name
        }
    },
    actions: {}
}

export default form
