<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="fixed z-30 inset-0 overflow-y-auto" v-if="showTodoFormModal">
        <div class="flex tasks-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 transition-opacity" aria-hidden="true" :class="[showTodoFormModal ? 'animateInFade' : '']"
                 @click="closeModal">
                <div class="absolute inset-0 bg-gray-800 opacity-80"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="shadow-md inline-block align-bottom bg-gray-100 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-900"
                 role="dialog" aria-modal="true" aria-labelledby="modal-headline"
                 :class="[showTodoFormModal ? 'animateInFadeDown' : '' , 'startPosition']">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <section>
                        <h1 class="text-center text-gray-600 mb-4 font-bold text-lg md:text-3xl">
                            {{ formType === 'update' ? 'Update Todo' : 'Add Todo' }}
                        </h1>

                        <Custom_Text_Input
                            class="mb-4"
                            label="Todo Title"
                            id="todo_title"
                            type="text"
                            placeholder="Todo Title"
                            v-model="createFormData.title"
                            :error="errors.title && Array.isArray(errors.title) ? errors.title[0] : errors.title"
                            Add_Input_Class="h-10"
                        />

                        <!--<div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                Description:
                            </label>
                            <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                            <p class="text-red-500 text-xs italic">Please choose a password.</p>
                        </div>-->

                        <!-- Editor -->
                        <!--<div class="mb-6">
                            <label class="block font-medium text-sm mb-2 text-gray-800 dark:text-gray-300" for="Description">
                                Description:
                            </label>

                            <vue-editor class="rounded-lg text-gray-700 bg-white shadow-lg dark:bg-gray-900 dark:text-gray-100"
                                        v-model="createFormData.description" id="Description">
                            </vue-editor>
                        </div>-->

                        <Custom_Text_Input
                            class="mb-5"
                            label="Description"
                            id="Description"
                            type="textarea"
                            placeholder="Description ..."
                            v-model="createFormData.description"
                            :error="errors.description && Array.isArray(errors.description) ? errors.description[0] : errors.description"
                            Add_Input_Class="resize-none"
                        />


                        <Custom_Checkbox_Input
                            class="mb-5"
                            id="for_today"
                            type="checkbox"
                            v-model="createFormData.forToday"
                            :error="errors.forToday && Array.isArray(errors.forToday) ? errors.forToday[0] : errors.forToday"
                            name="for_today"
                            checkLabel="For Today...?"
                            v-if="formType != 'update'"
                        />


                        <div v-if="formType != 'update'">
                            <div class="flex justify-between mb-2">
                                <h3 class="text-sm">Add Item to todo?</h3>
                                <span @click="addFormInput" class="bg-green-500 px-2 py-1 cursor-pointer rounded text-white dark:text-gray-900 font-bold">
                                    +
                                </span>
                            </div>

                            <div v-for="(task, i) in createFormData.tasks"
                                 :key="i" class="relative">
                                <Custom_Text_Input
                                    class="mb-4"
                                    :id="'todo_task-'+i"
                                    type="text"
                                    placeholder="Task title"
                                    v-model="task.title"
                                    :error="errors.tasks && Array.isArray(errors.tasks) ? errors.tasks[0].i.title : errors.tasks"
                                    displayErrorMsg=false
                                    Add_Input_Class="h-10 w-full flex-auto"
                                />
                                <div v-if="i !== 0" @click="removeFormInput(i)" class="absolute right-1.5 top-1.5 bg-red-500 px-2 py-1 cursor-pointer rounded text-white dark:text-gray-900 font-bold">
                                    x
                                </div>

                                <p v-if="errors.length">
                                    {{ errors.tasks[0].title[0] }}
                                </p>
                            </div>
                            <p class="text-red-500 text-xs italic mt-2" v-if="errors && errors.tasks">
                                {{ errors.tasks && Array.isArray(errors.tasks) ? errors.tasks[0] : errors.tasks }}
                            </p>
                        </div>


                        <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm focus:border-opacity-0"
                                    @click.stop.prevent="submitUpdateForm()"
                                    v-if="formType==='update'">
                                Update
                            </button>
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm focus:border-opacity-0"
                                    @click.stop.prevent="submitCreateForm()"
                                    v-else>
                                Add New Todo
                            </button>
                            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                    @click="closeModal(true)">
                                Cancel
                            </button>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Basic Use - Covers most scenarios
import {VueEditor} from "vue2-editor";
import {mapActions, mapState} from "vuex";
// Advanced Use - Hook into Quill's API for Custom Functionality
//import { VueEditor, Quill } from "vue2-editor";

// #-Notes: Form Components are registered as global components in app.js file.

export default {
    name: 'TodoForm',
    components: {
        VueEditor,
    },
    props: {
        showTodoFormModal: {
            type: Boolean,
            default: false,
        },
        formType: {
            type: String,
            default: "create",
        },
        data: {
            type: [Object],
            default: () => [],
        },
    },
    data() {
        return {
            createFormData: {
                title: '',
                description: '',
                forToday: false,
                tasks: [
                    {
                        title: ''
                    },
                ],
            },
            errors: [],
        }
    },
    computed: {
        ...mapState({
            getErrors: state => state.todo.error
        }),
    },
    methods: {
        closeModal(clearForm = false) {
            this.$emit('closeModal', false);
            if (clearForm === true) {
                this.clearForm();
            }
        },
        addFormInput() {
            this.createFormData.tasks.push({title: ''});
        },
        removeFormInput(index) {
            this.createFormData.tasks.splice(index, 1);
        },
        ...mapActions({
            addTodo: 'todo/addTodo',
            updateTodo: 'todo/updateTodo',
            clearError: 'todo/clearError',
        }),
        clearErrors() {
            this.errors = {};
            this.clearError();
        },
        validateFormData() {
            let __this = this;
            // Todo Title validation ....
            if (__this.createFormData.title.trim() == '') {
                __this.errors.title = 'Title is required.';
            } else if (__this.createFormData.title.trim().length < 3) {
                __this.errors.title = 'Title should be at least 3 characters.';
            }

            // Task title Validation ....
            if (Object.keys(__this.createFormData.tasks).length) {
                let i = 0;
                __this.createFormData.tasks.forEach(e => {
                    if (e.title == "") i++;
                    else {
                        if (e.title.length < 3) __this.errors.tasks = "Task should be at least 'Three' characters";
                    }
                });
                /*if (Object.keys(__this.createFormData.tasks).length === i) __this.errors.tasks = 'Please add at-least one task.';
                else*/ if (Object.keys(__this.createFormData.tasks).length - i > 5) __this.errors.tasks = 'Task must not be more then 5.';
            } /*else {
                __this.errors.tasks = 'Task is missing from this todo! Please add task.'
            }*/
        },
        async submitCreateForm() {
            let __this = this;
            __this.$Progress.start();
            __this.clearErrors();

            this.validateFormData();

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                return;
            }

            await this.addTodo(__this.createFormData);

            if (__this.getErrors != null) {
                __this.errors = __this.getErrors;
                __this.$Progress.fail();
                return;
            }
            __this.$Progress.finish();
            __this.closeModal(true);
            //console.clear();
        },
        async submitUpdateForm() {
            let __this = this;
            __this.$Progress.start();
            __this.clearErrors();

            // Todo Title validation ....
            if (__this.createFormData.title.trim() == '') {
                __this.errors.title = 'Title is required.';
            } else if (__this.createFormData.title.trim().length < 3) {
                __this.errors.title = 'Title should be at least 3 characters.';
            }

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                return;
            }
            __this.createFormData.id = this.data.id;

            await this.updateTodo(__this.createFormData);

            if (__this.getErrors != null) {
                __this.errors = __this.getErrors;
                __this.$Progress.fail();
                return;
            }
            __this.$Progress.finish();
            __this.closeModal(true);
            //console.clear();
        },
        clearForm() {
            this.createFormData.title = '';
            this.createFormData.description = '';
            this.createFormData.tasks = [{title: ''}];
        },
    },
    mounted() {
        if (this.formType == "update") {
            if (Object.keys(this.data).length > 0) {
                this.createFormData.title = this.data.title;
                this.createFormData.description = this.data.description == null ? "" : this.data.description;
            }
        }
    }
}
</script>

<style scoped>
.animateInFade {
    animation: animateInFade 200ms forwards cubic-bezier(0.25, 0.1, 0.25, 1.0);
}

@keyframes animateInFade {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.startPosition {
    transform: scale(1) translateY(-100px);
}

.animateInFadeDown {
    animation: animateInFadeDown 400ms forwards cubic-bezier(0.25, 0.1, 0.25, 1.0);
}

@keyframes animateInFadeDown {
    to {
        transform: translateY(0);
    }
}

</style>
