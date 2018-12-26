import LoadingMask from './LoadingMask';

const Loading = {
  install (Vue, options) {
    this.EventBus = new Vue();

    Vue.component('app-loading', LoadingMask);

    Vue.prototype.$loading = {
      show() {
        Loading.EventBus.$emit('showLoading');
      },

      close() {
        Loading.EventBus.$emit('closeLoading');
      }
    }
  }
};


export default Loading;
