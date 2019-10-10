<template>
    <div>
        <app-loading></app-loading>

        <Navbar>
            <LanguageSwitch></LanguageSwitch>

            <div class="navbar-item has-dropdown" v-bind:class="{ 'is-active': isActive }" @mouseover="showAccountDropDown" @mouseout="hiddenAccountDropDown">
                <a href="#" class="navbar-link">{{ userName }}</a>

                <div class="navbar-dropdown" v-if="!loginStatus">
                    <router-link to="/" class="navbar-item">Home</router-link>
                    <router-link :to="{path: '/' + $i18n.locale + '/login'}" class="navbar-item">{{ $t('Sign_in') }}</router-link>
                    <router-link :to="{path: '/' + $i18n.locale + '/register'}" class="navbar-item">{{ $t('Sign_up') }}</router-link>
                </div>

                <div class="navbar-dropdown" v-else>
                    <router-link :to="{path: '/' + $i18n.locale + '/user/' + uid + '/edit' }" class="navbar-item">{{ $t('Setting') }}</router-link>
                    <router-link :to="{path: '/' + $i18n.locale + '/logout'}" class="navbar-item">{{ $t('Logout') }}</router-link>
                </div>

            </div>
        </Navbar>

        <div class="container is-fluid">
            <div class="columns is-desktop is-gapless">
                <Menu></Menu>

                <div class="column is-11" id="div-container">
                    <router-view></router-view>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
  import Navbar from '#/components/layout/Navbar';
  import Menu from '#/components/layout/Menu';
  import LanguageSwitch from '#/components/layout/LanguageSwitch';
  import store from '#/components/store';
  import {getCookie} from '#/util/cookie';

  export default {
    components: {
      Navbar,
      Menu,
      LanguageSwitch
    },
    data() {
      return {
        isActive: false,
        loginStatus: store.state.isLoggedIn,
        userName: store.state.userName,
        uid: getCookie('uid'),
      };
    },
    methods: {
      showAccountDropDown: function () {
        this.isActive = true;
      },
      hiddenAccountDropDown: function () {
        this.isActive = false;
      }
    }
  }
</script>

<style scoped>
    div#div-container {
        margin-left: 9.5%;
    }
</style>
