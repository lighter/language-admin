import VueI18n from 'vue-i18n';
import en from './i18n/en';
import zh_tw from './i18n/zh-tw';

Vue.use(VueI18n);

export const i18n = new VueI18n({
  locale: 'en',
  fallbackLocale: 'en',
  messages: {
    en, zh_tw
  }
});
