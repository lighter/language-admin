<template>
    <div>
        <app-loading></app-loading>
        <Navbar>
            <LanguageSwitch></LanguageSwitch>
        </Navbar>

        <section class="hero is-success is-fullheight">
            <div class="hero-body">
                <div class="container has-text-centered">
                    <div class="column is-4 is-offset-4">
                        <h3 class="title has-text-grey">{{ $t('Sign_up') }}</h3>
                        <div class="box">
                            <figure class="avatar">
                                <img src="https://placehold.it/128x128">
                            </figure>
                            <form>
                                <div class="field">
                                    <div class="control">
                                        <input class="input is-large" type="text" :placeholder="$t('Name')" autofocus=""
                                               v-model="name">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <input class="input is-large" type="email" :placeholder="$t('Email_address')"
                                               v-model="email">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <input class="input is-large" type="password" :placeholder="$t('Password')"
                                               v-model="password">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <input class="input is-large" type="password"
                                               :placeholder="$t('Confirm_password')"
                                               v-model="password_confirmation">
                                    </div>
                                </div>

                                <button class="button is-block is-info is-large is-fullwidth" @click.prevent="register">
                                    {{ $t('Sign_up') }}
                                </button>
                            </form>
                        </div>
                        <p class="has-text-grey">
                            <router-link to="login">{{ $t('Sign_in') }}</router-link> &nbsp;·&nbsp;
                            <router-link to="forgot_pass">{{ $t('Forget_password') }}</router-link>
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
  import auth from './Auth/auth';
  import Navbar from './layout/Navbar';
  import LanguageSwitch from './layout/LanguageSwitch';

  export default {
    name: "register",
    components: {
      Navbar,
      LanguageSwitch,
    },
    data() {
      return {
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
        success: false,
        error: false,
        response: null,
      };
    },
    methods: {
      register() {
        auth.register(this, this.name, this.email, this.password, this.password_confirmation, this.$route.params.lang)
          .then(data => {

            let registerSuccessParams = {
              content: 'Register Success',
            };

            if (data.status) this.$alertmodal.show(registerSuccessParams);
            else this.$alertmodal.showErrorMessage(data.errors);
          });
      }
    }
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
