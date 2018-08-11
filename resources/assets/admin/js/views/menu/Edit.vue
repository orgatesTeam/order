<template>
    <div>
        <div class="section">
            <mt-field label="菜單名稱" v-model="menu.name"></mt-field>
            <mt-field label="價格" type="tel" v-model="menu.price"></mt-field>
            <mt-field label="種類" v-model="menu.type"></mt-field>
        </div>
    </div>
</template>

<script>
    import {Field} from 'mint-ui';

    export default {
        name: "Edit",
        comments: [Field.name, Field],
        data() {
            return {
                menu: {
                    name: '',
                    price: '',
                    type: ''
                }
            }
        },
        mounted() {
            this.$store.commit('setFormTitle', '菜單編輯')
            if(this.$store.state.menu.editMenu){
                this.menu = this.$store.state.menu.editMenu
            }

        }
    }
</script>

<style scoped>

</style>