<template>
<transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
         <div class="modal-content col-sm-12 col-md-8 offset-md-2">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" @click="$emit('close')" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button class="btn btn-secondary" @click="$emit('close')">Close</button>
            </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        /*width: 300px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        font-family: Helvetica, Arial, sans-serif;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);*/
        transition: all .3s ease;
    }

    /* .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    } */

    /*
    * The following styles are auto-applied to elements with
    * transition="modal" when their visibility is toggled
    * by Vue.js.
    *
    * You can easily play with the modal transition by editing
    * these styles.
    */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>

<script>
    export default {
        mounted() {

        },
        data: function () {
            return {
                showModal: false
        }
}
    }
</script>
