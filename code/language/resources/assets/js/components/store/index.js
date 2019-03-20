import Vue from 'vue'
import Vuex from 'vuex'
import {getCookie} from '#/util/cookie';

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    isLoggedIn: !!getCookie('token') // !!localStorage.getItem('token')
  },
  mutations: {
    loginUser(state) {
      state.isLoggedIn = true
    },
    logoutUser(state) {
      state.isLoggedIn = false
    },
  }
});
