import Vue from 'vue'
import Vuex from 'vuex'
import {getCookie} from '#/util/cookie';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    isLoggedIn: !!getCookie('token'), // !!localStorage.getItem('token')
    userName: getCookie('userName'),
  },
  mutations: {
    loginUser(state, user) {
      state.isLoggedIn = true;
      state.userName = user.name;
    },
    logoutUser(state) {
      state.isLoggedIn = false;
      state.userName = null;
    },
  }
});
