const taste = {
    state: {
        //編輯或者新增的暫存 start
        editTaste: null,
        editTasteOptions: [],
        tasteOptionIndex: null,
        //編輯或者新增的暫存 end
        tastes: null
    },
    mutations: {
        //cache tastes
        //暫存tastes
        setTastes(state, tastes) {
            state.tastes = tastes
        },
        //編輯或者新增的暫存 start
        setEditTaste(state, taste) {
            state.editTaste = taste
        },
        setEditTasteOptions(state, options) {
            state.editTasteOptions = options
        },
        setTasteOptionIndex(state, index) {
            state.tasteOptionIndex = index
        },
        cancelEditTasteOptions(state) {
            state.tasteOptionIndex = null
            state.options = []
        },
        //編輯或者新增的暫存 end
    },
    actions: {}
}

export default taste
