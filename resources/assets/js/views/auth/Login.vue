<template>
    <div class="w-24 min-w-max mx-auto max-w-prose bg-gray-200 shadow-xl rounded my-10 place-content-center lg:min-w-max md:w-auto dark:bg-gray-800" style="min-width: 340px!important;">
        <h1 class="text-center text-gray-800 py-4 text-2xl mt-2 dark:text-gray-300">Login</h1>
        <div class="bg-gray-200 pt-4 pb-16 dark:bg-gray-800">
            <div class="w-4/5 mx-auto text-gray-800 dark:text-gray-300">
                <form @submit.stop.prevent="login" method="post" autofocus="autofocus">
                    <Custom_Text_Input
                        class="mb-4"
                        label="Username / Email"
                        id="username"
                        type="text"
                        placeholder="name123"
                        v-model="loginCredentials.username"
                        :error="errors.username && Array.isArray(errors.username) ? errors.username[0] : errors.username"
                        Add_Input_Class="h-10 dark:bg-gray-900"
                    />

                    <Custom_Text_Input
                        class="mb-4"
                        id="password"
                        placeholder="********"
                        v-model="loginCredentials.password"
                        label="Password"
                        type="password"
                        :error="errors.password && Array.isArray(errors.password) ? errors.password[0] : errors.password"
                        Add_Input_Class="h-10 dark:bg-gray-900"
                    />

                    <div class="mb-4">
                        <input type="checkbox" v-model="loginCredentials.remember" id="remember" name="remember" class="mr-1">
                        <label for="remember" class="text-sm text-gray-600">Remember me</label>
                    </div>

                    <div class="mb-4 text-gray-800 dark:text-gray-300 text-sm">
                        <router-link to="/forgot-password" class="text-blue-500">Forgot Password?</router-link>
                    </div>

                    <Custom_Loading_Button Add_Input_Class="mb-6 block mx-auto uppercase rounded"
                                   @button_clicked="login" :processing="processing">
                        <span>Login</span>
                    </Custom_Loading_Button>
                </form>
            </div>

            <div class="text-center text-gray-600 mb-6">Or sign in with social account</div>

            <div class="w-5/5 mx-auto flex flex-wrap justify-center mb-6 px-2">
                <button class="flex items-center bg-blue-600 shadow-md rounded px-3 py-2 mr-2 mb-2 hover:bg-blue-500"
                        @click.prevent="socialAuth('facebook')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="feather feather-facebook fill-current text-gray-100 w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                    </svg>
                    <span class="text-xs text-gray-100">Facebook</span>
                </button>
                <button class="flex items-center bg-red-600 shadow-md rounded px-3 py-2 mr-2 mb-2 hover:bg-red-500"
                        @click.prevent="socialAuth('google')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="feather feather-facebook text-gray-100 w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span class="text-xs text-gray-100">Google</span>
                </button>
                <button class="flex items-center bg-gray-300 shadow-md rounded px-3 py-2 mb-2 hover:bg-gray-100"
                        @click.prevent="socialAuth('github')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="feather feather-github text-gray-800 w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                    </svg>
                    <span class="text-xs text-gray-800">Github</span>
                </button>
            </div>

            <div class="text-center mt-4 text-gray-800 dark:text-gray-300">
                Don't have an account ?
                <router-link to="/register" class="text-blue-500">Register</router-link>
            </div>
        </div>
    </div>
</template>

<script>
// #-Notes: Form Components are registered as global components in app.js file.
import axios from 'axios';
import {mapActions, mapState} from 'vuex';
import auth from '../../store/auth';

export default {
    name: 'Login',
    data() {
        return {
            loginCredentials: {
                username: "",
                password: "",
                remember: false,
                csrf_token: null,
            },
            errors: {},
            processing: false,
        }
    },
    methods: {
        ...mapActions({
            loginAttempt: 'auth/login',
            socialAuthAction: 'auth/socialAuth',
            clearAuthError: 'auth/clearError',
        }),
        async login() {
            let __this = this;

            this.processing = true;
            __this.$Progress.start();
            __this.errors = {};
            this.clearAuthError(); /// If error is not cleared in VueX auth state... Home page is not shown on successful login ...

            if (!__this.loginCredentials.username.trim()) __this.errors.username = 'Username or Email is required!';
            if (!__this.loginCredentials.password.trim()) {
                __this.errors.password = 'Password is required!';
            } else if (__this.loginCredentials.password.trim().length < 8) {
                __this.errors.password = 'Password should be at least 8 characters!';
            }
            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                __this.processing = false;
                return
            }

            await this.loginAttempt(this.loginCredentials).finally(() => {
                __this.processing = false;
            });

            if (auth.state.error != null) {
                __this.$Progress.fail();
                __this.errors = auth.state.error;
                return
            }

            if (auth.state.user != null) {
                if (auth.state.user.email_verified_at != null) __this.$router.replace({name: 'Home'});
                else __this.$router.replace({name: 'EmailVerification'});
                __this.$Progress.finish();
            } else {
                __this.$Progress.fail();
            }
            // this.$store.dispatch('currentUser/loginUser', this.user);
        },
        async socialAuth(provider) {
            this.$Progress.start();
            await this.socialAuthAction(provider)
                .then((response) => {
                    if (response.data.url) {
                        window.location.href = response.data.url;
                    }
                }).finally(() => {
                    this.$Progress.finish();
                });
        },
    }
}
</script>
