import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import NotFound from './views/404';
import Register from './views/auth/Register';
import Login from './views/auth/Login.vue';
import ForgotPassword from "./views/auth/ForgotPassword";
import ResetPassword from "./views/auth/ResetPassword";
import SocialLogin from './views/auth/SocialLogin';
import EmailVerification from './views/auth/EmailVerification';
import Home from './views/Home';
import Profile from './views/Profile';
import Todo from './views/todos/Todo';
import TodoItem from './views/todos/TodoItem';
import example_component from './views/partials/examples/Examples_NRF_InputTemplate';

import store from './store/index';

function requireAuthenticated(to, from, next) {
    const authenticated = store.getters["auth/authenticated"];
    const user = store.getters["auth/user"];

    if (to.name !== 'Login' && !authenticated || !user) next({path: '/login'})
    else {
        next();
    }
}

function requireEmailVerified(to, from, next) {
    const authenticated = store.getters["auth/authenticated"];
    const user = store.getters["auth/user"];

    if (to.name !== 'Login' && !authenticated || !user) next({path: '/login'})
    else {
        if (user.email_verified_at != null) {
            next();
        } else {
            next({name: "EmailVerification"});
        }
    }
}

function preventAuthenticated(to, from, next) {
    const authenticated = store.getters["auth/authenticated"];
    const user = store.getters["auth/user"];
    if (authenticated && user) {
        next({
            path: '/',
        })
    } else {
        next()
    }
}

const routes = [
    {
        path: '/register', name: 'Register', component: Register,
        beforeEnter: preventAuthenticated
    },
    {
        path: '/login', name: 'Login', component: Login,
        beforeEnter: preventAuthenticated
    },
    {
        path: '/forgot-password', name: 'ForgotPassword', component: ForgotPassword, beforeEnter: preventAuthenticated
    },
    {
        path: '/reset-password/:token', name: 'ResetPassword', component: ResetPassword, beforeEnter: preventAuthenticated
    },
    {
        path: '/social-login/callback/:provider', name: 'SocialLogin', component: SocialLogin,
        beforeEnter: preventAuthenticated
    },
    {
        path: '/email/verify', name: 'EmailVerification', component: EmailVerification,
        beforeEnter: requireAuthenticated
    },
    {
        path: '/profile/:username', name: 'Profile', component: Profile,
        beforeEnter: requireEmailVerified
    },
    {
        path: '/', name: 'Home', component: Home,
        beforeEnter: requireEmailVerified
    },
    {
        path: '/todos', name: 'Todo List',
        //component: Todo,
        component: () => import(/*webpackChunkName: "Todos"*/ "./views/todos/Todo"), // Lazy loading
        beforeEnter: requireEmailVerified
    },
    {
        path: '/todo-tasks/:date', name: 'Todo Task',
        //component: TodoItem,
        component: () => import(/*webpackChunkName: "TodoItem"*/'./views/todos/TodoItem'), // Lazy loading
        props: true,
        beforeEnter: requireEmailVerified
    },
    {
        path: '/example_component', name: 'Example Component',
        //component: example_component,
        component: () => import(/*webpackChunkName: "ExampleComponent"*/'./views/partials/examples/Examples_NRF_InputTemplate'), // Lazy loading
        beforeEnter: requireAuthenticated,
        // meta: { authOnly: true } // Another way to check authenticated user ...
    },
    {
        path: '*', name: 'page_not_found', component: NotFound
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.MIX_BASE_URL,
    routes
})

router.beforeEach((to, from, next) => {
    document.title = `${process.env.MIX_APP_NAME} - ${to.name}`;
    window.scrollTo(0, 0);
    next()
});

/*function isLoggedIn() {
    return localStorage.getItem("auth");
}
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.authOnly)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!isLoggedIn()) {
            next({
                path: "/login",
                query: { redirect: to.fullPath }
            });
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.guestOnly)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (isLoggedIn()) {
            next({
                path: "/dashboard",
                query: { redirect: to.fullPath }
            });
        } else {
            next();
        }
    } else {
        next(); // make sure to always call next()!
    }
});*/


export default router


