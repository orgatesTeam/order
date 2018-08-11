<template>
    <section class="app-main">
        <transition name="fade-transform" mode="out-in">
            <keep-alive>
                <div class="container">
                    <router-view></router-view>
                </div>
            </keep-alive>
        </transition>
    </section>
</template>
<script>
    export default {
        name: "AppMain"
    }
</script>

<style scoped>
    .app-main {
        margin-top: 10%;
    }
</style>