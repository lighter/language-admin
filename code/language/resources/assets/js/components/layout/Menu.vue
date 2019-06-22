<template>
    <div class="column is-1" id="div-menu">
        <aside class="menu">
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
    #div-menu {
        position: fixed;
        border-right: 3px solid  rgba(10, 10, 10, 0.1);
        margin-right: 11px;
        top: 3.5em;
        bottom: 0;
    }
</style>
