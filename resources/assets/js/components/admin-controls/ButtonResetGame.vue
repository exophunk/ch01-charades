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
                this.$store.dispatch('resetGame');
            },
        },
    }
</script>
