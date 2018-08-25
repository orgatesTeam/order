import Vue from 'vue'
import Vuex from 'vuex'
import menu from './modules/menu'
import form from './modules/form'
import popup from './modules/popup'
import storeManager from './modules/storeManager'
import order from './modules/order'
import getters from './getters'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        menu,
        form,
        popup,
        storeManager,
        order
    },
})

export default store
