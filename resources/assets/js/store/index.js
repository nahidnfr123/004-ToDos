import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import auth from './auth';
import todo from './todo';
import user_state from './user';
import task from './task';

// Importing snackbar components ...
import snackbar from '../CustomComponents/Snackbar/snackbar';

export default new Vuex.Store({
    strict: true,
    modules: {
        auth,
        user_state,
        todo,
        snackbar,
    }
});
