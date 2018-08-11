<template>
    <div>
        <mt-header fixed :title="getTitle()">
            <router-link :to="back()" slot="left">
                <mt-button icon="back">返回</mt-button>
            </router-link>
            <mt-button icon="more" slot="right"></mt-button>
        </mt-header>
    </div>
</template>
<style>
    .mint-button-text {
        color: #ffffff;
        font-size: 1.2rem;
    }

    .mint-header-title {
        font-size: 2.2rem;
        margin: 0;
    }

    .mint-header {
        height: 8%;
    }

</style>
<script>
    import {Header} from 'mint-ui';

    export default {
        name: "navbar",
        comments: [Header.name, Header],
        methods: {
            getTitle() {
                return this.$store.state.form.title
            },
            back() {
                return this.$store.state.form.linkName
            }
        }
    }
</script>

<style scoped>

</style>