<template>
    <div class="column is-7">
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">{{ $t('ProjectName') }}</label>
            </div>
            <div class="field-body">
                <div class="field is-narrow">
                    <div class="control">
                        <input class="input" type="text" v-model="name">
                    </div>
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">{{ $t('Public') }}</label>
            </div>
            <div class="field-body">
                <div class="field is-narrow">
                    <div class="control">
                        <label class="radio">
                            <input type="radio" name="public" value="true" v-model="public">
                            {{ $t('Public')}}
                        </label>

                        <label class="radio">
                            <input type="radio" name="public" value="false" v-model="public">
                            {{ $t('NonPublic')}}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">{{ $t('ProjectLanguage') }}</label>
            </div>
            <div class="field-body">
                <div class="field is-narrow">
                    <LanguageList :selected-language="selectedLanguage" @changeSelectedLanguage="changeSelectedLanguage"></LanguageList>
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal"></div>
            <div class="field-body">
                <div class="field is-narrow">
                    <div class="control">
                        <div class="field is-grouped">
                            <p class="control" @click.prevent="createProject">
                                <a class="button is-primary">
                                    {{ $t('Save') }}
                                </a>
                            </p>
                            <p class="control">
                                <a class="button is-light">
                                    {{ $t('Cancel') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

  import LanguageList from '#/components/layout/LanguageList';
  import http from '#/http';

  export default {
    name: "ProjectCreate",
    components: {
      LanguageList
    },
    data() {
      return {
        name: null,
        public: null,
        language: null,
        selectedLanguage: ['zh_tw']
      }
    },
    methods: {
      createProject() {

        let createSuccessParams = {
          content: 'Create Success',
        };

        let createFailParams = {
          content: 'Create Fail',
        };

        http.post('api/project', {
          name: this.name,
          public: this.public,
          language: this.selectedLanguage
        }).then((response) => {
          console.log('create porject', response.data);
          if (response.data.data.status) this.$alertmodal.show(createSuccessParams);
          else this.$alertmodal.show(createFailParams);
        });
      },
      changeSelectedLanguage(value) {
        this.selectedLanguage = value;
      }
    }
  }
</script>

<style scoped>

</style>
