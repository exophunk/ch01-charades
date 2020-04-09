<template>
    <div class="words">

        <div
            class="words__inner"
        >
            <Word
                v-for="word in unsolvedWords"
                :key="word.id"
                :word="word"
                :randomX="Math.random()"
                :randomY="Math.random()"
                :randomRotation="Math.random()"
                :is-drawn="isPlaying && drawnWord && word.id === drawnWord.id"
            />
        </div>

        <div v-if="isPlaying" class="buttons">
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
            ...mapGetters(['cycle', 'isThisUsersTurn', 'unsolvedWords']),

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
        @include aspect-ratio(2, 1);
        width: 100%;

        // @include mq($from: tablet) {
        //     @include aspect-ratio(4, 3);
        // }
    }

    .button-solve-word {
        position: absolute;
        border-radius: 50%;
        width: 90px;
        height: 90px;
        bottom: 0;
        left: 25%;
        background: white;
        transform: translateX(-50%);
        border: 1px solid black;
        z-index: 2;

        @include mq($from: tablet) {
            width: 70px;
            height: 70px;
        }
    }

    .button-skip-word {
        position: absolute;
        border-radius: 50%;
        width: 90px;
        height: 90px;
        bottom: 0;
        left: 75%;
        transform: translateX(-50%);
        background: white;
        border: 1px solid black;
        z-index: 2;

        @include mq($from: tablet) {
            width: 70px;
            height: 70px;
        }
    }



</style>
