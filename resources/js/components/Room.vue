<template>
    <div class="app">
        <Header />
        <Countdown v-if="this.latestRound && $store.state.isRoundActive" />

        <Game />
        <Teams />
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';
    import parseISO from 'date-fns/parseISO';
    import isBefore from 'date-fns/isBefore';
    import isAfter from 'date-fns/isAfter';
    import Header from './Header';
    import Game from './game/Game';
    import Teams from './teams/Teams';
    import Countdown from './Countdown';

    export default {

        components: {
            Header,
            Game,
            Teams,
            Countdown,
        },

        props: {
            user: {
                type: Object,
                required: true,
            },
            room: {
                type: Object,
                required: true,
            },
        },

        computed: {
            ...mapGetters(['latestRound', 'teams']),
        },

        created() {
            this.$store.commit('setUser', this.user);
            this.$store.commit('setRoom', this.room);
        },

        mounted() {
            this.joinChannels();
            this.listenToEvents();
            this.$options.interval = setInterval(this.loop, 200);
        },


        methods: {
            joinChannels() {
                this.$options.channelRoom = Echo.private(`room.${this.room.id}`);
            },

            listenToEvents() {
                this.$options.channelRoom.listen('CreateWord', (data) => {
                    this.$store.commit('createWord', data.word);
                });
                this.$options.channelRoom.listen('StartCycle', (data) => {
                    this.$store.commit('setCycle', data.cycle);
                });
                this.$options.channelRoom.listen('ResetCycle', (data) => {
                    this.$store.commit('setRoom', data.room);
                });
                this.$options.channelRoom.listen('StartRound', (data) => {
                    this.$store.commit('addRound', data.round);
                    this.$store.commit('setNextTurn', data.nextTurn);
                });
                this.$options.channelRoom.listen('SolveWord', (data) => {
                    this.$store.commit('setRoom', data.room);
                });
                this.$options.channelRoom.listen('EndCycle', (data) => {
                    this.$store.commit('setRoom', data.room);
                });
            },

            loop() {
                const isRoundActive = this.latestRound !== null
                    && isAfter(new Date(), new Date(this.latestRound.round_start))
                    && isBefore(new Date(), new Date(this.latestRound.round_end));

                if (isRoundActive != this.$store.state.isRoundActive) {
                    this.$store.commit('setIsRoundActive', isRoundActive);
                }
            }
        },

        beforeDestroy() {
            clearInterval(this.$options.interval);
        }
    }
</script>
