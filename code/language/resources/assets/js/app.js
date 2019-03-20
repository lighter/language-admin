import '#/bootstrap';
import router from '#/routes';
import App from '#/App.vue';
import {i18n} from "#/i18n";

new Vue({
  el: '#app',
  router,
  i18n,
  render: app => app(App)
});
