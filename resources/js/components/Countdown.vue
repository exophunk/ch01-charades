<template>
    <div v-if="latestRound && isRoundActive" class="countdown">
        <div class="countdown__bar">
            {{ text }}
        </div>
    </div>
</template>

<script>

    import { mapState, mapGetters } from 'vuex';
    import differenceInSeconds from 'date-fns/differenceInSeconds';
    import addSeconds from 'date-fns/addSeconds';
    import format from 'date-fns/format';

    export default {
        data() {
            return {
                seconds: 0,
                percentage: 0,
                text: '',
            };
        },

        computed: {
            ...mapState(['room', 'isRoundActive']),
            ...mapGetters(['latestRound']),
        },

        mounted() {
            this.$options.interval = setInterval(this.loop, 200);
        },

        methods: {
            loop() {
                if (this.latestRound) {
                    this.seconds = differenceInSeconds(new Date(this.latestRound.round_end), new Date());
                    this.percentage = 1 / this.room.round_duration * this.seconds;
                    this.text = format(addSeconds(new Date(0), this.seconds), 'mm:ss');
                }
            }
        },

        beforeDestroy() {
            clearInterval(this.$options.interval);
        }
    }
</script>
