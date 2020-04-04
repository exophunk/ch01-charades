<template>
    <div class="teams">
        <div
            class="team"
            v-for="team in teams"
            :key="team.id"
        >
            <h3 class="team__name">{{ team.name }}</h3>

            <ul class="team__members">
                <li
                    v-for="user in team.users"
                    :key="user.id"
                    class="team__member"
                >
                    <User :user="user" />
                </li>
            </ul>

            <div class="team__score">
                {{ team.score }}
            </div>
        </div>
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';
    import User from './User';

    export default {

        components: {
            User,
        },

        computed: {

            ...mapGetters(['teams', 'latestRound', 'currentPlayer']),

            isActiveTurn() {
                return this.latestRound != null && this.$store.state.isRoundActive && this.user.id === this.latestRound.user_id;
            },

            classes() {
                return {
                    'user--is-active-turn': this.isActiveTurn,
                };
            },
        }

    }
</script>
