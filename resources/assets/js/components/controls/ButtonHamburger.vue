<template>
    <div class="button-hamburger" :class="classes" @click="toggleNavigation">
        <div class="button-hamburger__dash"></div>
        <div class="button-hamburger__dash"></div>
        <div class="button-hamburger__dash"></div>
    </div>
</template>

<script>

    import { mapState } from 'vuex';

    export default {

        computed: {
            ...mapState(['isNavigationOpen']),

            classes() {
                return {
                    'button-hamburger--is-navigation-open': this.isNavigationOpen,
                };
            },
        },

        methods: {
            toggleNavigation() {
                this.$store.commit('setIsNavigationOpen', !this.$store.state.isNavigationOpen);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .button-hamburger {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 95;
        cursor: pointer;
    }

    .button-hamburger__dash {
        width: 20px;
        height: 2px;
        background: $color-grey;
        transition: all 0.3s ease;
    }

    .button-hamburger__dash + .button-hamburger__dash {
        margin-top: 4px;
    }

    .button-hamburger--is-navigation-open {
        .button-hamburger__dash:nth-child(2) {
            opacity: 0;
        }

        .button-hamburger__dash:first-child {
            transform: translateY(6px) rotate(45deg);
        }

        .button-hamburger__dash:last-child {
            transform: translateY(-6px) rotate(-45deg);
        }
    }

</style>
