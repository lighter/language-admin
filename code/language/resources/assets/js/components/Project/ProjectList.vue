<template>
    <div id="div-user-projects">
        <table id="table-user-projects" class="table is-striped table is-fullwidth">
            <thead>
            <tr>
                <th>{{ $t('ProjectName') }}</th>
                <th>{{ $t('ProjectLanguage') }}</th>
                <th>{{ $t('Status') }}</th>
                <th>{{ $t('Created_at') }}</th>
                <th>{{ $t('Updated_at') }}</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="project in userProjects">
                <td>{{ project.name }}</td>
                <td>{{ project.language }}</td>
                <td>{{ project.public ? $t('Public') : $t('NonPublic') }}</td>
                <td>{{ project.created_at }}</td>
                <td>{{ project.updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
  import http from '../../http';

  export default {
    name: "ProjectList",
    data() {
      return {
        userProjects: []
      }
    },
    methods: {
      getUserProjects() {
        http.get('api/user_projects')
          .then((response) => {
            console.log(response.data.data);
            this.userProjects = response.data.data;
          });
      }
    },
    beforeMount() {
      this.getUserProjects()
    },
  }
</script>

<style scoped>

</style>
