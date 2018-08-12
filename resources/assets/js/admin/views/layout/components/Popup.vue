<template>
    <div class="popup-middle" v-if="showLoading">
        <mt-spinner type="fading-circle" :size="100"
                    color="rgb(100, 100, 100)"></mt-spinner>
    </div>
</template>

<script>
    import {Spinner} from 'mint-ui';

    export default {
        name: "Popup",
        comments: [Spinner],
        computed: {
            showLoading() {
                return this.$store.state.popup.showLoading
            }
        }
    }
</script>

<style scoped>
    .popup-middle {
        position: fixed;
        top: 35%;
        left: 50%;
        transform: translateX(-50%);
    }
</style>