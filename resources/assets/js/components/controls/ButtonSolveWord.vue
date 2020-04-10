<template>
    <button
        v-if="isPlaying"
        @click="solveWord"
        class="button button-solve-word"
    >
        {{ 'OK' }}
    </button>
</template>

<script>

    import { mapGetters, mapState } from 'vuex';

    export default {
        computed: {
            ...mapState(['isRoundActive']),
            ...mapGetters(['isThisUsersTurn']),

            isPlaying() {
                return this.isRoundActive && this.isThisUsersTurn;
            },
        },

        methods: {
            async solveWord() {
                await this.$store.dispatch('solveWord');
                await this.$store.dispatch('chooseRandomWord');
            },
        },
    }
</script>

<style lang="scss" scoped>
    .button-solve-word {
        width: 85px;
        height: 85px;
        border-radius: 50%;
        background: linear-gradient(210deg, var(--color-current-team-light) 20%, var(--color-current-team-dark) 80%);
        box-shadow: 2px 5px 11px 0 rgba(24,34,70,0.24);
        color: var(--color-current-team-contrast);
    }
</style>
