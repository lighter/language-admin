import {getCookie} from "#/util/cookie";
import {API_BASE_URL} from "#/config";

const http = axios.create ({
  baseURL: API_BASE_URL,
  timeout: 60000,
  headers: {'Content-Type': 'application/json'},
});

http.interceptors.request.use (
  function (config) {
    const token = getCookie('token');
    console.log(token);
    if (token) config.headers.Authorization = `Bearer ${token}`;

    window.Vue.prototype.$loading.show();

    return config;
  },
  function (error) {
    window.Vue.prototype.$loading.close();
    return Promise.reject (error);
  }
);

http.interceptors.response.use(function (response) {
  window.Vue.prototype.$loading.close();
  return response;
}, function (error) {
  window.Vue.prototype.$loading.close();
  return Promise.reject(error);
});


export default http;
