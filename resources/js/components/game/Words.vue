<template>
    <div class="words">

        <ul class="word-pile">
            <li class="word-pile__word" v-for="word in unsolvedWords" :key="word.id">{{ word.word }}</li>
        </ul>

        <div v-if="isRoundActive && isThisUsersTurn" class="">
            <div class="word">{{ drawnWord }}</div>
            <button @click="solveWord">Wort erraten</button>
            <button @click="skipWord">Überspringen</button>
        </div>


    </div>
</template>

<script>

    import axios from 'axios';
    import { mapGetters, mapState } from 'vuex';

    export default {

        components: {

        },

        data() {
            return {
                drawnWord: null,
            };
        },

        computed: {
            ...mapState(['isRoundActive']),
            ...mapGetters(['isThisUsersTurn', 'unsolvedWords']),

            isPlaying() {
                return this.isRoundActive && this.isThisUsersTurn;
            },
        },

        watch: {
            isPlaying() {
                if (this.isPlaying) {
                    this.chooseRandomWord();
                }
            },
        },

        mounted() {

        },

        methods: {
            async chooseRandomWord() {
                const otherWords = this.unsolvedWords.length > 1 ? this.unsolvedWords.filter(word => word !== this.drawnWord) : this.unsolvedWords;
                this.drawnWord = otherWords[Math.floor(Math.random() * otherWords.length)];
            },

            async solveWord() {
                await this.$store.dispatch('solveWord', this.drawnWord);
                this.chooseRandomWord();
            },

            skipWord() {
                this.chooseRandomWord();
            },
        },
    }
</script>
