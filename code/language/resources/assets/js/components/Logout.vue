<template>

</template>

<script>
  import store from './store';

  export default {
    name: "Logout",
    mounted() {
        localStorage.removeItem('token');
        store.commit('logoutUser');
        this.$route.push({name: 'login', params: this.$language });
    }
  }
</script>

<style scoped>

</style>
