<template>
    <button
        @click="leaveRoom"
        class="button button-leave-room"
    >
        {{ 'Spiel verlassen' }}
    </button>
</template>

<script>
    export default {
        methods: {
            leaveRoom() {
                this.$store.commit('setIsNavigationOpen', false);
                this.$store.dispatch('leaveRoom');
            },
        },
    }
</script>
