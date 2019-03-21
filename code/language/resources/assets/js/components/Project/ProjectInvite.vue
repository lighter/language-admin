<template>

</template>

<script>
  import http from '#/http';
  import {i18n} from "#/i18n";

  export default {
    name: "ProjectInvite",
    data() {
      return {
        token: this.$route.params.id,
      }
    },
    methods: {
      joinProject() {
        http.get(`api/project/invite/${this.$route.params.token}`)
          .then(response => {
            let data = response.data;
            if (data.status) {
              this.$alertmodal.show({
                'content': i18n.t('join_project_successful'),
                'callback': function () {
                  this.$router.push({ name: 'project_list', params: this.$i18n.locale })
                }
              });

            } else {
              this.$alertmodal.show({
                'content': i18n.t('join_project_failed'),
                'callback': function () {
                  this.$router.push({ name: 'project_list', params: this.$i18n.locale });
                }
              });
            }
          });
      }
    },
    mounted() {
      this.joinProject();
    }
  }
</script>

<style scoped>

</style>
