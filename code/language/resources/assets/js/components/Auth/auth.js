import store from "#/components/store";
import {setCookie} from '#/util/cookie';

const axiosHttp = axios.create ({
  baseURL: process.env.VUE_APP_ROOT_API,
  timeout: 60000,
  headers: {'Content-Type': 'application/json'},
});

export default {

  register(context, name, email, password, password_confirmation, lang) {
    return axiosHttp.post('/api/register', { name, email, password, password_confirmation, lang })
      .then(response => {
        console.log(response);
        if ('data' in response.data) {
          return { status: true };
        }
      })
      .catch(function (error) {
        console.log(error);
        return { status: false, errors: error.response.data.errors };
      });
  },

  login(email, password) {
    return axiosHttp.post('/api/login', { email, password })
      .then(response => {

        if ('data' in response.data) {
          store.commit('loginUser');

          // localStorage.setItem('token', response.data.data.api_token);

          let expiredays = 1;
          setCookie('token', response.data.data.api_token, expiredays);

          return true;
        }
      })
      .catch(function (error) {
        return false;
      });
  },

  forgot_pass(email) {
    return axiosHttp.post('/api/password/create', { email })
      .then(response => {
        return response.data;
      })
      .catch(error => {
        console.log(error);
      });
  }
}
