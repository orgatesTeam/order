<template>
    <div>
        <header class="navbar-header">
            <div class="navbar-left">
                <router-link :to="back" slot="left">
                    <i class="mintui mintui-back">返回</i>
                </router-link>
            </div>
            <div class="navbar-title">
                {{title}}
            </div>
        </header>
        <div class="abstract-header">

        </div>
    </div>
</template>
<style>
    .abstract-header{
        display: block;
        width: 100%;
        height: 50px;
    }
    .navbar-header {
        position: fixed;
        color:#ffffff;
        border-bottom: 1px solid #039be5;
        background-color: #039be5;
        height: 50px;
        line-height: 50px;
        z-index: 1;
        margin: 0;
        width: 100%;
        top:0;
    }

    .navbar-left {
        width: 20%;
        transform: translateX(30%);
        float: left;
        color:#ffffff;
    }

    .navbar-left a {
        text-decoration: none;
        color:#ffffff;
    }

    .navbar-title {
        position: fixed;
        left:50%;
        transform: translateX(-50%);
        font-size: 1.3rem;
        font-weight: 200;
        z-index: 2;
    }

</style>
<script>
    export default {
        name: "navbar",
        computed:{
            title(){
                return  this.$store.state.form.title
            },
            back(){
                return this.$store.state.form.linkName
            }
        }
    }
</script>

<style scoped>

</style>