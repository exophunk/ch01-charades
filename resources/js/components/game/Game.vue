<template>
    <div class="game">

        <Words />

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

        <button
            v-if="cycle > 0 && !isRoundActive && isThisUsersTurn"
            @click="startRound"
        >
            {{ 'Runde Starten' }}
        </button>

        <button
            v-if="cycle > 0"
            @click="resetCycle"
        >
            {{ 'Reset' }}
        </button>
    </div>
</template>

<script>

    import { mapGetters, mapState } from 'vuex';
    import Words from './Words';
    import CreateWord from './CreateWord';

    export default {

        components: {
            CreateWord,
            Words,
        },

        data() {
            return {
            };
        },

        computed: {
            ...mapGetters(['cycle', 'rounds', 'isThisUsersTurn']),
            ...mapState(['isRoundActive']),
        },

        mounted() {

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
