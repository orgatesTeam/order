//畫面參數
const form = {
    state: {
        title: '後台管理',
        linkName: {name: 'menu'},
        from: null,
        footerMenu: 'menu'
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
        setFooterMenu(state, menu) {
            state.footerMenu = menu
        }
    },
    actions: {}
}

export default form
