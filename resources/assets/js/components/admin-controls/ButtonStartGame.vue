<template>
    <button
        v-if="cycle == 0 && isAdmin"
        @click="startGame"
        class="button button-start-game"
    >
        {{ 'Spiel Starten' }}
    </button>
</template>

<script>

    import { mapGetters } from 'vuex';

    export default {

        computed: {
            ...mapGetters(['cycle', 'isAdmin']),
        },

        methods: {
            startGame() {
                this.$store.dispatch('startGame');
            },
        },
    }
</script>

<style lang="scss" scoped>
    .button-start-game {
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
        box-shadow: 2px 5px 11px 0 rgba(24,34,70,0.24);
        color: var(--color-current-team-contrast);
        z-index: 10;
    }
</style>
