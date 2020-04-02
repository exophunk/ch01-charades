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
        }
    }
</script>
