<template>
    <div v-if="isAdmin" class="admin-controls">
        <ButtonClearWords />
        <ButtonResetCycle />
        <ButtonResetGame />

    </div>
</template>

<script>

    import { mapGetters } from 'vuex';
    import ButtonClearWords from './ButtonClearWords';
    import ButtonResetCycle from './ButtonResetCycle';
    import ButtonResetGame from './ButtonResetGame';


    export default {

        computed: {
            ...mapGetters(['isAdmin']),
        },

        components: {
            ButtonClearWords,
            ButtonResetCycle,
            ButtonResetGame,
        },

    }
</script>
