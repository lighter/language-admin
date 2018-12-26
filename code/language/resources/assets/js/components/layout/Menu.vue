<template>
    <div class="column is-3">
        <aside class="menu">
            <p class="menu-label">General</p>
            <ul class="menu-list">
                <li><router-link :to="{path: '/' + $i18n.locale + '/project/create'}">{{ $t('ProjectCreate') }}</router-link></li>
                <li><router-link :to="{path: '/' + $i18n.locale + '/project'}">{{ $t('ProjectList') }}</router-link></li>
            </ul>
        </aside>
    </div>
</template>

<script>
  export default {
    name: "Menu"
  }
</script>

<style scoped>

</style>
