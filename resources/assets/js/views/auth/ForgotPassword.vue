<template>
    <div class="w-24 min-w-max mx-auto max-w-prose bg-gray-200 shadow-xl rounded-lg my-10 place-content-center lg:min-w-max md:w-auto dark:bg-gray-800" style="min-width: 340px!important;">
        <h1 class="text-center text-gray-800 py-4 text-2xl mt-2 dark:text-gray-300">Reset Password</h1>
        <div class="bg-gray-200 pt-4 pb-16 dark:bg-gray-800">
            <div class="w-4/5 mx-auto text-gray-800 dark:text-gray-300">
                <form @submit.stop.prevent="sendResetLink" method="post" autofocus="autofocus">
                    <Custom_Text_Input
                        class="mb-4"
                        label="Email"
                        id="email"
                        type="email"
                        placeholder="example@email.com"
                        v-model="credentials.email"
                        :error="errors.email && Array.isArray(errors.email) ? errors.email[0] : errors.email"
                        Add_Input_Class="h-10 dark:bg-gray-900"
                        :disabled="formDisabled"
                    />
                    <Custom_Loading_Button
                        Add_Input_Class="mb-4 mt-6 block mx-auto uppercase rounded"
                        @button_clicked="sendResetLink" :processing="processing" :disabled="formDisabled">
                        <span v-if="!emailSent">Send password reset link</span>
                        <span v-else>Resend password reset link</span>
                    </Custom_Loading_Button>
                </form>

                <div class="text-center text-xs mt-2 text-gray-800 dark:text-gray-300" v-if="countdownTimer">
                    Email sent successfully. You can retry in {{ countdownTimer }} sec.
                </div>
            </div>

            <div class="text-center mt-4 text-gray-800 dark:text-gray-300">
                <router-link to="/login" class="text-blue-500">Back to login.</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import auth from "../../store/auth";

export default {
    name: 'ForgetPassword',
    data() {
        return {
            credentials: {
                email: '',
            },
            errors: {},
            emailSent: false,
            formDisabled: false,
            processing: false,
            timerInterval: null,
            countdownTimer: null,
        }
    },
    methods: {
        ...mapActions({
            forgotPassword: 'auth/forgotPassword',
            clearAuthError: 'auth/clearError',
        }),
        async sendResetLink() {
            let __this = this;

            __this.processing = true;
            __this.$Progress.start();
            __this.errors = {};
            __this.clearAuthError(); /// If error is not cleared in VueX auth state... Home page is not shown on successful login ...
            if (!__this.credentials.email.trim()) __this.errors.email = 'Email is required!';

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                __this.processing = false;
                return
            }

            await this.forgotPassword(this.credentials).finally(() => {
                __this.processing = false;
            });

            if (auth.state.error != null) {
                __this.$Progress.fail();
                __this.errors = auth.state.error;
                return
            }
            __this.formDisabled = true;
            __this.startTimer();
        },
        startTimer() {
            const TIME_LIMIT = 60;
            let timePassed = 0;
            this.countdownTimer = TIME_LIMIT;
            this.timerInterval = setInterval(() => {
                timePassed += 1;
                this.countdownTimer = TIME_LIMIT - timePassed;
                if (this.countdownTimer == 0) {
                    this.onTimesUp();
                }
            }, 1000);
        },
        onTimesUp() {
            clearInterval(this.timerInterval);
            this.formDisabled = false;
            this.countdownTimer = null;
            this.emailSent = true;
        }
    }
}
</script>
