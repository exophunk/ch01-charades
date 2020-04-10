<template>
    <div v-if="cycle == 0" class="create-word">
        <input id="word" name="word" placeholder="Wort hinzufügen..." type="text" v-model="word" @keyup.enter="createWord" maxlength="30">
        <button @click="createWord" :disabled="word.length <= 2">
            <span class="icon">
                <i class="fas fa-plus"></i>
            </span>
        </button>
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';

    export default {

        data() {
            return {
                word: '',
            };
        },

        computed: {
            ...mapGetters(['cycle']),
        },

        methods: {
            createWord() {
                if (this.word.length > 2) {
                    this.$store.dispatch('createWord', this.word);
                    this.word = '';
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .create-word {
        display: flex;
        align-items: center;
        margin: 0 auto;
        width: 80%;
    }

    input {
        flex-grow: 1;
        margin-right: 15px;
        height: 70px;
        font-family: $font-word;
        font-size: 20px;
        font-weight: bold;
        line-height: 1em;
        border: 0;
        border-bottom: 2px solid $color-white;
        background: none;
        color: $color-white;

        &::placeholder {
            color: $color-text-light;
        }
    }

    button {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        text-transform: uppercase;
        background: none;
        color: white;
        border: 2px solid $color-white;
        transition: all 0.3s ease;

        &[disabled] {
            opacity: 0.5;
        }
    }
</style>
