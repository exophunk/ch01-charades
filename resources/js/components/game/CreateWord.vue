<template>
    <div class="create-word">
        <input type="text" v-model="word">
        <button @click="createWord">Add</button>
    </div>
</template>

<script>



    export default {

        data() {
            return {
                word: '',
            };
        },

        methods: {
            createWord() {
                this.$store.dispatch('createWord', this.word);
                this.word = '';
            }
        }
    }
</script>
