<template>
    <div>

        <mt-tab-container v-model="tabContainer" swipeable="true">

            <mt-tab-container-item id="1">
                <div v-for="store in stores">
                    <mt-field label="用户名" placeholder="请输入用户名" v-model="username"></mt-field>
                </div>
            </mt-tab-container-item>

            <mt-tab-container-item id="2">
                <mt-cell title="标题文字" value="说明文字"></mt-cell>
            </mt-tab-container-item>

        </mt-tab-container>
    </div>
</template>
<script>
    import {TabContainer, TabContainerItem} from 'mint-ui';
    import {Cell} from 'mint-ui';
    import {Field} from 'mint-ui';

    export default {
        name: "System",
        data() {
            return {
                tabContainer: '1',
            }
        },
        comments: [Field.name, Field, Cell.name, Cell, TabContainer.name, TabContainer, TabContainerItem.name, TabContainerItem],
        mounted() {
            this.$store.commit('setFormTitle', '系統管理')
        },
        methods: {}
    }
</script>

<style scoped>

</style>