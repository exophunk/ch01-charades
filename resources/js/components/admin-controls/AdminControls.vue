<template>
    <div class="admin-controls">
        <ButtonClearWords />
        <ButtonResetCycle />
        <ButtonResetGame />
        <ButtonStartGame />
    </div>
</template>

<script>

    import ButtonClearWords from './ButtonClearWords';
    import ButtonResetCycle from './ButtonResetCycle';
    import ButtonResetGame from './ButtonResetGame';
    import ButtonStartGame from './ButtonStartGame';

    export default {

        components: {
            ButtonClearWords,
            ButtonResetCycle,
            ButtonResetGame,
            ButtonStartGame,
        },

    }
</script>
