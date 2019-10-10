import store from "#/components/store";
import {setCookie} from '#/util/cookie';
import {API_BASE_URL} from "#/config";

const axiosHttp = axios.create({
  baseURL: API_BASE_URL,
  timeout: 60000,
  headers: { 'Content-Type': 'application/json' },
});

axiosHttp.interceptors.request.use(
  function (config) {
    window.Vue.prototype.$loading.show();

    return config;
  },
  function (error) {
    window.Vue.prototype.$loading.close();
    return Promise.reject(error);
  }
);

axiosHttp.interceptors.response.use(function (response) {
  window.Vue.prototype.$loading.close();
  return response;
}, function (error) {
  window.Vue.prototype.$loading.close();
  return Promise.reject(error);
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
          store.commit('loginUser', response.data.data);

          let expiredays = 1;
          setCookie('token', response.data.data.api_token, expiredays);
          setCookie('userName', response.data.data.name, expiredays);
          setCookie('uid', response.data.data.id, expiredays);

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
