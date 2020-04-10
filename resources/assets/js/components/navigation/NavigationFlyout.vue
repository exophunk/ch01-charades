<template>
    <transition name="navigation">
        <div v-show="isNavigationOpen" class="navigation-flyout" :class="classes">
            <ul class="navigation-group">
                <li class="navigation-group__item"><ButtonLeaveRoom /></li>
                <li class="navigation-group__item"><ButtonLogout /></li>
                <li class="navigation-group__item"><ButtonProfile /></li>
            </ul>

            <ul v-if="isAdmin" class="navigation-group">
                <li class="navigation-group__item"><ButtonResetGame /></li>
                <li class="navigation-group__item"><ButtonResetCycle /></li>
                <li class="navigation-group__item"><ButtonClearWords /></li>
            </ul>
        </div>
    </transition>
</template>

<script>

    import { mapGetters, mapState } from 'vuex';

    import ButtonLeaveRoom from '../controls/ButtonLeaveRoom';
    import ButtonLogout from '../controls/ButtonLogout';
    import ButtonProfile from '../controls/ButtonProfile';
    import ButtonClearWords from '../admin-controls/ButtonClearWords';
    import ButtonResetCycle from '../admin-controls/ButtonResetCycle';
    import ButtonResetGame from '../admin-controls/ButtonResetGame';

    export default {

        components: {
            ButtonLeaveRoom,
            ButtonLogout,
            ButtonProfile,
            ButtonClearWords,
            ButtonResetCycle,
            ButtonResetGame,
        },

        computed: {
            ...mapState(['isNavigationOpen']),
            ...mapGetters(['isAdmin']),

            classes() {
                return {
                    'navigation-flyout--is-admin': this.isAdmin,
                };
            },
        },
    }
</script>

<style lang="scss" scoped>
    .navigation-flyout {
        @include typo-navigation;
        position: fixed;
        right: 0;
        top: 0;
        width: 250px;
        height: 200px;
        padding-right: 17px;
        padding-top: 50px;
        z-index: 90;
        color: $color-text;

        &:after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            width: 400px;
            height: 400px;
            transform: translateX(50%) translateY(-50%);
            border-radius: 50%;
            background: $color-white;
            z-index: -1;
            transform-origin: center center;
        }

        &.navigation-flyout--is-admin {
            width: 400px;
            height: 400px;
            &:after {
                width: 800px;
                height: 800px;
            }
        }
    }


    .navigation-group {
        text-align: right;
        & + & {
            margin-top: 40px;
        }
    }

    .navigation-group__item {
        & + & {
            margin-top: 20px;
        }
    }

</style>
