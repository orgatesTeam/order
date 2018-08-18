<template>
    <div>
        <div class="comming-soon">comming soon</div>
    </div>
</template>

<script>
    export default {
        name: "System",
        data() {
            return {
            }
        },
        mounted() {
            this.$store.commit('setFormTitle', '系統管理')
        },
        methods: {}
    }
</script>

<style scoped>

</style>