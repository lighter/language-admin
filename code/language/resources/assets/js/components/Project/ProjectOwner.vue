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
                <tr v-for="(owner, index) in projectOwner">
                    <td>{{owner.name}}</td>
                    <td>{{owner.email}}</td>
                    <td>{{isOwner(owner.pivot.owner)}}</td>

                    <td v-if="owner.pivot.owner">{{ isRead(owner.pivot.read) }}</td>
                    <td v-else>
                        <input type="checkbox" v-model="owner.pivot.read" :key="index" :value="owner.pivot.read"
                               :checked="owner.pivot.read">{{ isRead(owner.pivot.read) }}
                    </td>

                    <td v-if="owner.pivot.owner">{{ isWrite(owner.pivot.write) }}</td>
                    <td v-else>
                        <input type="checkbox" v-model="owner.pivot.write" :key="index" :value="owner.pivot.write"
                               :checked="owner.pivot.write">{{ isRead(owner.pivot.write) }}
                    </td>

                    <td>{{owner.pivot.created_at}}</td>
                    <td>{{owner.pivot.updated_at}}</td>
                    <td>
                        <button type="button" class="button is-light" v-if="!owner.pivot.owner" @click.prevent="saveSetting(index)">{{ $t('Save')
                            }}
                        </button>
                    </td>
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
  import {i18n} from "#/i18n";

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
        http.post('/api/project/owner', {
          'projectId': this.$route.params.id,
          'page': page,
          'pageSize': pageSize,
        })
          .then(response => {
            let data = response.data.data;
            this.projectOwner = data;
            this.pagination = response.data.pagination
          });
      },
      inviteUser() {
        http.post('/api/project/invite_user', {
          lang: this.$route.params.lang,
          email: this.inviteEmail,
          id: this.$route.params.id,
        })
          .then(response => {
            let data = response.data;

            if (data.status) {
              this.$alertmodal.show({
                'content': 'Invite Success'
              });

              this.inviteEmail = '';
            } else {
              this.$alertmodal.show({
                'content': 'Invite Failed'
              });
            }
          });
      },
      isOwner(owner) {
        return (owner) ? i18n.t('Yes') : i18n.t('No')
      },
      isRead(read) {
        return (read) ? i18n.t('Yes') : i18n.t('No')
      },
      isWrite(write) {
        return (write) ? i18n.t('Yes') : i18n.t('No')
      },
      saveSetting(index) {
        let owner = this.projectOwner[index];
        let ownerData = {
          id: owner.id,
          project_id: owner.pivot.project_id,
          read: owner.pivot.read,
          write: owner.pivot.write,
        };

        http.post('/api/project/owner_setting', ownerData)
          .then(response => {

            if (response.data.status) {
              this.projectOwner[index].pivot.updated_at = response.data.data.pivot.updated_at;
            }
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
