<template>
    <div>
        <navbar>
            <div class="navbar-item has-dropdown" v-bind:class="{ 'is-active': isActive }">
                <a href="#" class="navbar-link" @click="showAccountDropDown">{{ $t('Account') }}</a>

                <div class="navbar-dropdown">
                    <router-link to="/" class="navbar-item">Home</router-link>
                    <router-link to="$language/login" class="navbar-item">Login</router-link>
                    <router-link to="$language/register" class="navbar-item">Register</router-link>
                </div>
            </div>
        </navbar>

        <div class="container">
            <div class="columns is-desktop is-gapless">
                <div class="column is-3">
                    <aside class="menu">
                        <p class="menu-label">
                            General
                        </p>
                        <ul class="menu-list">
                            <li><a>Dashboard</a></li>
                            <li><a>Customers</a></li>
                        </ul>
                    </aside>
                </div>
                <div class="column is-9">
                    <router-view></router-view>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
  import navbar from './Navbar';

  export default {
    components: {
      navbar
    },
    data() {
      return {
        isActive: false
      };
    },
    methods: {
      showAccountDropDown: function () {
        this.isActive = !this.isActive;
      }
    }
  }
</script>

<style scoped>

</style>
