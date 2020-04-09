<template>
    <div class="user" :class="classes">
        <div class="user__avatar">{{ user.name.substr(0, 1).toUpperCase() }}</div>
        <span class="user__name">{{ user.name }} </span>
        <span class="user__score">{{ user.team_user.score }}</span>
        <KickUser :user="user" />
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
    .user__avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 5px;
        border: 2px solid white;
        font-weight: bold;
        font-size: 9px;
        color: white;
        background: #4a4a4a;
    }
    .user__name { }

    .user__score {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 15px;
        height: 15px;
        margin-left: 5px;
        border-radius: 50%;
        background: #eee;
        color: #777;
        font-size: 9px;
        font-weight: bold;

    }

    .user--is-current {
        .user__avatar {
            border-color: $color-active;
            animation: shadow-pulse 1s infinite;
        }
    }

    @keyframes shadow-pulse {
        0% {
            box-shadow: 0 0 0 0px rgba($color-active, 0.2);
        }
        100% {
            box-shadow: 0 0 0 15px rgba($color-active, 0);
        }
    }
</style>
