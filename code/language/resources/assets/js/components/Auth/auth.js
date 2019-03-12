import store from "../store";
import {setCookie} from '../../util/cookie';

export default {

  register(context, name, email, password, password_confirmation, lang) {
    return axios.post('api/register', { name, email, password, password_confirmation, lang })
      .then(response => {
        if ('data' in response.data) {
          return {status: true};
        }
      })
      .catch(function (error) {
        console.log(error.response);
        return {status: false, errors: error.response.data.errors};
      });
  },

  login(email, password) {
    return axios.post('api/login', { email, password })
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
    return axios.post('api/password/create', {email})
      .then(response => {
        return response.data;
      })
      .catch(error => {
        console.log(error);
      });
  }
}
