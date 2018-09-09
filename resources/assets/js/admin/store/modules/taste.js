const taste = {
    state: {
        editTaste: null,
        tasteOptionIndex: null,
        cacheTastes: null
    },
    mutations: {
        setCacheTastes(state, tastes) {
            state.cacheTastes = tastes
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
