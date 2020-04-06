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
                this.$store.dispatch('leaveRoom');
            },
        },
    }
</script>
