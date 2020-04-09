<template>
    <div class="user" :class="classes">
        <div class="user__avatar">{{ user.team_user.score }}</div>
        <span class="user__name">{{ user.name }}</span>
        <!-- <KickUser :user="user" /> -->
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';
    import KickUser from '../admin-controls/ButtonKickUser';

    export default {

        components: {
            KickUser,
        },

        props: {
            user: {
                type: Object,
                required: true,
            },
        },

        computed: {

            ...mapGetters(['latestRound', 'currentUser']),

            isCurrentUser() {
                return this.user.id === this.currentUser.id
            },

            classes() {
                return {
                    'user--is-current': this.isCurrentUser,
                };
            },
        }

    }
</script>

<style lang="scss" scoped>

    .user {
        display: flex;
        align-items: center;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 3px;
        line-height: 1em;
        white-space: nowrap;

    }

    .team-1 .user { color: var(--color-team-1-contrast); }
    .team-1 .user__avatar { border: 2px solid var(--color-team-1-contrast); }
    .team-1 .user--is-current .user__avatar {background: var(--color-team-1-contrast); color: var(--color-team-1-anticontrast); }
    .team-1 .user--is-current .user__avatar {background: var(--color-team-1-contrast); color: var(--color-team-1-anticontrast); }

    .team-2 .user { color: var(--color-team-2-contrast); }
    .team-2 .user__avatar { border: 2px solid var(--color-team-2-contrast); }
    .team-2 .user--is-current .user__avatar {background: var(--color-team-2-contrast); color: var(--color-team-2-anticontrast); }

    .user__avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        margin-right: 5px;
        font-weight: 900;
    }

    .user__name {
        @include typo-small;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user--is-current {
        .user__avatar {
            animation: shadow-pulse 1s infinite;
        }
    }

    @keyframes shadow-pulse {
        0% {
            box-shadow: 0 0 0 0px var(--color-current-team-pulse);
        }
        100% {
            box-shadow: 0 0 0 15px var(--color-current-team-pulse-end);
        }
    }
</style>
