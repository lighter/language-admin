<template>
    <div class="lmask" v-show="isLoading"></div>
</template>

<script>

  import Loading from '#/loadingMask/plugin';

  export default {
    name: "LoadingMask",
    data() {
      return {
        isLoading: false,
      }
    },
    methods: {
      closeLoading() {
        this.isLoading = false;
      },
      showLoading() {
        this.isLoading = true;
      }
    },
    beforeMount() {
      Loading.EventBus.$on('closeLoading', () => {this.closeLoading();});
      Loading.EventBus.$on('showLoading', () => {this.showLoading();});
    }
  }
</script>

<style lang="scss" scoped>
    @import "~@/loading.scss";
</style>
