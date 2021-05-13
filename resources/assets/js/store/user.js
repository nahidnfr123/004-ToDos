window.axios = require('axios');

function generateErrors({commit, dispatch}, error, err, msg = "Error! ", showSnackBar = false) {
    if (error.response) {
        if (error.response.status == 422) {
            err = error.response.data.errors;
        } else if (error.response.status == 403) {
            err = error.response.data.message
        } else if (error.response.status == 500) {
            err = error.response.data.message;
            dispatch('snackbar/addSnack', {color: 'red-500', msg: 'Backend server error!'}, {root: true});
        } else if (error.response.status == 419) {
            err = error.response.data.message;
            dispatch('snackbar/addSnack', {color: 'red-500', msg: err}, {root: true});
        } else {
            err = msg + error;
        }
        commit('SET_ERROR', err);
        if (showSnackBar === true && error.response.status != 419) {
            dispatch('snackbar/addSnack', {color: 'red-500', msg: err}, {root: true});
        }
    } else {
        dispatch('snackbar/addSnack', {color: 'red-500', msg: error}, {root: true});
    }
}

export default {
    namespaced: true,
    state: {
        user: null,
        error: null,
    },
    getters: {
        user(state) {
            return state.user;
        },
    },
    mutations: {
        SET_USER(state, value) {
            return state.user = value;
        },
        SET_ERROR(state, value) {
            return state.error = value
        },
        SET_ERROR_TO_NULL(state, value) {
            return state.error = value
        }
    },
    actions: {
        clearError({commit}) {
            commit('SET_ERROR_TO_NULL', null)
        },
        setUser({dispatch, commit}, user) {
            commit('SET_USER', user)
        },
        updateUserData() {

        },
        async updateUserPassword({commit, dispatch}, credentials) {
            let err = null;
            await axios.put('/user/password', credentials)
                .then(() => {
                    dispatch('snackbar/addSnack', {color: 'green-500', msg: 'Password updated successfully.'}, {root: true});
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error updating password!", false);
                });
        }
    }
}
