<template>
    <div class="game">

        <div class="countdown" v-if="isRoundActive">
            {{ remainingRoundTimePercentage }} - {{ remainingRoundTimeText }}
        </div>


        <div class="is-you" v-if="isRoundActive">
            {{ isYourTeam ? 'Dein Team' : 'Gegner' }}
            {{ isYourTurn ? 'DU BISCH DRA' : 'Zuschauer' }}
        </div>

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

    import { mapGetters, mapState } from 'vuex';
    import parseISO from 'date-fns/parseISO';
    import isBefore from 'date-fns/isBefore';
    import isAfter from 'date-fns/isAfter';
    import differenceInSeconds from 'date-fns/differenceInSeconds';
    import formatDistanceStrict from 'date-fns/formatDistanceStrict';
    import { de } from 'date-fns/locale'
    import CreateWord from './CreateWord';

    export default {

        components: {
            CreateWord,
        },

        data() {
            return {
                isRoundActive: false,
                remainingRoundTimePercentage: 0,
                remainingRoundTimeText: '',
            };
        },

        computed: {
            ...mapGetters(['cycle', 'words', 'rounds', 'latestRound', 'userTeam']),
            ...mapState(['user']),

            isYourTurn() {
                return this.latestRound && this.latestRound.user_id === this.user.id;
            },
            isYourTeam() {
                return this.latestRound && this.latestRound.team_id === this.userTeam.id;
            },
        },

        mounted() {
            setInterval(this.loop, 1000);
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
            loop() {
                this.isRoundActive = this.latestRound
                    && isAfter(new Date(), new Date(this.latestRound.round_start))
                    && isBefore(new Date(), new Date(this.latestRound.round_end));

                if (this.isRoundActive) {
                    const remainingRoundTimeSeconds = differenceInSeconds(new Date(this.latestRound.round_end), new Date());
                    this.remainingRoundTimePercentage = 1 / this.$store.state.room.round_duration * remainingRoundTimeSeconds;
                    this.remainingRoundTimeText = formatDistanceStrict(new Date(), new Date(this.latestRound.round_end), {
                        unit: 'second',
                        locale: de,
                    });
                }
            }
        },
    }
</script>
