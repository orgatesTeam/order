<template>
    <div @click="tabClick">
        <mt-tabbar v-model="selected">
            <mt-tab-item id="dashboard">
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
            <mt-tab-item id="system-menu" class="menu">
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
    import {settingFooterMenu} from '../../../utils/helper'

    export default {
        name: "FooterMenu",
        comments: [Tabbar.name, Tabbar, TabItem.name, TabItem],
        data() {
            return {
                oldSelected: 'dashboard',
                selected: 'dashboard',
            }
        },
        mounted() {
            this.selected = this.$route.name
        },
        methods: {
            tabClick() {
                if (this.sameMenu()) {

                    //置頂
                    $(".app-main").animate({scrollTop: 0}, 0)
                }

                this.$router.push({name: this.selected})
                this.oldSelected = this.selected
            },
            sameMenu() {
                return this.oldSelected == this.selected
            },
            //清除快取 並且 刷新 component
            refreshStoreMenu() {
                this.$store.commit('resetMenus')
                this.$store.commit('setMenuPage', 1)
                this.$store.commit('setHackAppMainResetStatue', false)
                this.$nextTick(() => {
                    this.$store.commit('setHackAppMainResetStatue', true)
                })

            }
        }
    }
</script>