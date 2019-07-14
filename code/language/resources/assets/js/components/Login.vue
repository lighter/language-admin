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
                        <h3 class="title has-text-grey">{{ $t('Sign_in') }}</h3>
                        <div class="box">
                            <form>
                                <div class="field">
                                    <div class="control">
                                        <input class="input is-large" type="email" :placeholder="$t('Email_address')"
                                               autofocus="" v-model="email">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <input class="input is-large" type="password" :placeholder="$t('Password')"
                                               v-model="password">
                                    </div>
                                </div>
                                <div class="field">
                                    <button class="button is-block is-light is-large is-fullwidth"
                                            @click.prevent="login">{{ $t('Sign_in') }}
                                    </button>
                                </div>
                                <div class="field">
                                    <button class="button is-block is-dark is-large is-fullwidth"
                                            @click.prevent="githubLogin">{{ $t('SignInWithGithub') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <p class="has-text-grey">
                            <router-link to="register">{{ $t('Sign_up') }}</router-link> &nbsp;·&nbsp;
                            <router-link to="forgot_pass">{{ $t('Forget_password') }}</router-link>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>

</template>

<script>
  import auth from '#/components/Auth/auth';
  import http from '#/http';
  import Navbar from '#/components/layout/Navbar';
  import LanguageSwitch from '#/components/layout/LanguageSwitch';

  export default {
    name: "login",
    components: {
      Navbar,
      LanguageSwitch
    },
    data() {
      return {
        email: 'test@test.com',
        password: '123456',
      };
    },
    methods: {
      login() {

        let params = {
          content: 'Login failed',
        };

        auth.login(this.email, this.password).then(status => {
          if (status) this.$router.push({ name: 'project_list', params: this.$i18n.locale })
          else this.$alertmodal.show(params)
        });
      },
      githubLogin() {
        http.post('/api/auth/github')
          .then(response => {
            console.log(response);
            window.location = response.data.url;
          })
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
