<template>
    <div class="select is-multiple">
        <select multiple @change="$emit('changeSelectedLanguage', sl)" v-model="sl">
            <option v-for="lang in languages" :value="lang.key">{{ lang.value }}</option>
        </select>
    </div>
</template>

<script>
  import languageList from '#/i18n/languageList';

  export default {
    name: "LanguageList",
    data: function() {
      return {
        languages: languageList.datas,
        sl: this.selectedLanguage
      }
    },
    props: {
      selectedLanguage: {
        default: [],
        type: Array,
      }
    },
    watch: {
      selectedLanguage: function (val) {
        this.sl = this.selectedLanguage = val;
      }
    }
  }
</script>

<style scoped>

</style>
