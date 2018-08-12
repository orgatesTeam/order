<template>
    <div>
        <navbar></navbar>
        <app-main :class="appMainCss"></app-main>
        <popup></popup>
        <footer></footer>
    </div>
</template>

<script>
    import Navbar from './components/Navbar'
    import AppMain from './components/AppMain'
    import Popup from './components/Popup'
    import Footer from './components/Footer'

    export default {
        name: "layout",
        components: {
            Navbar,
            AppMain,
            Popup,
            Footer
        },
        computed: {
            appMainCss() {
                if (this.$store.state.popup.showLoading) {
                    return 'unselectable'
                }
            }
        }
    }
</script>