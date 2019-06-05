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
                        <h3 class="title has-text-grey">{{ $t('Reset_password') }}</h3>
                        <div class="box">
                            <form>
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

                                <button class="button is-block is-light is-large is-fullwidth"
                                        @click.prevent="reset_pass">
                                    {{ $t('Send') }}
                                </button>
                            </form>
                        </div>
                        <p class="has-text-grey">
                            <router-link :to="{name:'login'}">{{ $t('Sign_in') }}</router-link> &nbsp;·&nbsp;
                            <router-link :to="{name:'register'}">{{ $t('Sign_up') }}</router-link>
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
  import http from '#/http';

  import Navbar from '#//components/layout/Navbar';
  import LanguageSwitch from '#/components/layout/LanguageSwitch';

  export default {
    name: "ResetPassword",
    components: {
      Navbar,
      LanguageSwitch,
    },
    data() {
      return {
        password: null,
        password_confirmation: null,
        code: this.$route.params.code,
        email: null,
      };
    },
    methods: {
      reset_pass() {
        let resetPasswordSuccessParams = {
          content: 'Reset password Success',
        };

        let resetPasswordFailParams = {
          content: 'Somthing is wrong',
        };

        http.post('/api/password/reset', {
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
          token: this.code,
        })
          .then((response) => {
            if (response.status === true) {
              this.$alertmodal.show(resetPasswordSuccessParams);
            } else {
              this.$alertmodal.show(resetPasswordFailParams);
            }
          });
      },
      get_access_token_info() {

        let errors = {
          content: 'Somthing is wrong',
        };

        http.get('/api/password/find/' + this.code)
          .then((response) => {
            if (response.data.status === true) {
              let data = response.data.data;
              this.email = data.email;
            }
            else {
              this.$alertmodal.show(errors);
            }
          });
      },
    },
    mounted() {
      this.get_access_token_info();
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
