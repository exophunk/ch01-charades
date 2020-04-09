<template>
    <button
        v-if="cycle == 0"
        @click="startGame"
        class="button button-start-game"
    >
        {{ 'Spiel Starten' }}
    </button>
</template>

<script>

    import { mapGetters } from 'vuex';

    export default {

        computed: {
            ...mapGetters(['cycle']),
        },

        methods: {
            startGame() {
                this.$store.dispatch('startGame');
            },
        },
    }
</script>

