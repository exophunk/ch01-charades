<template>
    <div :class="classes" class="countdown">
        <transition name="fade">
            <div v-if="latestRound && isRoundActive">
                <div
                    :style="barStyle"
                    class="countdown__bar"
                >
                </div>
                <div
                    v-if="latestRound && isRoundActive"
                    class="countdown__text"
                >
                    {{ text }}
                </div>
            </div>
        </transition>
    </div>
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
                percentage: 100,
                text: '',
            };
        },

        computed: {
            ...mapState(['room', 'isRoundActive']),
            ...mapGetters(['latestRound']),

            classes() {
                return {
                    'countdown--low': this.seconds < 10,
                };
            },

            barStyle() {
                return {
                    transform: `scaleX(${this.percentage}%)`,
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
                    this.percentage = 100 / (this.room.round_duration * 1000) * this.milliSeconds;
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
        width: 100%;
        height: 30px;
    }

    .countdown__bar {
        position: absolute;
        height: 100%;
        width: 100%;
        background: $color-active;
        transform-origin: left center;
        // transition: transform 1s linear;
    }

    .countdown__text {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
        font-size: 16px;
        font-weight: bold;
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
