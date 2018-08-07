<template>
    <div>
        <nav class="light-blue lighten-1">
            <div class="nav-wrapper">
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="left hide-on-med-and-down">
                    <li>
                        <router-link :to="{ name: 'order' }">Order</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'hello' }">Hello</router-link>
                    </li>
                </ul>
            </div>
        </nav>

        <ul class="sidenav" id="mobile-demo">
            <li>
                <router-link :to="{ name: 'order' }">Order</router-link>
            </li>
            <li>
                <router-link :to="{ name: 'hello' }">Hello</router-link>
            </li>
        </ul>

    </div>
</template>

<script>
    export default {
        name: "navbar"
    }
</script>

<style scoped>

</style>