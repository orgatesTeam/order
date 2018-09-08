const taste = {
    state: {
        editTaste: null,
        tasteOptionIndex: null,
        tastes: null
    },
    mutations: {
        //cache tastes
        //暫存tastes
        setTastes(state, tastes) {
            state.tastes = tastes
        },
        setEditTaste(state, taste) {
            state.editTaste = taste
        },
        setTasteOptionIndex(state, tasteOptionIndex) {
            state.tasteOptionIndex = tasteOptionIndex
        }
    },
    actions: {}
}

export default taste
