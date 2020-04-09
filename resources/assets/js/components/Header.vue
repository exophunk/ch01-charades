<template>
    <div class="header">
        <h1 class="header__game-name">{{ room.name }}</h1>
        <div class="header__cycle">{{ cycle }}</div>
    </div>
</template>

<script>

    import { mapState } from 'vuex';


    export default {
        computed: {
            ...mapState(['room']),

            cycle() {
                return this.room.cycle > 0 ? `Runde ${this.room.cycle}` : 'Vorbereitung';
            },
        },
    }
</script>

<style lang="scss" scoped>
    .header {
        width: 100%;
        padding: 15px;
    }

    .header__game-name {
        @include typo-heading;
        color: var(--color-current-team);
    }

    .header__cycle {
        @include typo-small;
        margin-top: 3px;
    }
</style>
