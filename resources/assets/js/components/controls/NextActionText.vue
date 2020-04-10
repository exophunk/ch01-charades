<template>
    <div v-if="isVisible" class="next-action-text">
        <span class="next-action-text__kicker">{{ kicker }}</span>
        <h2 class="next-action-text__text" v-html="text"></h2>
    </div>
</template>

<script>

    import { mapGetters, mapState } from 'vuex';

    export default {
        computed: {
            ...mapState(['isRoundActive']),
            ...mapGetters(['cycle', 'currentUser', 'isThisUsersTurn', 'isThisUsersTeamTurn']),

            isVisible() {
                return this.cycle > 0 && !(this.isThisUsersTurn && this.isRoundActive);
            },

            text() {
                if (this.isThisUsersTurn) {
                    return 'Du bist dran mit <span class="highlight">erklären</span>';
                } else if (this.isRoundActive) {
                    return `<span class="highlight">${this.currentUser.name}</span> ist am erklären`;
                } else {
                    return `<span class="highlight">${this.currentUser.name}</span> ist an der Reihe`;
                }
            },

            kicker() {
                if (this.isThisUsersTurn) {
                    return 'Dein Team ist am Zug';
                } else if (this.isThisUsersTeamTurn) {
                    return 'Dein Team ist am Zug';
                } else {
                    return 'Das Gegner-Team ist am Zug';
                }

            },
        },

    }
</script>

<style lang="scss" scoped>
    .next-action-text {

    }


    .next-action-text { }
    .next-action-text__kicker {
        @include typo-small;
        color: $color-grey;

    }
    .next-action-text__text {
        @include typo-next-action-text;
    }

    ::v-deep .highlight {
        color: var(--color-current-team);
        font-weight: 900;
    }
</style>
