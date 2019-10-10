<template>

</template>

<script>
  import store from '#/components/store';
  import {delCookie} from '#/util/cookie';

  export default {
    name: "Logout",
    mounted() {
      delCookie('token');
      delCookie('userName');
      delCookie('uid');
      store.commit('logoutUser');
      this.$router.push({name: 'login', params: this.$i18n.locale });
    }
  }
</script>

<style scoped>

</style>
