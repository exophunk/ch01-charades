<template>
    <div class="game">

        <Words />

        <ul>
            <li v-for="round in rounds" :key="round.id">{{ round.round_start }}, User: {{ round.user_id }}</li>
        </ul>

        <CreateWord />
        <ButtonStartRound />
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';
    import Words from './Words';
    import CreateWord from './CreateWord';
    import ButtonStartRound from './ButtonStartRound';

    export default {

        components: {
            CreateWord,
            ButtonStartRound,
            Words,
        },

        data() {
            return {
            };
        },

        computed: {
            ...mapGetters(['rounds']),
        },

        mounted() {

        },

        methods: {

        },
    }
</script>
