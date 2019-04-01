<template>
    <div></div>
</template>

<script>
  import store from "#/components/store";
  import {setCookie} from '#/util/cookie';

  const headers = {
    headers: {
      'Content-Type': 'application/json',
    }
  };

  export default {
    name: "OAuthCallback",
    methods: {
      authGithubCallback() {
        axios.post(`/api/auth/callback/${this.$route.params.token}`, {}, headers)
          .then(response => {
            if ('data' in response.data) {
              store.commit('loginUser');

              let expiredays = 1;
              setCookie('token', response.data.data.api_token, expiredays);

              this.$router.push({ path: '/en/project' });
            }
            else {
              this.$router.push({ name: 'login' });
            }
          })
          .catch(function(error) {
            console.log(error);
          });
      }
    },
    mounted() {
      this.authGithubCallback();
    }
  }
</script>

<style scoped>

</style>
