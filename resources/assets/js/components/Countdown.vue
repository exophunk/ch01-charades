<template>
    <transition name="fade">
        <div :class="classes" class="countdown">
            <div v-if="isContainerVisible" class="countdown__inner">
                <transition name="fade">
                    <div
                        v-if="isCountdownVisible"
                        :style="barStyle"
                        class="countdown__bar"
                    >
                    </div>
                </transition>
                <transition name="fade">
                    <div
                        v-if="isCountdownVisible"
                        class="countdown__text"
                    >
                        {{ text }}
                    </div>
                </transition>
            </div>
        </div>
    </transition>
</template>

<script>

    import { mapState, mapGetters } from 'vuex';
    import differenceInMilliseconds from 'date-fns/differenceInMilliseconds';
    import differenceInSeconds from 'date-fns/differenceInSeconds';
    import addSeconds from 'date-fns/addSeconds';
    import format from 'date-fns/format';

    export default {
        data() {
            return {
                milliSeconds: 0,
                seconds: 0,
                barScale: 1,
                text: '',
            };
        },

        computed: {
            ...mapState(['room', 'isRoundActive']),
            ...mapGetters(['cycle', 'latestRound']),

            isContainerVisible() {
                return this.cycle > 0;
            },

            isCountdownVisible() {
                return this.isRoundActive;
            },

            classes() {
                return {
                    'countdown--low': this.seconds < 10 && this.isCountdownVisible,
                };
            },

            barStyle() {
                return {
                    transform: `scaleX(${this.barScale})`,
                };
            },
        },

        mounted() {
            this.$options.interval = setInterval(this.loop, 100);
        },

        methods: {
            loop() {
                if (this.latestRound) {
                    this.milliSeconds = differenceInMilliseconds(new Date(this.latestRound.round_end), new Date());
                    this.seconds = Math.round(this.milliSeconds / 1000);
                    this.barScale = 1 / (this.room.round_duration * 1000) * this.milliSeconds;
                    this.text = format(addSeconds(new Date(0), this.seconds), 'mm:ss');
                }
            }
        },

        beforeDestroy() {
            clearInterval(this.$options.interval);
        }
    }
</script>

<style lang="scss" scoped>
    .countdown {
        position: relative;
        height: 23px;
    }

    .countdown__inner {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(182deg, $color-grey-light 10%, $color-grey-dark 140%);
        overflow: hidden;
        margin-bottom: 15px;

        &:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 150%;
            height: 100%;
            transform: translateX(-25%);
            box-shadow: 4px 4px 4px rgba(black, 0.2) inset;
        }
    }

    .countdown__bar {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transform-origin: left center;
        background: linear-gradient(183deg, var(--color-current-team-light) 10%, var(--color-current-team-dark) 100%);
    }

    .countdown__text {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
        line-height: 1em;
        color: var(--color-current-team-contrast);
    }

    .countdown--low {
        .countdown__text {
            animation: shadow-pulse 0.6s infinite;
            animation-direction: alternate;
        }
    }

    @keyframes shadow-pulse {
        0% {
            transform: translateX(-50%) translateY(-50%) scale(1.3);
            color: $color-active;
        }
        100% {
            transform: translateX(-50%) translateY(-50%) scale(1);
            color: $color-text;
        }
    }
</style>
