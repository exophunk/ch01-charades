<template>
    <div class="teams">

        <div
            v-for="(team, i) in teams"
            :key="`name-${team.id}`"
            class="team"
            :class="{
                [`team-${i+1}`]:  true,
                'team--is-score-big': team.score > 30
            }"
        >
            <h3 class="team__name">{{ team.name }}</h3>

            <ul class="team__team">
                <li
                    v-for="user in team.users"
                    :key="user.id"
                    class="team__user"
                >
                    <User :user="user" />
                </li>
            </ul>

            <div class="team__score">
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
        }

    }
</script>

<style lang="scss" scoped>
    .teams {
        display: flex;
    }

    .team {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        width: 50%;

        padding: 15px;
    }


    .team-1 { background: linear-gradient(185deg, var(--color-team-1-light) 10%, var(--color-team-1-dark) 100%); }
    .team-1 .team__name { color: var(--color-team-1-heading); }
    .team-1 .team__score { color: var(--color-team-1-contrast); }
    .team-1 .score-dash, .team-1 .score-dash--over, { background: var(--color-team-1-contrast); }

    .team-2 { background: linear-gradient(185deg, var(--color-team-2-light) 10%, var(--color-team-2-dark) 100%); }
    .team-2 .team__name { color: var(--color-team-2-heading); }
    .team-2 .team__score { color: var(--color-team-2-contrast); }
    .team-2 .score-dash, .team-2 .score-dash--over, { background: var(--color-team-2-contrast); }


    .team__name {
        @include typo-heading-2;
    }

    .team__team {
        margin-top: 10px;
        display: flex;
        flex-wrap: wrap;
    }

    .team__user {
        flex-shrink: 0;
        width: 50%;
    }

    .team__user {
        margin-bottom: 10px;
    }

    .team__score {
        margin-top: auto;
        margin-left: 3px;
        padding-top: 10px;
        display: flex;

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
            border-radius: 5px;
            margin-right: 2px;

            &:nth-child(2n) {
                transform: rotate(-3deg);
            }
        }

        .score-dash--over {
            width: 2px;
            height: 18px;
            transform: translateX(-10px) translateY(-4px) rotate(-70deg);
        }

        .team__score-number {
            margin-left: 5px;
            font-size: 12px;
            line-height: 1em;
            font-weight: bold;
        }
    }

    .team--is-score-big {
        .team__score-fives,
        .team__score-ones {
            display: none;
        }

        .team__score-number {
            margin-left: 0;
        }
    }


</style>
