<template>
    <div>
        <div @click="create()" style="position: fixed; right: 10vw;top: 10vh;z-index: 9999999">
            <mt-palette-button content="+"
                               mainButtonStyle="color:#fff;background-color:#26a2ff;">
                <div class="my-icon-button"></div>
                <div class="my-icon-button"></div>
                <div class="my-icon-button"></div>
            </mt-palette-button>
        </div>
        <div v-for="menuType in menuTypes">
            <div @click="edit(menuType)">
                <mt-cell :title="menuType.name">
                </mt-cell>
            </div>
        </div>
    </div>
</template>

<script>
    import {getMenuTypes} from "../../cache/menu";
    import $ from 'jquery'
    import {updateMenuType} from "../../api/menu";
    import {createMenuType} from "../../api/menu";
    import {deleteMenuType} from "../../api/menu";
    import {Toast} from 'mint-ui';

    export default {
        name: "Type",
        data() {
            return {}
        },
        computed: {
            menuTypes() {
                return this.$store.state.menu.cacheMenuTypes
            }
        },
        mounted() {
            this.$store.commit('setFormTitle', '菜單種類管理')
            this.getMenuTypes()
        },
        methods: {
            create() {
                let that = this
                $.confirm({
                    title: '新增菜單種類!',
                    content:
                        '<form action="" class="formName" style="margin-top: 10px">' +
                        '<div class="form-group" style="line-height: 2.5rem;font-size: 1.5rem">' +
                        '<input type="text" placeholder="請輸入菜單種類名稱" class="menu-type-name form-control" required />' +
                        '</div>' +
                        '</form>',
                    buttons: {
                        formSubmit: {
                            text: '確定',
                            btnClass: 'btn-blue',
                            action: function () {
                                var name = this.$content.find('.menu-type-name').val();
                                if (name) {
                                    let data = {
                                        menu_type_name: name
                                    }
                                    createMenuType(data).then(response => {
                                        if (response.data.code == '202') {
                                            Toast({
                                                message: '更新成功',
                                                position: 'middle',
                                                duration: 800
                                            });
                                            that.getMenuTypes(true)
                                        }
                                    })
                                }
                            }
                        },
                        cancel: {
                            text: '取消'
                        },
                    },
                    onContentReady: function () {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            },
            getMenuTypes(force = false) {
                let that = this
                //觸發store
                getMenuTypes(menuTypes => {
                }, force)
            },
            edit(menuType) {
                let that = this
                $.confirm({
                    title: '編輯菜單種類!',
                    content: `名稱：${menuType.name}` +
                        '<form action="" class="formName" style="margin-top: 10px">' +
                        '<div class="form-group" style="line-height: 2.5rem;font-size: 1.5rem">' +
                        '<input type="text" placeholder="請輸入菜單種類名稱" class="menu-type-name form-control" required />' +
                        '</div>' +
                        '</form>',
                    buttons: {
                        formSubmit: {
                            text: '確定',
                            btnClass: 'btn-blue',
                            action: function () {
                                var name = this.$content.find('.menu-type-name').val();
                                if (name) {
                                    let data = {
                                        menu_type_id: menuType.id,
                                        menu_type_name: name
                                    }
                                    updateMenuType(data).then(response => {
                                        if (response.data.code == '202') {
                                            Toast({
                                                message: '更新成功',
                                                position: 'middle',
                                                duration: 800
                                            });
                                            that.getMenuTypes(true)
                                            that.$store.commit('refreshMenus')
                                        }
                                    })
                                }
                            }
                        },
                        delete: {
                            text: "刪除",
                            btnClass: 'btn-red',
                            action: function () {
                                $.confirm({
                                    title: '確定刪除!',
                                    content: `名稱：${menuType.name}`,
                                    type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        ok: {
                                            text: '確定',
                                            btnClass: 'btn-red',
                                            action: function () {
                                                let data = {
                                                    menu_type_id: menuType.id,
                                                    menu_type_name: menuType.name
                                                }
                                                deleteMenuType(data).then(response => {
                                                    if (response.data.code == '202') {
                                                        Toast({
                                                            message: '刪除成功',
                                                            position: 'middle',
                                                            duration: 800
                                                        });
                                                        that.getMenuTypes(true)
                                                        that.$store.commit('refreshMenus')
                                                    }
                                                })
                                            }
                                        },
                                        close: {
                                            text: '取消'
                                        }
                                    }
                                });
                            }
                        },

                        cancel: {
                            text: '取消'
                        },
                    },
                    onContentReady: function () {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            },
        }
    }
</script>

<style scoped>

</style>