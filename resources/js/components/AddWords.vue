<template>
    <div class="add-words">
        <input type="text" v-model="word">
        <button @click="addNewWord">Add</button>
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
            addNewWord() {
                this.$store.dispatch('addNewWord', this.word);
                this.word = '';
            }
        }
    }
</script>
