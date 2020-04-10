<template>
    <div class="room" :class="classes">

        <div class="room_top">
            <Header />
            <Countdown />
            <div class="room_game">
                <Words />
                <ButtonStartRound />
                <ButtonStartGame />
            </div>
        </div>

        <div class="room__actions">
            <CreateWord />
            <ButtonSkipWord />
            <ButtonSolveWord />
            <NextActionText />
        </div>

        <div class="room__bottom">
            <Teams />
        </div>
        <AdminControls />
        <!-- <ButtonLeaveRoom /> -->
        <!-- <ButtonSwitchTeam /> -->
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';
    import parseISO from 'date-fns/parseISO';
    import isBefore from 'date-fns/isBefore';
    import isAfter from 'date-fns/isAfter';
    import Header from './Header';
    import Teams from './teams/Teams';
    import Countdown from './Countdown';
    import Words from './game/Words';
    import AdminControls from './admin-controls/AdminControls';
    import ButtonStartGame from './admin-controls/ButtonStartGame';
    import CreateWord from './controls/CreateWord';
    import ButtonLeaveRoom from './controls/ButtonLeaveRoom';
    import ButtonSwitchTeam from './controls/ButtonSwitchTeam';
    import ButtonStartRound from './controls/ButtonStartRound';
    import ButtonSolveWord from './controls/ButtonSolveWord';
    import ButtonSkipWord from './controls/ButtonSkipWord';
    import NextActionText from './controls/NextActionText';

    export default {

        components: {
            Header,
            Teams,
            Countdown,
            AdminControls,
            CreateWord,
            Words,
            ButtonLeaveRoom,
            ButtonSwitchTeam,
            ButtonStartRound,
            ButtonStartGame,
            ButtonSolveWord,
            ButtonSkipWord,
            NextActionText,
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
            ...mapGetters(['cycle', 'isThisUsersTurn', 'latestRound', 'currentTeam', 'currentTeamIndex']),

            classes() {
                const classes = [];
                if (this.cycle > 0 && this.currentTeam) {
                    classes.push(`room--current-team-${this.currentTeamIndex + 1}`);
                    classes.push(`room--is-started`);
                }
                return classes;
            },
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
                this.$options.channelRoom.listen('JoinRoom', (data) => {
                    this.$store.commit('setRoom', data.room);
                });
                this.$options.channelRoom.listen('LeaveRoom', (data) => {
                    this.$store.commit('setRoom', data.room);
                });
                this.$options.channelRoom.listen('SwitchTeam', (data) => {
                    this.$store.commit('setRoom', data.room);
                });
                this.$options.channelRoom.listen('KickUser', (data) => {
                    this.$store.commit('setRoom', data.room);
                    if (data.kickedUser.id === this.user.id) {
                        window.location.href = '/home';
                    }
                });
                this.$options.channelRoom.listen('CreateWord', (data) => {
                    this.$store.commit('createWord', data.word);
                });
                this.$options.channelRoom.listen('StartGame', (data) => {
                    this.$store.commit('setCycle', data.cycle);
                });
                this.$options.channelRoom.listen('ResetGame', (data) => {
                    this.$store.commit('setRoom', data.room);
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
                this.$options.channelRoom.listen('ClearWords', (data) => {
                    this.$store.commit('setWords', []);
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
                    if (this.isThisUsersTurn)
                    this.$store.commit('setDrawnWord', null);
                    this.$store.commit('setIsRoundActive', isRoundActive);
                }
            }
        },

        beforeDestroy() {
            clearInterval(this.$options.interval);
            window.removeEventListener('beforeunload', this.$options.onBeforeUnload);
        }
    }
</script>

<style lang="scss" scoped>
    .room {
        display: flex;
        flex-direction: column;
        height: 100%;
        justify-content: space-between;
    }

    .room_top { }
    .room_game {
        position: relative;
    }

    .room__actions {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
    }
    .room__bottom { }
</style>
