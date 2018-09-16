<template>
    <div>
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
    import {deepObjectClone} from "../../utils/helper";
    import $ from 'jquery'
    import {updateMenuType} from "../../api/menu";
    import {Toast} from 'mint-ui';

    export default {
        name: "Type",
        data() {
            return {
                menuTypes: []
            }
        },
        mounted() {
            this.$store.commit('setFormTitle', '菜單種類管理')
            this.getMenuTypes()
        },
        methods: {
            getMenuTypes(force = false) {
                let that = this
                getMenuTypes(menuTypes => {
                    that.menuTypes = deepObjectClone(menuTypes)
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
        }
    }
</script>

<style scoped>

</style>