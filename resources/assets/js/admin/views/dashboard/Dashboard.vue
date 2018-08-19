<template>
    <div>
        <div class="comming-soon">comming soon</div>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        mounted(){
            this.$store.commit('setFormTitle','主頁')
        }
    }
</script>

<style scoped>

</style>