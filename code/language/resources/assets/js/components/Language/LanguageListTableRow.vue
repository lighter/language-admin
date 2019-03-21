<template>
    <tr>
        <td>
            <input type="text" class="input" v-model="lang">
        </td>
        <td v-for="p_lang in projectLanguages">
            <input type="text" class="input input-lang"
                   :data-input-lang="p_lang"
                   v-model="lang_key[p_lang]"/>
        </td>
        <td>{{ user_project_language.updated_at }}</td>
        <td>
            <button class="button is-light" @click.prevent="saveProjectLanguage">{{ $t('Save') }}</button>
            <button class="button is-danger" @click="$emit('deleteProjectLanguage', index, lang_id)">{{ $t('Delete') }}</button>
        </td>
    </tr>
</template>

<script>

  import http from '#/http';

  export default {
    name: "LanguageListTableRow",
    data() {
      return {
        pid: this.projectId,
        lang: this.inputLang,
        lang_id: this.langId,
        lang_key: JSON.parse(this.userProjectLanguages.lang_key),
        user_project_language: this.userProjectLanguages,
      }
    },
    props: {
      index: Number,
      projectId: Number,
      langId: Number,
      inputLang: String,
      userProjectLanguages: Object,
      projectLanguages: Array,
    },
    watch: {
      userProjectLanguages: function (val) {
        this.userProjectLanguages = this.user_project_language = val;
      },
      inputLang: function (val) {
        this.lang = val;
      },
      projectId: function (val) {
        this.pid = val;
      },
      langId: function (val) {
        this.langId = val;
      }
    },
    methods: {
      saveProjectLanguage() {
        let langData = {
          pid: this.pid,
          lang_id: parseInt(this.lang_id, 10),
          lang_key: this.lang_key,
          lang: this.lang,
        }

        // create new language
        if (langData.lang_id == 0) {
          let createSuccessParams = {
            content: 'Create Success',
          };

          let createFailParams = {
            content: 'Create Fail',
          };

          http.post('api/language', langData)
            .then((response) => {

              if (response.data.data != null) {
                this.$alertmodal.show(createSuccessParams);
                this.user_project_language = response.data.data;
                this.lang_id = response.data.data.id;
              } else {
                this.$alertmodal.show(createFailParams);
              }
            });
        }
        // update language
        else {
          let updateSuccessParams = {
            content: 'Update Success',
          };

          let updateFailParams = {
            content: 'Update Fail',
          };

          http.put(`api/language/${langData.lang_id}`, langData)
            .then((response) => {

              if (response.data.data.status) {
                this.$alertmodal.show(updateSuccessParams);
                this.user_project_language = response.data.data.data;
              }
              else {
                this.$alertmodal.show(updateFailParams);
              }
            });
        }

      },
    }
  }
</script>

<style scoped>

</style>
