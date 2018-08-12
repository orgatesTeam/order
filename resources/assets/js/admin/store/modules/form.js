//畫面參數
const form = {
    state: {
        title: '後台管理',
        linkName: {name: 'menu'},
        from: null
    },
    mutations: {
        setFormTitle(state, title) {
            state.title = title
        },
        setRouterLinkName(state, name) {
            state.linkName = name
        },
        setFrom(state, from) {
            state.form = from
        }
    },
    actions: {}
}

export default form
