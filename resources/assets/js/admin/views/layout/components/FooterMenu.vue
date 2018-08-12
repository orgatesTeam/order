<template>
    <div>
        <mt-tabbar v-model="selected">
            <mt-tab-item id="main">
                <i class="material-icons dp48">call_to_action</i>
                主頁
            </mt-tab-item>
            <mt-tab-item id="report">
                <i class="material-icons dp48">description</i>
                報表
            </mt-tab-item>
            <mt-tab-item id="system">
                <i class="material-icons dp48">event_note</i>
                系統
            </mt-tab-item>
            <mt-tab-item id="menu" class="menu">
                <i class="material-icons dp48">menu</i>
                選單
            </mt-tab-item>
        </mt-tabbar>
    </div>
</template>
<style scoped>
    i {
        display: block;
        margin-bottom: 5px;
    }

    footer {
        display: block;
        position: fixed;
        color: #ffffff;
        border-bottom: 1px solid #039be5;
        background-color: #039be5;
        height: 50px;
        line-height: 50px;
        z-index: 1;
        margin: 0;
        width: 100%;
        bottom: 0;
    }

    .menu {
        color: red;
    }
</style>
<script>
    import {Tabbar, TabItem} from 'mint-ui';

    export default {
        name: "FooterMenu",
        comments: [Tabbar.name, Tabbar, TabItem.name, TabItem],
        data() {
            return {
                selected: 'main'
            }
        },
        watch: {
            selected() {
                if (this.selected == 'main') {
                    this.$router.push({name: 'menu'})
                }
                if (this.selected == 'menu') {
                    alert(1)
                }
            }
        }
    }
</script>