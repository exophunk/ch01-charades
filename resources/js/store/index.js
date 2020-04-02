import Vuex from 'vuex';
import axios from 'axios';

const store = new Vuex.Store({
    state: {
        user: null,
        room: null,
    },

    mutations: {
        setUser(state, payload) {
            state.user = payload;
        },
        setRoom(state, payload) {
            state.room = payload;
        },
    },

    actions: {
        async addNewWord({ commit, state }, word) {
            await axios.post('/actions/game/create-word', {
                word,
                room_id: state.room.id,
            });
        },
        async goToNextCycle({ commit, state }) {
            await axios.post('/actions/game/go-to-next-cycle', {
                room_id: state.room.id,
            });
        },
        async startRound({ commit, state }) {
            await axios.post('/actions/game/start-round', {
                room_id: state.room.id,
            });
        },
    },

    getters: {
        teams(state) {
            return state.room.teams;
        },
        cycle(state) {
            return state.room.cycle;
        },
        words(state) {
            return state.room.words;
        },
    },
});

export default store;
