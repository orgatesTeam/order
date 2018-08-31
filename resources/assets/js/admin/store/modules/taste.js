const taste = {
    state: {
        //編輯或者新增的暫存 start
        name: '',
        options: [],
        tasteOptionsIndex: null,
        editTasteID: null,
        //編輯或者新增的暫存 end
        tastes: []
    },
    mutations: {
        //編輯或者新增的暫存 start
        setTasteOption(state, option) {
            let index = state.tasteOptionsIndex
            if (index != null) {
                state.options[index] = option
                return
            }
            state.options.push(option)
        },
        setTasteOptionsIndex(state, index) {
            state.tasteOptionsIndex = index
        },
        setTasteName(state, name) {
            state.name = name
        },
        setTasteOptions(state, options) {
            state.options = options
        },
        cancelEditTasteOptions(state) {
            state.name = ''
            state.options = []
        },
        setEditTasteID(state, id) {
            state.editTasteID = id
        },
        //編輯或者新增的暫存 end
        //暫存tastes
        setTastes(state, tastes) {
            state.tastes = tastes
        }

    },
    actions: {}
}

export default taste
