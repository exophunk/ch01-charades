import Vuex from 'vuex';
import axios from 'axios';

const store = new Vuex.Store({
    state: {
        user: null,
        room: null,
    },

    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        setRoom(state, room) {
            state.room = room;
        },
        setCycle(state, cycle) {
            state.room.cycle = cycle;
        },
        addRound(state, round) {
            state.room.rounds.push(round);
        },
        createWord(state, word) {
            state.room.words.push(word);
        },
    },

    actions: {
        async createWord({ commit, state }, word) {
            await axios.post('/actions/game/create-word', {
                word,
                room_id: state.room.id,
            });
        },
        async startCycle({ commit, state }) {
            await axios.post('/actions/game/start-cycle', {
                room_id: state.room.id,
            });
        },
        async resetCycle({ commit, state }) {
            await axios.post('/actions/game/reset-cycle', {
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
        rounds(state) {
            return state.room.rounds;
        },
    },
});

export default store;
