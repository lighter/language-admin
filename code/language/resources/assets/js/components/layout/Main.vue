<template>
    <div>
        <nav class="navbar has-shadow">
            <div class="container">
                <div class="navbar-brand">
                    <a class="navbar-item" href="#">
                        <img src="http://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox">
                    </a>
                </div>
                <div class="navbar-menu" id="navMenu">
                    <div class="navbar-end">
                        <div class="navbar-item has-dropdown" v-bind:class="{ 'is-active': isActive }">
                            <a href="#" class="navbar-link" @click="showAccountDropDown">Account</a>

                            <div class="navbar-dropdown">
                                <router-link to="/" class="navbar-item">Home</router-link>
                                <router-link to="/login" class="navbar-item">Login</router-link>
                                <router-link to="/register" class="navbar-item">Register</router-link>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </nav>

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
  export default {
    data() {
      return {
        isActive: false
      };
    },
    methods: {
      showAccountDropDown: function() {
        this.isActive = !this.isActive;
      }
    }
  }
</script>

<style scoped>

</style>