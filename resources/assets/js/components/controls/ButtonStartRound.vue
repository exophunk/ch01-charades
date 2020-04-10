<template>
    <button
        v-if="cycle > 0 && !isRoundActive && isThisUsersTurn"
        @click="startRound"
        class="button button-start-round"
    >
        {{ 'Runde Starten' }}
    </button>
</template>

<script>

    import { mapState, mapGetters } from 'vuex';

    export default {

        computed: {
            ...mapGetters(['cycle', 'isThisUsersTurn']),
            ...mapState(['isRoundActive']),
        },

        methods: {
            startRound() {
                this.$store.dispatch('startRound');
            },
        },
    }
</script>

<style lang="scss" scoped>
    .button-start-round {
        @include typo-button-big;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
        width: 120px;
        height: 120px;
        padding: 20px;
        border-radius: 50%;
        background: linear-gradient(210deg, var(--color-current-team-light) 20%, var(--color-current-team-dark) 80%);
        box-shadow: 3px 3px 11px 0 rgba(black, 0.2);
        color: var(--color-current-team-contrast);
        z-index: 10;
    }
</style>
