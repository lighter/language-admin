<template>

    <div id="div-user-project-languages" class="div-table-list">

        <table id="table-user-project-languages" class="table is-striped is-fullwidth">
            <thead>
            <tr>
                <th>{{ $t('Language') }}</th>
                <th v-for="language in projectLanguages">
                    {{ language }}
                </th>
                <th>{{ $t('Updated_at') }}</th>
                <th>{{ $t('Operator') }}</th>
            </tr>
            </thead>

            <tbody v-for="(language, index) in userProjectLanguages">

            <LanguageListTableRow :index="index"
                                  :user-project-languages="language"
                                  :project-languages="projectLanguages"
                                  :input-lang="language.lang"
                                  :project-id="parseInt($route.params.id, 10)"
                                  :lang-id="parseInt(language.id, 10)"
                                  @deleteProjectLanguage="deleteProjectLanguage"></LanguageListTableRow>
            </tbody>
        </table>

        <button type="button" class="button is-light" @click.prevent="createLang">{{ $t('New') }}</button>

    </div>

</template>

<script>
  import http from '../../http';
  import LanguageListTableRow from './LanguageListTableRow';

  export default {
    name: "LanguageList",
    components: {
      LanguageListTableRow,
    },
    data() {
      return {
        userProjectLanguages: [],
        projectLanguages: [],
      }
    },
    methods: {
      getUserProjectLanguages() {
        http.get(`api/user_project_languages/${this.$route.params.id}`)
          .then((response) => {
            let responseData = response.data;
            this.projectLanguages = JSON.parse(responseData.project.language);
            this.userProjectLanguages = responseData.data;
          });
      },
      createLang() {
        let lKey = {};

        this.projectLanguages.forEach(function (item) {
          lKey[item] = '';
        });

        this.userProjectLanguages.push({
          id: 0,
          lang: '',
          lang_key: JSON.stringify(lKey),
          project_id: this.$route.params.id,
          user_id: 0
        });
      },
      deleteProjectLanguage(index, lang_id) {
        http.delete(`api/language/${lang_id}`)
          .then((response) => {
            console.log(response);

            let deleteSuccessParams = {
              content: 'Delete Success',
            };

            let deleteFailParams = {
              content: 'Delete Fail',
            };

            if (response.data.data != 0) {
              this.userProjectLanguages.splice(index, 1);
              this.$alertmodal.show(deleteSuccessParams);
            } else {
              this.$alertmodal.show(deleteFailParams);
            }
          });
      }
    },
    beforeMount() {
      this.getUserProjectLanguages()
    }
  }
</script>

<style scoped>

</style>
