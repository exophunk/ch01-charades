<template>
    <button
        v-if="cycle == 0"
        @click="switchTeam"
        class="button button-switch-team"
    >
        {{ 'Team wechseln' }}
    </button>
</template>

<script>

    import { mapGetters } from 'vuex';

    export default {

        computed: {
            ...mapGetters(['cycle']),
        },

        methods: {
            switchTeam() {
                this.$store.dispatch('switchTeam');
            },
        },
    }
</script>
