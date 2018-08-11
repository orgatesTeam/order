import Vue from 'vue'
import Vuex from 'vuex'
import menu from './modules/menu'
import form from './modules/form'
import getters from './getters'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        menu,
        form
    },
})

export default store
