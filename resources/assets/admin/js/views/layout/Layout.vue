<template>
    <div>
        <navbar></navbar>
        <app-main></app-main>
    </div>
</template>

<script>
    import Navbar from './components/Navbar'
    import AppMain from './components/AppMain'

    export default {
        name: "layout",
        components: {
            Navbar,
            AppMain
        },
    }
</script>

<style scoped>

</style>