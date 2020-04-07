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
                posX: this.randomX,
                posY: this.randomY,
                rotation: this.randomRotation,
            };
        },

        computed: {
            style() {
                return {
                    transform:
                        `translateX(${this.posX * 70 - 10}vw)
                        translateY(${this.posY * 70 - 10}vw)
                        rotate(${this.rotation * 120 - 60}deg)
                        rotateX(180deg)
                        scale(0.6)`
                };
            },
            classes() {
                return {
                    'word--is-drawn': this.isDrawn,
                    'word--is-just-solved': this.word.isJustSolved,
                };
            },
        },

        methods: {

        },
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
        width: 70vw;
        height: 40vw;
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
            background: #eeeeee;
            box-shadow: 5px 5px 7px rgba(black, 0.2);
            transform: rotateX(180deg);
            transform-style: preserve-3d;
            backface-visibility: hidden;
        }
    }

    .word--is-drawn {
        transform: translateX(calc(50vw - 50%)) translateY(calc(50vw - 50%)) rotate(0) rotateX(0deg) scale(1) !important;
        z-index: 1;
    }

    .word--is-just-solved {
        transform: translateX(calc(50vw - 50%)) translateY(calc(50vw - 50%)) rotate(-30deg) rotateX(0deg) scale(2) !important;
        background: rgb(119, 212, 119);
        color: white;
        opacity: 0;
    }
</style>
