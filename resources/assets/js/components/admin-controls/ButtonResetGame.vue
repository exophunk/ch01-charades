<template>
    <button
        v-if="cycle > 0"
        @click="resetGame"
        class="button button-reset-game"
    >
        {{ 'Spiel neu starten' }}
    </button>
</template>

<script>

    import { mapGetters } from 'vuex';

    export default {

        computed: {
            ...mapGetters(['cycle']),
        },

        methods: {
            resetGame() {
                this.$store.commit('setIsNavigationOpen', false);
                this.$store.dispatch('resetGame');
            },
        },
    }
</script>

<style lang="scss" scoped>
    .button-start-round {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
    }
</style>
