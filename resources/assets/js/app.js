require('./bootstrap');

import Vue from 'vue';
window.Vue = require('vue');

import App from './Layouts/App.vue';
import router from './routes';
import store from './store/index';


Vue.config.productionTip = false;

// Filters ...
require('./filters');
// Day js ...
require('./day');
//Setup custom events
require('./customEvents');
//Import progressbar
require('./progressbar');



//Import v-from
/*import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);*/

// Register Components ...
import GlobalComponents from './globalComponents'
Vue.use(GlobalComponents)


// Load data when main component loads ....
store.dispatch('auth/me').then(() => {
    new Vue({
        router,
        store,
        render: h => h(App)
    }).$mount('#app')
});






/*const app = new Vue({
    router,
    store,
    render: h => h(App),
}).$mount('#app');*/
// When page is reloaded redirects to login page ... even when user is logged in ...




