<template>
    <div class="column is-7">
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">{{ $t('Name') }}</label>
            </div>
            <div class="field-body">
                <div class="field is-narrow">
                    <div class="control">
                        <input class="input" type="text" v-model="name">
                    </div>
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">{{ $t('Email') }}</label>
            </div>
            <div class="field-body">
                <div class="field is-narrow">
                    <div class="control">
                        <input class="input" type="text" v-model="email">
                    </div>
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">{{ $t('Created_at') }}</label>
            </div>
            <div class="field-body">
                <div class="field is-narrow">
                    <div class="control">
                        {{ created_at }}
                    </div>
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">{{ $t('Updated_at') }}</label>
            </div>
            <div class="field-body">
                <div class="field is-narrow">
                    <div class="control">
                        {{ updated_at }}
                    </div>
                </div>
            </div>
        </div>


        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">{{ $t('Password') }}</label>
            </div>
            <div class="field-body">
                <div class="field is-narrow">
                    <div class="control">
                        <input class="input" type="password" v-model="password">
                    </div>
                </div>
            </div>
        </div>


        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">{{ $t('Confirm_password') }}</label>
            </div>
            <div class="field-body">
                <div class="field is-narrow">
                    <div class="control">
                        <input class="input" type="password" v-model="password_confirmation">
                    </div>
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal"></div>
            <div class="field-body">
                <div class="field is-narrow">
                    <div class="control">
                        <div class="field is-grouped">
                            <p class="control" @click.prevent="updateUser">
                                <a class="button is-primary">
                                    {{ $t('Save') }}
                                </a>
                            </p>
                            <p class="control">
                                <a class="button is-light">
                                    {{ $t('Cancel') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
  import http from '../../http';

  export default {
    name: "UserEdit",
    data() {
      return {
        id: '',
        name: '',
        email: '',
        created_at: '',
        updated_at: '',
        password: '',
        password_confirmation: '',
      }
    },
    methods: {
      getUser() {
        console.log(this.$route.params.id);

        http.get(`api/users/${this.$route.params.id}`)
          .then((response) => {

            console.log(response);

            let userData = response.data.data;
            this.id = userData.id;
            this.name = userData.name;
            this.email = userData.email;
            this.created_at = userData.created_at;
            this.updated_at = userData.updated_at;
          });
      },
      updateUser() {
        let userData = {
          id: this.id,
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        }

        let updateSuccessParams = {
          content: 'Update Success',
        };

        let updateFailParams = {
          content: 'Update Fail',
        };

        http.put(`api/users/${(this.$route.params.id)}`, userData)
          .then((response) => {
            if (response.data.data.status) this.$alertmodal.show(updateSuccessParams);
            else this.$alertmodal.show(updateFailParams);
          })
          .catch((error) => {
            let errorMessage = error.response.data.errors;
            this.$alertmodal.showErrorMessage(errorMessage);
          });
      }
    },
    beforeMount() {
      this.getUser();
    }
  }
</script>

<style scoped>

</style>
