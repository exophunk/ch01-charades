<template>
    <button
        v-if="cycle == 0"
        @click="switchTeam"
        class="button button-switch-team"
    >
        <i class="fas fa-exchange-alt"></i>
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


<style lang="scss" scoped>
    .button-switch-team {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        left: 50%;
        top: 0px;
        transform: translateX(-50%) translateY(-50%);
        width: 35px;
        height: 35px;
        border-radius: 50%;
        line-height: 1;
        background: linear-gradient(210deg, var(--color-current-team-light) 20%, var(--color-current-team-dark) 80%);
        box-shadow: 2px 5px 11px 0 rgba(24,34,70,0.24);
        color: var(--color-current-team-contrast);
    }
</style>
