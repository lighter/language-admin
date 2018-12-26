<template>
    <div>
        <Navbar>
            <LanguageSwitch></LanguageSwitch>

            <div class="navbar-item has-dropdown" v-bind:class="{ 'is-active': isActive }" @mouseover="showAccountDropDown" @mouseout="hiddenAccountDropDown">
                <a href="#" class="navbar-link">{{ $t('Account') }}</a>

                <div class="navbar-dropdown" v-if="!loginStatus">
                    <router-link to="/" class="navbar-item">Home</router-link>
                    <router-link :to="{path: '/' + $i18n.locale + '/login'}" class="navbar-item">Login</router-link>
                    <router-link :to="{path: '/' + $i18n.locale + '/register'}" class="navbar-item">Register</router-link>
                </div>

                <div class="navbar-dropdown" v-else>
                    <router-link :to="{path: '/' + $i18n.locale + '/logout'}" class="navbar-item">Logout</router-link>
                </div>

            </div>
        </Navbar>

        <div class="container">
            <div class="columns is-desktop is-gapless">
                <Menu></Menu>

                <div class="column is-9">
                    <router-view></router-view>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
  import Navbar from './Navbar';
  import Menu from './Menu';
  import LanguageSwitch from './LanguageSwitch';
  import store from '../store';

  export default {
    components: {
      Navbar,
      Menu,
      LanguageSwitch
    },
    data() {
      return {
        isActive: false,
        loginStatus: store.state.isLoggedIn
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

</style>
