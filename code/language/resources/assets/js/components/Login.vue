<template>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Login</h3>
                    <div class="box">
                        <figure class="avatar">
                            <img src="https://placehold.it/128x128">
                        </figure>
                        <form>
                            <div class="field">
                                <div class="control">
                                    <input class="input is-large" type="email" placeholder="Your Email" autofocus="">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input class="input is-large" type="password" placeholder="Your Password">
                                </div>
                            </div>
                            <button class="button is-block is-info is-large is-fullwidth">Login</button>
                        </form>
                    </div>
                    <p class="has-text-grey">
                        <a href="../">Sign Up</a> &nbsp;·&nbsp;
                        <a href="../">Forgot Password</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

</template>

<script>
  export default {
    name: "login"
  }
</script>

<style scoped>
    html,
    body {
        font-family: 'Open Sans', serif;
        font-size: 14px;
        font-weight: 300;
    }

    .hero.is-success {
        background: #F2F6FA;
    }

    .hero .nav,
    .hero.is-success .nav {
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .box {
        margin-top: 5rem;
    }

    .avatar {
        margin-top: -70px;
        padding-bottom: 20px;
    }

    .avatar img {
        padding: 5px;
        background: #fff;
        border-radius: 50%;
        -webkit-box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1);
        box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1);
    }

    input {
        font-weight: 300;
    }

    p {
        font-weight: 700;
    }

    p.subtitle {
        padding-top: 1rem;
    }
</style>