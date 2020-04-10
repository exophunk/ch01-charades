<template>
    <button
        v-if="isPlaying"
        @click="skipWord"
        class="button button-skip-word"
    >
        <i class="fas fa-undo fa-lg"></i>
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
            async skipWord() {
                await this.$store.dispatch('chooseRandomWord');
            },
        },
    }
</script>

<style lang="scss" scoped>
    .button-skip-word {
        width: 85px;
        height: 85px;
        border-radius: 50%;
        border: 2px solid $color-white;
        color: $color-white;
    }
</style>
