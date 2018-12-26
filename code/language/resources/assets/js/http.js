import axios from 'axios';

const http = axios.create ({
  baseURL: process.env.VUE_APP_ROOT_API,
  timeout: 60000,
  headers: {'Content-Type': 'application/json'},
});

http.interceptors.request.use (
  function (config) {
    const token = localStorage.getItem('token');
    if (token) config.headers.Authorization = `Bearer ${token}`;

    return config;
  },
  function (error) {
    return Promise.reject (error);
  }
);

export default http;
