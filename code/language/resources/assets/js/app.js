import './bootstrap';
import router from './routes';
import App from './App.vue';


new Vue({
  el: '#app',
  router,
  render: app => app(App)
});
