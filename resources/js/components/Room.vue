<template>
    <div class="app">
        <h1>{{ room.name }}</h1>

        <Game />
        <Teams />
    </div>
</template>

<script>

    import Game from './Game';
    import Teams from './Teams';

    export default {

        components: {
            Game,
            Teams,
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

        created() {
            this.$store.commit('setUser', this.user);
            this.$store.commit('setRoom', this.room);

            this.joinChannels();
            this.listenToEvents();
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
                });
                this.$options.channelRoom.listen('GuessWord', (data) => {
                });
                this.$options.channelRoom.listen('SkipWord', (data) => {
                });
            },
        },
    }
</script>
