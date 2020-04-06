<template>
    <div class="user" :class="classes">
        {{ user.id }} - {{ user.name }} - ({{ user.team_user.score }}) {{ isCurrentUser ? '<==' : '' }}
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

<style lang="scss">
    .user--is-current {
        color: red;
    }
</style>
