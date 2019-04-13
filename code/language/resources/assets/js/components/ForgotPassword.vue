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
                        <h3 class="title has-text-grey">{{ $t('Forget_password') }}</h3>
                        <div class="box">
                            <figure class="avatar">
                                <img src="https://placehold.it/128x128">
                            </figure>
                            <form>

                                <div class="field">
                                    <div class="control">
                                        <input class="input is-large" type="email" :placeholder="$t('Email_address')"
                                               v-model="email">
                                    </div>
                                </div>

                                <button class="button is-block is-light is-large is-fullwidth"
                                        @click.prevent="forgot_pass">
                                    {{ $t('Send') }}
                                </button>
                            </form>
                        </div>
                        <p class="has-text-grey">
                            <router-link to="login">{{ $t('Sign_in') }}</router-link> &nbsp;·&nbsp;
                            <router-link to="register">{{ $t('Sign_up') }}</router-link>
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
  import auth from '#/components/Auth/auth';
  import Navbar from '#/components/layout/Navbar';
  import LanguageSwitch from '#/components/layout/LanguageSwitch';

  export default {
    name: "ForgotPassword",
    components: {
      Navbar,
      LanguageSwitch,
    },
    data() {
      return {
        email: null,
      };
    },
    methods: {
      forgot_pass() {
        let forgotPasswordSuccessParams = {
          content: 'Send reset password Success',
        };

        let forgotPasswordFailParams = {
          content: 'Somthing is wrong',
        };

        auth.forgot_pass(this.email)
          .then(data => {
            if (data.status === true) {
              this.$alertmodal.show(forgotPasswordSuccessParams);
              this.email = '';
            } else {
              this.$alertmodal.show(forgotPasswordFailParams);
            }
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
