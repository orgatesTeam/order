<template>
    <div>
        <nav class="light-blue lighten-1">
            <div class="nav-wrapper">
                <a class="brand-logo center"></a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="left hide-on-med-and-down">
                    <li>
                        <router-link :to="{ name: 'login' }">Login</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'hello' }">Hello World</router-link>
                    </li>
                </ul>
            </div>
        </nav>
        <ul class="sidenav" id="mobile-demo">
            <li>
                <router-link :to="{ name: 'login' }">Login</router-link>
            </li>
            <li>
                <router-link :to="{ name: 'hello' }">Hello World</router-link>
            </li>
        </ul>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>