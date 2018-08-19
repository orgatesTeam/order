//畫面參數
const form = {
    state: {
        title: '後台管理',
        linkName: {name: 'menu'},
        from: null,
        hackAppMainReset: true
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
        },
        setHackAppMainResetStatue(state, status) {
            state.hackAppMainReset = status
        }
    },
    actions: {}
}

export default form
