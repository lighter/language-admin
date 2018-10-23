import './bootstrap';
import router from './routes';
import App from './App.vue';
import {i18n} from "./i18n";

router.beforeEach((to, from, next) => {
  const lang = to.params.lang;

  if (!['en', 'zh_tw'].includes(lang)) return next('en');
  else i18n.locale = lang;

  return next();
});


new Vue({
  el: '#app',
  router,
  i18n,
  render: app => app(App)
});
