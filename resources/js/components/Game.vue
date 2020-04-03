<template>
    <div class="game">
        <div class="cycle">
            cycle: {{ cycle }}
        </div>

        <ul>
            <li v-for="word in words" :key="word.id">{{ word.word }}</li>
        </ul>

        <ul>
            <li v-for="round in rounds" :key="round.id">{{ round.round_start }}, User: {{ round.user_id }}</li>
        </ul>

        <CreateWord v-if="cycle == 0" />

        <button
            v-if="cycle == 0"
            @click="startCycle"
        >
            {{ 'Spiel Starten' }}
        </button>

        <button @click="startRound">{{ 'Runde Starten' }}</button>
        <button @click="resetCycle">{{ 'Reset' }}</button>
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';
    import CreateWord from './CreateWord';

    export default {

        components: {
            CreateWord,
        },

        computed: {
            ...mapGetters(['cycle', 'words', 'rounds']),
        },

        methods: {
            startCycle() {
                this.$store.dispatch('startCycle');
            },
            resetCycle() {
                this.$store.dispatch('resetCycle');
            },
            startRound() {
                this.$store.dispatch('startRound');
            },
        },
    }
</script>
