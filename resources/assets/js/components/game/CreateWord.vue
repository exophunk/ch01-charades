<template>
    <div v-if="cycle == 0" class="create-word">
        <input id="word" name="word" placeholder="Füge Wörter hinzu..." type="text" v-model="word" @keyup.enter="createWord" maxlength="30">
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
        position: relative;
        transform: translateY(-50%);

    }

    input {
        width: calc(100% - 2 * 15px);
        margin-left: 15px;
        padding: 0 85px 0 15px;
        height: 80px;
        font-family: $font-word;
        font-size: 18px;
        line-height: 1em;
        border-radius: 45px;
        border: 1px solid #eee;
        box-shadow: 2px 2px 5px rgba(black, 0.3) inset;
    }

    button {
        position: absolute;
        right: 25px;
        top: 50%;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        text-transform: uppercase;
        transform: translateY(-50%);
        background: black;
        color: white;
        transition: all 0.3s ease;

        &[disabled] {
            background: #ddd;
            color: #999;
        }
    }
</style>
