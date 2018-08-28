const taste = {
    state: {
        name: '',
        options: [],
        tasteOptionsIndex: null,
        editTasteID: null
    },
    mutations: {
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
        }
    },
    actions: {}
}

export default taste
