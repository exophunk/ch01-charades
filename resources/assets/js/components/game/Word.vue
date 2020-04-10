<template>
    <div class="word" :style="style" :class="classes">
        {{ word.word }}
    </div>
</template>

<script>

    import axios from 'axios';
    import { mapGetters, mapState } from 'vuex';
    import Word from './Word';

    export default {

        props: {
            word: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                randomX: 0,
                randomY: 0,
                randomRotation: 0,
                posX: 0,
                posY: 0,
                rotation: 0,
                centerX: 0,
                centerY: 0,
                isPositioned: false,
            };
        },

        computed: {
            ...mapState(['isRoundActive', 'drawnWord']),
            ...mapGetters(['isThisUsersTurn']),

            isDrawn() {
                return this.isRoundActive && this.isThisUsersTurn && this.word === this.drawnWord;
            },

            style() {
                return this.isDrawn ? {
                    transform:
                        `
                        translateX(calc(${this.centerX}px - 50%))
                        translateY(calc(${this.centerY}px - 50%))
                        rotateX(0)
                        scale(1)
                        `
                } : {
                    transform:
                        `
                        translateX(-50%)
                        translateY(-50%)
                        rotateX(180deg)
                        translateX(${this.posX}px)
                        translateY(-${this.posY}px)
                        rotate(${this.rotation * 60 - 30}deg)
                        scale(0.25)
                        `
                };
            },
            classes() {
                return {
                    'word--is-drawn': this.isDrawn,
                    'word--is-positioned': this.isPositioned,
                };
            },
        },

        mounted() {
            this.randomX = Math.random();
            this.randomY = Math.random();
            this.randomRotation = Math.random();

            this.$options.resizeListener = () => {
                this.setWordPositions();
            };

            window.addEventListener('resize', this.$options.resizeListener);

            setTimeout(() => {
                this.setWordPositions();
                setTimeout(() => {
                    this.isPositioned = true;
                }, 50);
            }, 50);

        },

        methods: {
            setWordPositions() {
                this.posX = Math.min(Math.max(this.randomX * this.$parent.$el.clientWidth, this.$el.clientWidth / 4), this.$parent.$el.clientWidth - this.$el.clientWidth / 4);
                this.posY = Math.min(Math.max(this.randomY * this.$parent.$el.clientHeight, this.$el.clientHeight / 4), this.$parent.$el.clientHeight - this.$el.clientHeight / 4);
                this.rotation = this.randomRotation;
                this.centerX = this.$parent.$el.clientWidth / 2;
                this.centerY = this.$parent.$el.clientHeight / 2;
            }
        },

        beforeDestroy() {
            window.removeEventListener('resize', this.$options.resizeListener);
        }
    }
</script>

<style lang="scss" scoped>
    .word {
        @include typo-word;
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        width: 280px;
        height: 140px;
        padding: 10px;
        border-radius: 5px;
        background: $color-white;
        color: $color-grey-dark;
        box-shadow: 5px 5px 7px rgba(black, 0.2);
        transform-style: preserve-3d;
        backface-visibility: hidden;

        &:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #efefef;
            border: 1px solid #aaaaaa;
            box-shadow: 5px 5px 7px rgba(black, 0.2);
            transform: rotateX(180deg);
            transform-style: preserve-3d;
            backface-visibility: hidden;
        }
    }

    .word--is-positioned {
        transition: background 0.5s ease, transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .word--is-drawn {
        transition: background 0.5s ease, transform 0.8s 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

</style>
