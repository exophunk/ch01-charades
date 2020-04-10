<template>
    <button
        v-if="cycle > 0 && !isRoundActive || 1==1"
        @click="resetCycle"
        class="button button-reset-cycle"
    >
        {{ 'Durchgang neu starten' }}
    </button>
</template>

<script>

    import { mapState, mapGetters } from 'vuex';

    export default {

        computed: {
            ...mapState(['isRoundActive']),
            ...mapGetters(['cycle']),
        },

        methods: {
            resetCycle() {
                this.$store.commit('setIsNavigationOpen', false);
                this.$store.dispatch('resetCycle');
            },
        },
    }
</script>
