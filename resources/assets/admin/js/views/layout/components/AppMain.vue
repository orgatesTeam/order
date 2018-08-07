<template>
    <section class="app-main">
        <transition name="fade-transform" mode="out-in">
            <keep-alive :include="cachedViews">
                <div class="container">
                    <router-view :key="key"></router-view>
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

</style>