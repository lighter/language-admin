<template>
    <div id="div-user-projects" class="div-table-list">
        <table id="table-user-projects" class="table is-striped is-fullwidth">
            <thead>
            <tr>
                <th>{{ $t('ProjectName') }}</th>
                <th>{{ $t('ProjectLanguage') }}</th>
                <th>{{ $t('Status') }}</th>
                <th>{{ $t('Created_at') }}</th>
                <th>{{ $t('Updated_at') }}</th>
                <th>{{ $t('Operator')}}</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="project in userProjects">
                <td>{{ project.name }}</td>
                <td class="lang-tag">
                    <span v-for="lang in JSON.parse(project.language)" class="tag is-primary">{{ lang }}</span>
                </td>
                <td>{{ project.public ? $t('Public') : $t('NonPublic') }}</td>
                <td>{{ project.created_at }}</td>
                <td>{{ project.updated_at }}</td>
                <td>
                    <router-link :to="{path: `/${$i18n.locale}/project/${project.id}/edit`}" class="button is-light"
                                 v-if="project.pivot.owner">{{ $t('Modify') }}
                    </router-link>
                    <router-link :to="{path: `/${$i18n.locale}/language/${project.id}`}" class="button is-light">{{
                        $t('Language') }}
                    </router-link>
                    <router-link :to="{path: `/${$i18n.locale}/project/${project.id}/owner`}" class="button is-light"
                                 v-if="project.pivot.owner && project.public">{{ $t('Owner') }}
                    </router-link>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
  import http from '#/http';

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
            this.userProjects = response.data.data;
          });
      }
    },
    beforeMount() {
      this.getUserProjects();
    },
  }
</script>

<style scoped>
    td.lang-tag > span {
        margin-right: 5px;
    }
</style>
