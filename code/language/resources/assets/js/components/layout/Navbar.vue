<template>
    <nav class="navbar has-shadow">
        <app-modal></app-modal>
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="#">
                    <img src="http://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox">
                </a>
            </div>
            <div class="navbar-menu" id="navMenu">
                <div class="navbar-end">
                    <slot></slot>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
  export default {
    name: "Navbar"
  }
</script>

<style scoped>

</style>
