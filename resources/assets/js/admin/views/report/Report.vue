<template>
    <div>
        <div class="comming-soon">comming soon</div>
    </div>
</template>

<script>
    export default {
        name: "report",
        mounted() {
            this.$store.commit('setFormTitle', '報表管理')
        },
    }
</script>

<style scoped>

</style>