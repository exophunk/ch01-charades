<template>
    <div class="words">
        <transition-group name="word" tag="ul">
            <li
                v-for="word in unsolvedWords"
                :key="word.id"
                class="word-list__word"
                :class="{ 'word-list__word--is-drawn': word == drawnWord }"
            >
                <Word :word="word" />
            </li>
        </transition-group>
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

        computed: {
            ...mapState(['isRoundActive', 'drawnWord']),
            ...mapGetters(['isThisUsersTurn', 'unsolvedWords']),

            isPlaying() {
                return this.isRoundActive && this.isThisUsersTurn;
            },
        },

        watch: {
            isPlaying() {
                if (this.isPlaying) {
                    this.$store.dispatch('chooseRandomWord');
                }
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

    .word-list__word {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        perspective: 700px;

        &.word-list__word--is-drawn {
            z-index: 1;
        }
    }

</style>
