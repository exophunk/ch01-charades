<template>
    <div v-if="cycle == 0" class="create-word">
        <input type="text" v-model="word">
        <button @click="createWord">Add</button>
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';

    export default {

        data() {
            return {
                word: '',
            };
        },

        computed: {
            ...mapGetters(['cycle']),
        },

        methods: {
            createWord() {
                this.$store.dispatch('createWord', this.word);
                this.word = '';
            }
        }
    }
</script>
