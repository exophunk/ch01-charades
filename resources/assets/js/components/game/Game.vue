<template>
    <div class="game">
        <Words />
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

<style lang="scss" scoped>
    .game {
        @include mq($from: tablet) {
            width: 50%;
        }
    }
</style>
