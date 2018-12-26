<template>
    <div class="select is-large">
        <select @change="onChange" v-model="$i18n.locale">
            <option v-for="lang in languages" :value="lang.code" :selected="lang.code == lang">{{ lang.name }}</option>
        </select>
    </div>
</template>

<script>
  export default {
    name: "LanguageSwitch",
    data() {
      return {
        languages: [
          {
            code: 'en',
            name: 'English',
          },
          {
            code: 'zh_tw',
            name: '繁體中文',
          }
        ],
        lang: this.$route.params.lang
      }
    },
    methods: {
      onChange() {
        this.$router.push({
          params: { lang: this.$i18n.locale }
        });
      }
    }
  }
</script>

<style scoped>

</style>
