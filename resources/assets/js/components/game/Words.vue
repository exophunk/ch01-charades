<template>
    <div class="words">

        <div class="words__inner">
            <Word
                v-for="word in unsolvedWords"
                :key="word.id"
                :word="word"
                :randomX="Math.random()"
                :randomY="Math.random()"
                :randomRotation="Math.random()"
                :is-drawn="drawnWord && word.id === drawnWord.id"
            />
        </div>

        <div v-if="isRoundActive && isThisUsersTurn" class="">
            <button class="button-solve-word" @click="solveWord">Wort erraten</button>
            <button class="button-skip-word" @click="skipWord">Überspringen</button>
        </div>
    </div>
</template>

<script>

    import axios from 'axios';
    import { mapGetters, mapState } from 'vuex';
    import Word from './Word';

    export default {

        components: {
            Word,
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
                this.$set(this.drawnWord, 'isJustSolved', true);
                await new Promise((resolve) => { setTimeout(() => { resolve() }, 500) });
                await this.$store.dispatch('solveWord', this.drawnWord);
                this.$set(this.drawnWord, 'isJustSolved', false);
                this.chooseRandomWord();

            },

            skipWord() {
                this.chooseRandomWord();
            },
        },
    }
</script>

<style lang="scss" scoped>
    .words {
        @include aspect-ratio(1, 1);
        width: 100%;
        background: #dddddd;
    }

    .button-solve-word {
        position: absolute;
        border-radius: 50%;
        width: 20vw;
        height: 20vw;
        bottom: 0;
        left: 25%;
        background: white;
        transform: translateX(-50%);
        border: 1px solid black;
    }

    .button-skip-word {
        position: absolute;
        border-radius: 50%;
        width: 20vw;
        height: 20vw;
        bottom: 0;
        left: 75%;
        transform: translateX(-50%);
        background: white;
        border: 1px solid black;
    }



</style>
