<template>
    <transition leave-active-class="duration-200">
        <transition enter-active-class="ease-out duration-300">
            <div class="w-full overflow-hidden mt-8 mb-8">
                <div class="flex flex-col justify-center align-middle items-center text-center">
                    <h3 class="text-lg font-bold mb-4 mt-4">Email verification</h3>
                    <div class="mb-4 text-sm text-gray-600">
                        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                    </div>

                    <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
                        A new verification link has been sent to the email address you provided during registration.
                    </div>
                    <div class="text-xs">
                        <p>Please verify your email first.
                            ( <strong class="cursor-pointer font-bold pb-2 text-pink-600" @click="sendEmailVerificationCode"> {{ verificationLinkSent ? "Resend email ?" : "Send email ?" }} </strong> )</p>

                        <div class="mt-4 inline-flex" v-if="processing">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm">Sending Email. Please wait ...</span>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </transition>
</template>

<script>
import {mapActions} from 'vuex';
import auth from "../../store/auth";

export default {
    name: "EmailVerification",
    data() {
        return {
            verificationLinkSent: false,
            processing: false,
            errors: {},
        }
    },
    beforeMount() {
        this.getUsed()
    },
    methods: {
        ...mapActions({
            emailVerificationAction: 'auth/emailVerification',
            clearAuthError: 'auth/clearError',
            getMe: 'auth/me'
        }),
        async getUsed() {
            await this.getMe();
            if (this.$store.state.auth.user.email_verified_at != null) {
                await this.$router.replace({name: 'Home'})
            }
        },
        async sendEmailVerificationCode() {
            let __this = this;
            __this.processing = true;
            __this.$Progress.start();
            __this.errors = {};

            await this.clearAuthError();

            await this.emailVerificationAction().finally(() => {
                __this.processing = false;
                __this.verificationLinkSent = true;
            });

            if (auth.state.error != null) {
                __this.$Progress.fail();
                __this.errors = auth.state.error;
                return
            }
            __this.$Progress.finish();
        }
    }
}
</script>
