<template>
    <div class="teams">

        <div class="team__names">
            <h3
                v-for="team in teams"
                :key="`name-${team.id}`"
                class="team__name"
            >
                {{ team.name }}
            </h3>
        </div>

        <div class="team__teams">
            <ul
                v-for="team in teams"
                :key="`users-${team.id}`"
                class="team__team"
            >
                <li
                    v-for="user in team.users"
                    :key="user.id"
                    class="team__user"
                >
                    <User :user="user" />
                </li>
            </ul>
        </div>

        <div class="team__scores">
            <div
                v-for="team in teams"
                :key="`score-${team.id}`"
                class="team__score"
            >
                <div class="team__score-fives"
                    v-for="i in (Math.floor(team.score / 5))"
                    :key="`fives-${i}`"
                >
                    <div class="score-dash"></div>
                    <div class="score-dash"></div>
                    <div class="score-dash"></div>
                    <div class="score-dash"></div>
                    <div class="score-dash score-dash--over"></div>
                </div>

                <div class="team__score-ones"
                    v-for="i in (team.score - 5 * Math.floor(team.score / 5))"
                    :key="`ones-${i}`"
                >
                    <div class="score-dash"></div>
                </div>

                <div class="team__score-number">
                    {{ team.score }}
                </div>
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

<style lang="scss" scoped>
    .teams {
        @include mq($from: tablet) {
            width: 40%;
            padding: 0 20px;
        }
        @include mq($from: desktop) {
            width: 30%;
        }
    }

    .team__names,
    .team__teams,
    .team__scores {
        display: flex;
    }

    .team__name {
        width: 50%;
        margin: 0 10px;
        font-size: 12px;
        line-height: 1em;
        font-weight: bold;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .team__team {
        width: 50%;
        margin: 0 10px;
        margin-top: 10px;
    }

    .team__score {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        width: 50%;
        margin: 10px 10px;
        margin-left: 13px;
        padding-right: 30px;

        .team__score-fives {
            display: flex;
            margin-right: 5px;

            &:nth-child(2n) {
                transform: rotate(7deg);
            }
        }
        .score-dash {
            width: 2px;
            height: 12px;
            background: #666;
            border-radius: 5px;
            margin-right: 2px;

            &:nth-child(2n) {
                transform: rotate(-3deg);
            }
        }
        .score-dash--over {
            width: 2px;
            height: 18px;
            background: #666;
            transform: translateX(-10px) translateY(-4px) rotate(-70deg);
        }
        .team__score-number {
            // position: absolute;
            // right: 0;
            // bottom: 0;
            margin-left: 5px;
            font-size: 12px;
            line-height: 1em;
            font-weight: bold;
            color: green;
        }
    }

</style>
