<template>
    <div>
        <div class="column is-7">
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">{{ $t('Invite_email') }}</label>
                </div>
                <div class="field-body">
                    <div class="field is-narrow">
                        <div class="control">
                            <input class="input" type="text" v-model="inviteEmail">
                        </div>
                    </div>
                    <div class="field is-narrow">
                        <div class="control">
                            <button type="button" class="button is-primary" @click.prevent="inviteUser">{{ $t('Send')
                                }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="div-user-projects-owner" class="div-table-list">
            <table id="table-user-projects-owner" class="table is-striped is-fullwidth">
                <thead>
                <tr>
                    <td>{{ $t('Name') }}</td>
                    <td>{{ $t('Email') }}</td>
                    <td>{{ $t('Owner') }}</td>
                    <td>{{ $t('Read') }}</td>
                    <td>{{ $t('Write') }}</td>
                    <td>{{ $t('Created_at') }}</td>
                    <td>{{ $t('Updated_at') }}</td>
                    <td>{{ $t('Operator') }}</td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="owner in projectOwner">
                    <td>{{owner.name}}</td>
                    <td>{{owner.email}}</td>
                    <td>{{owner.pivot.owner}}</td>
                    <td>{{owner.pivot.read}}</td>
                    <td>{{owner.pivot.write}}</td>
                    <td>{{owner.pivot.created_at}}</td>
                    <td>{{owner.pivot.updated_at}}</td>
                    <td></td>
                </tr>
                </tbody>
            </table>

            <Pagination :pagination-data="pagination"
                        :last-page-str="$t('LastPage')"
                        :first-page-str="$t('FirstPage')"></Pagination>
        </div>
    </div>
</template>

<script>
  import http from '#/http';
  import Pagination from '#/Pagination/Pagination';

  export default {
    name: "ProjectOwner",
    components: {
      Pagination,
    },
    data() {
      return {
        inviteEmail: '',
        projectOwner: [],
        pagination: {},
      }
    },
    methods: {
      getUserProjectOwner(page = 1, pageSize = 10) {
        http.post('api/project/owner', {
          'projectId': this.$route.params.id,
          'page': page,
          'pageSize': pageSize,
        })
          .then(response => {
            console.log(response.data);
            let data = response.data.data;
            this.projectOwner = data;
            this.pagination = response.data.pagination
          });
      },
      inviteUser() {
        http.post('api/project/invite_user', {
          lang: this.$route.params.lang,
          email: this.inviteEmail,
          id: this.$route.params.id,
        })
          .then(response => {
            console.log(response);
          });
      }
    },
    created() {
      this.$on('goToPage', (page, pageSize) => {
        this.getUserProjectOwner(page, pageSize);
      });
    },
    mounted() {
      this.getUserProjectOwner();
    }
  }
</script>

<style scoped>

</style>
