<template>
    <div v-if="isAdmin" class="admin-controls">
        <ButtonClearWords />
        <ButtonResetCycle />
        <ButtonResetGame />
        <ButtonStartGame />
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';
    import ButtonClearWords from './ButtonClearWords';
    import ButtonResetCycle from './ButtonResetCycle';
    import ButtonResetGame from './ButtonResetGame';
    import ButtonStartGame from './ButtonStartGame';

    export default {

        computed: {
            ...mapGetters(['isAdmin']),
        },

        components: {
            ButtonClearWords,
            ButtonResetCycle,
            ButtonResetGame,
            ButtonStartGame,
        },

    }
</script>
