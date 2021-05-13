<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div>
        <modal v-if="showUpdatePasswordModal"
               :showModal="showUpdatePasswordModal"
               modalTitle="Update Password!"
               @closeModal="closeUpdatePasswordModal">

            <template v-slot:modalContent>
                <form @submit.stop.prevent="updatePassword" method="post">
                    <Custom_Text_Input
                        class="mb-4" Add_Input_Class="h-10"
                        label="Old Password"
                        id="current_password"
                        type="password"
                        placeholder="********"
                        v-model="updatePasswordForm.current_password"
                        :error="errors.current_password && Array.isArray(errors.current_password) ? errors.current_password[0] : errors.current_password"
                    />

                    <Custom_Text_Input
                        class="mb-4" Add_Input_Class="h-10"
                        label="New Password"
                        id="password"
                        type="password"
                        placeholder="********"
                        v-model="updatePasswordForm.password"
                        :error="errors.password && Array.isArray(errors.password) ? errors.password[0] : errors.password"
                    />

                    <Custom_Text_Input
                        class="mb-4" Add_Input_Class="h-10"
                        label="Confirm Password"
                        id="password_confirmation"
                        type="password"
                        placeholder="********"
                        v-model="updatePasswordForm.password_confirmation"
                        :error="errors.password_confirmation && Array.isArray(errors.password_confirmation) ? errors.password_confirmation[0] : errors.password_confirmation"
                    />

                    <div class="flex justify-end pt-2">
                        <button class="shadow-md px-3 py-1 bg-red-500 border border-transparent rounded-md
                        text-xs text-white tracking-widest hover:bg-red-400 active:bg-red-600 transition ease-in-out
                        duration-150 mb-2 block mx-auto uppercase rounded"
                                @click.stop.prevent="showUpdatePasswordModal = !showUpdatePasswordModal">
                            Cancel
                        </button>

                        <Custom_Loading_Button
                            Add_Input_Class="mb-2 block mx-auto uppercase rounded"
                            @button_clicked="updatePassword" :processing="processing">
                            <span>Update</span>
                        </Custom_Loading_Button>
                    </div>
                </form>
            </template>

        </modal>

        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="flex-1 min-w-0 mt-4" v-if="user">
                <img class="w-32 h-32 mb-4 rounded-full shadow-md" :src="user.avatar" alt="" width="384" height="512">
                <h2 class="text-2xl mb-2 leading-7 sm:text-3xl sm:truncate">
                    {{ user.first_name + ' ' + user.last_name }}
                </h2>
                <div>
                    <p class="mb-2">Username: <span class="text-indigo-600 dark:text-indigo-400">{{ user.username }}</span></p>
                    <p class="mb-2">Email: <span class="text-indigo-600 dark:text-indigo-400">{{ user.email }}</span></p>
                </div>
                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <!-- Heroicon name: solid/calendar -->
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        Joined: {{ user.created_at | dateFormatAgo }}
                    </div>
                </div>
            </div>

            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <div class="sm:block">
                    <button type="button" class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-200"
                            @click.stop.prevent="showEditProfileModal = !showEditProfileModal">
                        <!-- Heroicon name: solid/pencil -->
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                        </svg>
                        Edit
                    </button>
                </div>

                <div class="sm:block ml-3 relative">
                    <button type="button" class="inline-flex items-center px-4 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-200"
                            @click.stop.prevent="showUpdatePasswordModal = true" :disabled="showUpdatePasswordModal"
                            :class="{'bg-gray-200':showUpdatePasswordModal}">
                        <!-- Heroicon name: solid/link -->
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/>
                        </svg>
                        Change Password
                    </button>
                </div>
            </div>
        </div>

        <div class="my-8">
            Logged in devices.
        </div>
    </div>
</template>

<script>
import {mapActions, mapState} from "vuex";
import Modal from "../components/modals/Modal";

export default {
    name: "Profile",
    components: {Modal},
    data() {
        return {
            user: [],
            updatePasswordForm: {
                current_password: "",
                password: "",
                password_confirmation: "",
            },
            errors: [],
            processing: false,
            showEditProfileModal: false,
            showUpdatePasswordModal: false,
        }
    },
    beforeMount() {
        this.user = this.$store.state.auth.user;
    },
    computed: {
        ...mapState({
            getErrors: state => state.user_state.error
        }),
    },
    methods: {
        ...mapActions({
            updateUserPassword: 'user_state/updateUserPassword',
            clearError: 'user_state/clearError'
        }),
        closeUpdatePasswordModal() {
            let __this = this;
            __this.showUpdatePasswordModal = false;
            __this.updatePasswordForm.current_password = "";
            __this.updatePasswordForm.password = "";
            __this.updatePasswordForm.password_confirmation = "";
        },
        validateRequest() {
            let __this = this;
            if (!__this.updatePasswordForm.current_password.trim()) {
                __this.errors.current_password = 'Old password is required!'
            }

            if (!__this.updatePasswordForm.password.trim()) {
                __this.errors.password = 'New password is required!'
            } else if (__this.updatePasswordForm.password.trim().length < 8) {
                __this.errors.password = 'Password should be at least 8 characters!';
            } else if (__this.updatePasswordForm.password.trim() === __this.updatePasswordForm.current_password.trim()) {
                __this.errors.password = 'Old password and New password cannot be same.';
            } else if (__this.updatePasswordForm.password.trim() !== __this.updatePasswordForm.password_confirmation.trim()) {
                __this.errors.password = 'New password and Confirm password does not match.';
            }

            if (!__this.updatePasswordForm.password_confirmation.trim()) {
                __this.errors.password_confirmation = 'Confirm password is required!'
            } else if (__this.updatePasswordForm.password_confirmation.trim().length < 8) {
                __this.errors.password_confirmation = 'Confirm password should be at least 8 characters!';
            }
        },
        async updatePassword() {
            let __this = this;
            __this.$Progress.start();
            __this.clearErrors();
            __this.processing = true;

            __this.validateRequest();

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                __this.processing = false;
                return;
            }

            await this.updateUserPassword(__this.updatePasswordForm)
                .finally(() => {
                    __this.processing = false;
                });

            if (__this.getErrors != null) {
                __this.errors = __this.getErrors;
                __this.$Progress.fail();
                return;
            }
            __this.closeUpdatePasswordModal();
            __this.$Progress.finish();
        },
        clearErrors() {
            this.errors = {};
            this.clearError();
        },
    },
}
</script>
