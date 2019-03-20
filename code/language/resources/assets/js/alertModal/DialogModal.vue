<template>

    <div class="modal" v-bind:class="{ 'is-active': showModal }">
        <div class="modal-background" @click="close"></div>
        <div class="modal-content">
            <div class="box" v-if="showText">
                {{ content }}
            </div>

            <div class="box" v-if="!showText">
                <ul>
                    <li v-for="(errorMessages, column) in errors">
                        {{ column }} : {{ errorMessages.toString() }}
                    </li>
                </ul>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close" @click="close"></button>
    </div>

</template>

<script>
  import AlertModal from '#/alertModal/plugin';

  export default {
    name: "DialogModal",
    data() {
      return {
        content: '',
        showModal: false,
        showText: true,
        errors: null,
      }
    },
    methods: {
      close() {
        this.showModal = false;
      },
      show(params) {
        this.content = params.content
        this.showModal = true;
      },
      showErrorMessage(errors) {
        this.showModal = true;
        this.errors = errors;
        this.showText = false;
      }
    },
    mounted: function () {
      document.addEventListener("keydown", (e) => {
        if (this.showModal && e.keyCode == 27) {
          this.close();
        }
      });
    },
    beforeMount() {
      // here we need to listen for emited events
      // we declared those events inside our plugin
      AlertModal.EventBus.$on('show', (params) => {
        this.show(params);
      });

      AlertModal.EventBus.$on('showErrorMessage', (errors) => {
        this.showErrorMessage(errors);
      });
    }
  }
</script>

<style scoped>

</style>
