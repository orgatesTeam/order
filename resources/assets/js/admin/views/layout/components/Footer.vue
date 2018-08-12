<template>
    <div>
        <footer>
           test
        </footer>
    </div>
</template>
<style scoped>
    footer {
        /* 設定footer的高度 */
        height: 50px;
        /* 設定footer絕對位置在底部 */
        position: absolute;
        z-index: 1;
        bottom: 50px;
        /* 展開footer寬度 */
        width: 100%;
    }
</style>
<script>
    export default {
        name: "Footer",
        computed: {
            title() {
                return this.$store.state.form.title
            },
            back() {
                return this.$store.state.form.linkName
            }
        }
    }
</script>

<style scoped>

</style>