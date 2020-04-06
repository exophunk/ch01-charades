<template>
    <button
        v-if="cycle == 0"
        @click="clearWords"
        class="button button-clear-words"
    >
        {{ 'Wörter zurücksetzen' }}
    </button>
</template>

<script>

    import { mapGetters } from 'vuex';

    export default {

        computed: {
            ...mapGetters(['cycle']),
        },

        methods: {
            clearWords() {
                this.$store.dispatch('clearWords');
            },
        },
    }
</script>
