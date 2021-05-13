<template>
    <div class="w-24 min-w-max mx-auto max-w-prose bg-gray-200 shadow-xl rounded my-10 place-content-center lg:min-w-max md:w-auto dark:bg-gray-800" style="min-width: 380px!important;">
        <h1 class="text-center text-gray-800 py-4 text-2xl mt-2 dark:text-gray-300">Register</h1>
        <div class="bg-gray-200 pt-4 pb-16 dark:bg-gray-800">
            <div class="w-4/5 mx-auto">
                <form @submit.stop.prevent="register" method="post" autofocus="autofocus">

                    <div class="flex flex-wrap justify-between">
                        <Custom_Text_Input
                            class="md:w-1/2 w-full md:pr-1 mb-4"
                            type="text"
                            label="First Name"
                            placeholder="John"
                            v-model="registrationData.first_name"
                            :error="errors.first_name && Array.isArray(errors.first_name) ? errors.first_name[0] : errors.first_name"
                            id="first_name"
                            Add_Input_Class="h-10 dark:bg-gray-900"/>

                        <Custom_Text_Input
                            class="md:w-1/2 w-full md:pl-1 mb-4"
                            type="text"
                            label="Last Name"
                            placeholder="Doe"
                            v-model="registrationData.last_name"
                            :error="errors.last_name && Array.isArray(errors.last_name) ? errors.last_name[0] : errors.last_name"
                            id="last_name"
                            Add_Input_Class="h-10 dark:bg-gray-900"/>
                    </div>


                    <Custom_Text_Input
                        class="mb-4"
                        v-model="registrationData.username"
                        label="User Name"
                        type="text"
                        :error="errors.username && Array.isArray(errors.username) ? errors.username[0] : errors.username"
                        placeholder="user123"
                        id="username"
                        Add_Input_Class="h-10 dark:bg-gray-900"/>

                    <Custom_Text_Input
                        class="mb-4"
                        v-model="registrationData.email"
                        label="Email"
                        type="email"
                        :error="errors.email && Array.isArray(errors.email) ? errors.email[0] : errors.email"
                        placeholder="example@gmail.com"
                        id="email"
                        Add_Input_Class="h-10 dark:bg-gray-900"/>

                    <!--<Custom_Text_Input
                        class="mb-4"
                        label="Password"
                        type="password"
                        v-model="registrationData.password"
                        :error="errors.password && Array.isArray(errors.password) ? errors.password[0] : errors.password"
                        placeholder="********"
                        id="password"
                        Add_Input_Class="h-10 dark:bg-gray-900"
                    />
                    <Custom_Text_Input
                        class="mb-4"
                        v-model="registrationData.password_confirmation"
                        label="Confirm Password"
                        type="password"
                        placeholder="********"
                        id="password_confirmation"
                        Add_Input_Class="h-10 dark:bg-gray-900"
                    />-->

                    <div class="flex flex-wrap justify-between">
                        <Custom_Text_Input
                            class="md:w-1/2 w-full md:pr-1 mb-4"
                            type="password"
                            label="Password"
                            placeholder="********"
                            id="password"
                            v-model="registrationData.password"
                            :error="errors.password && Array.isArray(errors.password) ? errors.password[0] : errors.password"
                            Add_Input_Class="h-10 dark:bg-gray-900"/>

                        <Custom_Text_Input
                            class="md:w-1/2 w-full md:pl-1 mb-4"
                            type="password"
                            label="Confirm Password"
                            placeholder="********"
                            id="password_confirmation"
                            v-model="registrationData.password_confirmation"
                            Add_Input_Class="h-10 dark:bg-gray-900"/>
                    </div>

                    <Custom_Loading_Button Add_Input_Class="mx-auto block mt-2 mb-6 uppercase rounded"
                                           @button_clicked="register" :processing="processing">
                        <span>Register</span>
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

            <div class="text-center mt-4 text-gray-800 dark:text-gray-100">
                Already have an account ?
                <router-link to="/login" class="text-blue-500">Login</router-link>
            </div>
        </div>
    </div>
</template>

<script>
// #-Notes: Form Components are registered as global components in app.js file.
import axios from 'axios';
import {mapActions} from 'vuex';
import auth from "../../store/auth";

export default {
    name: 'Register',
    props: {
        BaseUrl: String,
    },
    data() {
        return {
            registrationData: {
                first_name: "",
                last_name: "",
                username: "",
                email: "",
                password: "",
                password_confirmation: "",
            },
            hasError: [],
            errors: {},
            processing: false,
        }
    }, methods: {
        ...mapActions({
            registerAction: 'auth/register',
            socialAuthAction: 'auth/socialAuth',
            clearAuthError: 'auth/clearError',
        }),
        async register() {
            let __this = this;
            __this.$Progress.start();
            this.clearAuthError();
            __this.errors = {};
            __this.processing = true;

            if (!__this.registrationData.first_name.trim()) __this.errors.first_name = 'First Name is required!';

            if (!__this.registrationData.last_name.trim()) __this.errors.last_name = 'Last Name is required!';

            if (!__this.registrationData.username.trim()) __this.errors.username = 'Username is required!';

            if (!__this.registrationData.email.trim()) __this.errors.email = 'Email is required!'

            if (!__this.registrationData.password.trim()) {
                __this.errors.password = 'Password is required!';
            } else if (__this.registrationData.password.trim().length < 8) {
                __this.errors.password = 'Password should be at least 8 characters!';
            } else if (__this.registrationData.password.trim() !== __this.registrationData.password_confirmation.trim()) {
                __this.errors.password = 'Password confirmation does not match!';
            }

            if (!__this.registrationData.password_confirmation.trim()) {
                __this.errors.password_confirmation = 'Confirm password is required!';
            } else if (__this.registrationData.password_confirmation.trim().length < 8) {
                __this.errors.password_confirmation = 'Confirm password should be at least 8 characters!';
            }

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                __this.processing = false;
                return
            }

            await this.registerAction(__this.registrationData).finally(() => {
                __this.processing = false;
            });

            if (auth.state.error != null) {
                __this.$Progress.fail();
                __this.errors = auth.state.error;
                return
            }
            __this.$Progress.finish();
            await __this.$router.replace({name: 'Login'});
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
