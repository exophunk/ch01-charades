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
