<template>
    <div class="teams">
        <div
            class="team"
            v-for="team in teams"
            :key="team.id"
        >
            <h3>{{ team.name }}</h3>

            <ul class="team__members">
                <li
                    v-for="user in team.users"
                    :key="user.id"
                    class="team__members"
                >
                    {{ user.id }} - {{ user.name }}
                    ({{ user.pivot.score }})
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

    export default {

        computed: {
            ...mapGetters(['teams']),
        },

        mounted() {

        }

    }
</script>
