<template>
    <button
        v-if="isAdmin && user.id !== $store.state.user.id"
        @click="kickUser"
        class="button button-kick-user"
    >
        {{ 'X' }}
    </button>
</template>

<script>

    import { mapGetters } from 'vuex';

    export default {

        props: {
            user: {
                type: Object,
                required: true,
            },
        },

        computed: {
            ...mapGetters(['isAdmin', 'cycle']),
        },

        methods: {
            kickUser() {
                this.$store.dispatch('kickUser', this.user);
            },
        },
    }
</script>

<style lang="scss" scoped>

    .button-kick-user {
        display: none;
    }
</style>
