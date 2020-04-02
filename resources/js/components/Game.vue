<template>
    <div class="game">
        cycle: {{ cycle }}

        word cound: {{ words.length }}

        <AddWords v-if="cycle == 0" />

        <button
            v-if="cycle == 0"
            @click="goToNextCycle"
        >
            {{ 'Spiel Starten' }}
        </button>

        <button @click="startRound">{{ 'Runde Starten' }}</button>
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';
    import AddWords from './AddWords';

    export default {

        components: {
            AddWords,
        },

        computed: {
            ...mapGetters(['cycle', 'words']),
        },

        methods: {
            goToNextCycle() {
                this.$store.dispatch('goToNextCycle');
            },
            startRound() {
                this.$store.dispatch('startRound');
            },
        },
    }
</script>
