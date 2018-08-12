<template>
    <section class="app-main">
        <transition name="fade-transform" mode="out-in">
            <keep-alive>
                <div>
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
        position: absolute;
        height: calc(100% - 100px);
        width: 100%;
        overflow: auto;
    }
</style>