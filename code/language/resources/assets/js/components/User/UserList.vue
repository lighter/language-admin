<template>
    <div id="div-users" class="div-table-list">
        <table id="table-user" class="table is-striped table is-fullwidth">
            <thead>
            <tr>
                <th>{{ $t('Name') }}</th>
                <th>{{ $t('Email') }}</th>
                <th>{{ $t('Created_at') }}</th>
                <th>{{ $t('Updated_at') }}</th>
                <th>{{ $t('Operator')}}</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="user in users">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.created_at}}</td>
                <td>{{ user.updated_at}}</td>
                <td>
                    <router-link :to="{path: `/${$i18n.locale}/user/${user.id}/edit`}" class="button is-light">{{
                        $t('Modify') }}
                    </router-link>
                </td>
            </tr>
            </tbody>
        </table>

        <Pagination :pagination-data="pagination" :last-page-str="$t('LastPage')" :first-page-str="$t('FirstPage')" ></Pagination>

    </div>
</template>

<script>
  import http from '../../http';
  import Pagination from '../../Pagination/Pagination';

  export default {
    name: "UserList",
    components: {
      Pagination,
    },
    data() {
      return {
        users: [],
        pagination: {},
      }
    },
    methods: {
      getUsers() {
        http.get('api/users_page')
          .then((response) => {
            this.users = response.data.data;
            this.pagination = response.data.pagination;
          });
      }
    },
    mounted() {
      this.getUsers();
    },
  }
</script>

<style scoped>

</style>
