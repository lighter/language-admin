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
                        <h3 class="title has-text-grey">{{ $t('Verify_email') }}</h3>
                        <div class="box">
                            <figure class="avatar">
                                <img src="https://placehold.it/128x128">
                            </figure>
                            <form>

                                <div class="field">
                                    <div class="control">
                                        <p>{{ verify_message }}</p>
                                    </div>
                                </div>

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
  import http from '../http';


  import Navbar from './layout/Navbar';
  import LanguageSwitch from './layout/LanguageSwitch';

  export default {
    name: "VerifyUser",
    components: {
      Navbar,
      LanguageSwitch,
    },
    data() {
      return {
        code: this.$route.params.code,
        verify_message: '',
      }
    },
    methods: {
      verify_user() {
        http.post('api/user/verify', {token: this.code})
          .then((response) => {
            let data = response.data;
            this.verify_message = data.message;
          });
      }
    },
    mounted() {
      this.verify_user();
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
