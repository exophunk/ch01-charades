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
            randomX: {
                type: Number,
                required: true,
            },
            randomY: {
                type: Number,
                required: true,
            },
            randomRotation: {
                type: Number,
                required: true,
            },
            isDrawn: {
                type: Boolean,
                default: false,
            },
        },

        data() {
            return {
                posX: 0,
                posY: 0,
                rotation: 0,
            };
        },

        computed: {
            style() {
                return {
                    transform:
                        `
                        translateX(-50%)
                        translateY(-50%)
                        rotateX(180deg)
                        translateX(${this.posX}px)
                        translateY(-${this.posY}px)
                        rotate(${this.rotation * 60 - 30}deg)
                        scale(0.5)
                        `
                };
            },
            classes() {
                return {
                    'word--is-drawn': this.isDrawn,
                    'word--is-just-solved': this.word.isJustSolved,
                };
            },
        },

        mounted() {
            this.setWordPositions();

            this.$options.resizeListener = () => {
                this.setWordPositions();
            };

            window.addEventListener('resize', this.$options.resizeListener);
        },

        methods: {
            setWordPositions() {
                this.posX = Math.min(Math.max(this.randomX * this.$parent.$el.clientWidth, this.$el.clientWidth / 4), this.$parent.$el.clientWidth - this.$el.clientWidth / 4);
                this.posY = Math.min(Math.max(this.randomY * this.$parent.$el.clientHeight, this.$el.clientHeight / 4), this.$parent.$el.clientHeight - this.$el.clientHeight / 4);
                this.rotation = this.randomRotation;
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
        background: white;
        padding: 5vw;
        box-shadow: 5px 5px 7px rgba(black, 0.2);
        width: 280px;
        height: 140px;
        border-radius: 5px;
        transition: all 0.5s ease, transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
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

    .word--is-drawn {
        transform: translateX(calc(50vw - 50%)) translateY(calc(30vw - 50%)) rotate(0) rotateX(0deg) scale(1) !important;
        z-index: 1;

        @include mq($from: tablet) {
            transform: translateX(calc(25vw - 50%)) translateY(calc(15vw - 50%)) rotate(0) rotateX(0deg) scale(1) !important;
        }
    }

    .word--is-just-solved {
        transform: translateX(calc(50vw - 50%)) translateY(calc(30vw - 50%)) rotate(-30deg) rotateX(0deg) scale(2) !important;
        background: rgb(119, 212, 119);
        color: white;
        opacity: 0;

        @include mq($from: tablet) {
            transform: translateX(calc(25vw - 50%)) translateY(calc(15vw - 50%)) rotate(-30deg) rotateX(0deg) scale(2) !important;
        }
    }
</style>
