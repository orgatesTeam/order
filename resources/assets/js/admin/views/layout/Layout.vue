<template>
    <div>
        <navbar></navbar>
        <app-main :class="appMainCss" v-if="appMainHackReset"></app-main>
        <popup></popup>
        <footer-menu></footer-menu>
    </div>
</template>

<script>
    import Navbar from './components/Navbar'
    import AppMain from './components/AppMain'
    import Popup from './components/Popup'
    import FooterMenu from './components/FooterMenu'

    export default {
        name: "layout",
        components: {
            Navbar,
            AppMain,
            Popup,
            FooterMenu,
        },
        computed: {
            appMainCss() {
                if (this.$store.state.popup.showLoading) {
                    return 'unselectable'
                }
            },
            appMainHackReset(){
                return this.$store.state.form.hackAppMainReset
            }
        }
    }
</script>