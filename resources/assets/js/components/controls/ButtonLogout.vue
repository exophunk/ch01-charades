<template>
    <button
        @click="logout"
        class="button button-logout"
    >
        {{ 'Logout' }}
    </button>
</template>

<script>
    export default {
        methods: {
            logout() {
                this.$store.commit('setIsNavigationOpen', false);
                this.$store.dispatch('logout');
            },
        },
    }
</script>
