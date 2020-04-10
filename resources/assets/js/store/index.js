import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

const store = new Vuex.Store({
    state: {
        user: null,
        room: null,
        isRoundActive: false,
        drawnWord: null,
        isNavigationOpen: false,
    },

    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        setRoom(state, room) {
            state.room = room;
        },
        setTeams(state, teams) {
            state.room.teams = teams;
        },
        setWords(state, words) {
            state.room.words = words;
        },
        setCycle(state, cycle) {
            state.room.cycle = cycle;
        },
        addRound(state, round) {
            state.room.rounds.unshift(round);
        },
        createWord(state, word) {
            state.room.words.push(word);
        },
        setIsRoundActive(state, isRoundActive) {
            state.isRoundActive = isRoundActive;
        },
        setNextTurn(state, nextTurn) {
            state.room.next_turn = nextTurn;
        },
        setDrawnWord(state, drawnWord) {
            state.drawnWord = drawnWord;
        },
        setIsNavigationOpen(state, isNavigationOpen) {
            state.isNavigationOpen = isNavigationOpen;
        },

    },

    actions: {
        async createWord({ commit, state }, word) {
            return await axios.post('/actions/game/create-word', {
                word,
                room_id: state.room.id,
            });
        },
        async startGame({ commit, state }) {
            return await axios.post('/actions/game/start-game', {
                room_id: state.room.id,
            });
        },
        async resetGame({ commit, state }) {
            return await axios.post('/actions/game/reset-game', {
                room_id: state.room.id,
            });
        },
        async resetCycle({ commit, state }) {
            return await axios.post('/actions/game/reset-cycle', {
                room_id: state.room.id,
            });
        },
        async startRound({ commit, state }) {
            return await axios.post('/actions/game/start-round', {
                room_id: state.room.id,
            });
        },
        async clearWords({ commit, state }) {
            return await axios.post('/actions/game/clear-words', {
                room_id: state.room.id,
            });
        },
        async solveWord({ commit, state, getters }) {
            return await axios.post('/actions/game/solve-word', {
                word_id: state.drawnWord.id,
                room_id: state.room.id,
                round_id: getters.latestRound.id,
            });
        },
        async leaveRoom({ commit, state }) {
            await axios.post('/actions/room/leave-room', {
                room_id: state.room.id,
            });
            window.location.href = '/';
        },
        async switchTeam({ commit, state }) {
            await axios.post('/actions/room/switch-team', {
                room_id: state.room.id,
                user_id: state.user.id,
            });
        },
        async kickUser({ commit, state }, user) {
            await axios.post('/actions/room/kick-user', {
                room_id: state.room.id,
                user_id: user.id,
            });
        },
        async logout({ commit, state }, user) {
            await axios.post('/logout');
            window.location.href = '/';

        },
        chooseRandomWord({ commit, state, getters }) {
            const otherWords = getters.unsolvedWords.length > 1 ? getters.unsolvedWords.filter(word => word !== state.drawnWord) : getters.unsolvedWords;
            const randomWord = otherWords[Math.floor(Math.random() * otherWords.length)];
            commit('setDrawnWord', randomWord);
        },
    },

    getters: {
        userTeam(state) {
            return state.room.teams.find(team => team.users.some(user => user.id === state.user.id));
        },
        teams(state) {
            return state.room.teams;
        },
        allUsers(state) {
            return state.room.teams.map(team => team.users).flat();
        },
        cycle(state) {
            return state.room.cycle;
        },
        words(state) {
            return state.room.words;
        },
        solvedWords(state) {
            return state.room.words.filter(word => word.solved);
        },
        unsolvedWords(state) {
            return state.room.words.filter(word => !word.solved);
        },
        rounds(state) {
            return state.room.rounds;
        },
        latestRound(state) {
            return state.room.rounds.length ? state.room.rounds[0] : null;
        },
        currentTeam(state, otherGetters) {
            if (!state.room.next_turn) {
                return null;
            }
            const id = otherGetters.latestRound && state.isRoundActive ? otherGetters.latestRound.team_id : state.room.next_turn.team_id;
            return state.room.teams.find(team => team.id === id);
        },
        currentTeamIndex(state, otherGetters) {
            return state.room.teams.findIndex(team => team.id === otherGetters.currentTeam.id);
        },
        currentUser(state, otherGetters) {
            if (!state.room.next_turn) {
                return null;
            }
            const id = otherGetters.latestRound && state.isRoundActive ? otherGetters.latestRound.user_id : state.room.next_turn.user_id;
            return otherGetters.allUsers.find(user => user.id === id);
        },
        isThisUsersTurn(state, otherGetters) {
            return state.user.id === otherGetters.currentUser.id;
        },
        isThisUsersTeamTurn(state, otherGetters) {
            return otherGetters.currentTeam === otherGetters.userTeam;
        },
        isAdmin(state) {
            return state.user.id === state.room.admin_user_id;
        },
    },
});

export default store;
