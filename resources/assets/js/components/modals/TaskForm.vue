<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="fixed z-30 inset-0 overflow-y-auto" v-if="showTaskFormModal">
        <div class="flex tasks-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 transition-opacity" aria-hidden="true" :class="[showTaskFormModal ? 'animateInFade' : '']"
                 @click="closeModal">
                <div class="absolute inset-0 bg-gray-800 opacity-80"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="shadow-md inline-block align-bottom bg-gray-100 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-900"
                 role="dialog" aria-modal="true" aria-labelledby="modal-headline"
                 :class="[showTaskFormModal ? 'animateInFadeDown' : '' , 'startPosition']">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <section>
                        <h1 class="text-center text-gray-600 mb-4 font-bold text-lg md:text-3xl">
                            {{ formType === 'update' ? 'Update Task' : 'Add Task' }}
                        </h1>

                        <Custom_Text_Input
                            class="mb-4"
                            label="Todo Title"
                            id="todo_title"
                            type="text"
                            placeholder="Todo Title"
                            v-model="createFormData.taskTitle"
                            :error="errors.taskTitle && Array.isArray(errors.taskTitle) ? errors.taskTitle[0] : errors.taskTitle"
                            Add_Input_Class="h-10"
                            disabled="disabled"
                        />

                        <div>
                            <div @click="canMoveTask()" class="flex flex-row items-center rounded-md bg-gray-200 dark:bg-gray-800 mb-2 py-2 px-2 text-xs cursor-pointer">
                                <div class="rounded-full h-5 w-5 shadow-inner mr-2 bg-gray-400 dark:bg-gray-900">
                                    <svg v-if="canMoveTaskToOtherTodo" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 stroke-current text-purple-600 dark:text-purple-600" viewBox="0 0 24 24" stroke-width="2" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M9 12l2 2l4 -4" />
                                    </svg>
                                </div>
                                <div>Move Task To:</div>
                            </div>
                            <div v-if="canMoveTaskToOtherTodo">
                                <div class="flex" v-if="dayOptions">
                                    <Custom_Radio_Input
                                        class="mb-5"
                                        type="radio"
                                        label=""
                                        id="moveTaskTo"
                                        name="moveTaskTo"
                                        v-model="createFormData.moveTaskTo"
                                        :error="errors.moveTaskTo && Array.isArray(errors.moveTaskTo) ? errors.moveTaskTo[0] : errors.moveTaskTo"
                                        orientation="flex"
                                        :options="dayOptions"
                                    />
                                </div>


                                <div v-if="Object.keys(todosFiltered).length > 0" class="mt-2">
                                    <h4 class="text-sm mb-2">Select a Todo list:</h4>
                                    <div v-for="todo in todosFiltered" :key="todo.id">
                                        <div class="rounded-md bg-gray-200 dark:bg-gray-800 mb-2 py-2 px-2 text-xs cursor-pointer" @click="todoSelected(todo.id)"
                                             :class="{'bg-purple-400 dark:bg-purple-600':todo.id == createFormData.todo_id}">
                                            {{ todo.title | capitalize | truncate(100, '...') }}
                                        </div>
                                    </div>
                                    <div v-if="errors.todo_id && Array.isArray(errors.todo_id) ? errors.todo_id[0] : errors.todo_id">
                                        <p class="text-red-500 text-xs italic mt-2" v-if="!!errors.todo_id">{{ errors.todo_id }}</p>
                                    </div>
                                </div>
                                <div v-else>
                                    <div v-if="createFormData.moveTaskTo" class="mt-2 text-xs text-white bg-red-500 bg-opacity-80 rounded px-2 py-2 text-center">
                                        <p>No Todo found for this date.</p>
                                    </div>
                                </div>
                            </div>
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
import {mapActions, mapState} from "vuex";
import dayjs from "dayjs";

// #-Notes: Form Components are registered as global components in app.js file.

export default {
    name: 'TaskForm',
    props: {
        showTaskFormModal: {
            type: Boolean,
        },
        formType: {
            type: String,
            default: "create",
        },
        data: {
            type: [Object, Array],
            default: () => [],
        },
    },
    data() {
        return {
            createFormData: {
                taskTitle: '',
                todo_id: '',
                moveTaskTo: '',
            },
            todosFiltered: [],
            errors: [],
            dayOptions: {},
            canMoveTaskToOtherTodo: false,
        }
    },
    watch: {
        "createFormData.moveTaskTo"(newVal, oldVal) {
            if (newVal != oldVal) {
                this.todosFiltered = [];
            }
            if (newVal != "") {
                let selectedDate = new Date(newVal).setHours(0, 0, 0, 0); //yyyy-mm-dd
                this.todosFiltered = this.todos.filter(obj => {
                    let dateBaseDate = new Date(obj.date).setHours(0, 0, 0, 0); //yyyy-mm-dd
                    if (dateBaseDate > selectedDate || dateBaseDate < selectedDate) {
                        // Empty if condition ....
                    } else {
                        return obj;
                    }
                });
            }
        }
    },
    computed: {
        ...mapState({
            todos: state => state.todo.todos,
            getErrors: state => state.todo.error
        }),
    },
    methods: {
        ...mapActions({
            updateTask: 'todo/updateTask',
            clearError: 'todo/clearError',
        }),
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
        clearErrors() {
            this.errors = {};
            this.clearError();
        },
        canMoveTask() {
            this.canMoveTaskToOtherTodo = !this.canMoveTaskToOtherTodo;
            if (this.canMoveTaskToOtherTodo == false) {
                this.dayOptions = {};
                this.todosFiltered = [];
                this.createFormData.moveTaskTo = "";
            } else {
                this.filterDaysOption();
            }
        },
        validateFormData() {
            let __this = this;
            // Todo Title validation ....
            if (__this.createFormData.taskTitle.trim() == '') {
                __this.errors.taskTitle = 'Title is required.';
            } else if (__this.createFormData.taskTitle.trim().length < 3) {
                __this.errors.taskTitle = 'Title should be at least 3 characters.';
            }

            if (__this.createFormData.moveTaskTo != "") {
                if (__this.createFormData.todo_id == "") {
                    __this.errors.todo_id = 'Please select a todo item to move the task!';
                }
            }
        },
        todoSelected(todoId) {
            this.createFormData.todo_id = todoId;
        },
        async submitCreateForm() {

        },
        async submitUpdateForm() {
            let __this = this;
            __this.$Progress.start();
            __this.clearErrors();

            this.validateFormData();

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                return;
            }
            await this.updateTask(__this.createFormData);

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
            this.dayOptions = {};
            this.createFormData.taskTitle = "";
            this.createFormData.taskId = "";
            this.createFormData.moveTaskTo = "";
        },
        filterDaysOption() {
            if (dayjs().isSame(this.data.todoDate, 'date')) {
                this.dayOptions = {Tomorrow: dayjs().add(1, 'day').format("ddd, DD MMM YYYY")};
            } else if (dayjs().isAfter(this.data.todoDate, 'day')) {
                this.dayOptions = {
                    Today: dayjs().format("ddd, DD MMM YYYY"),
                    Tomorrow: dayjs().add(1, 'day').format("ddd, DD MMM YYYY")
                };
            } else if (dayjs().isBefore(this.data.todoDate, 'day')) {
                this.dayOptions = {Today: dayjs().format("ddd, DD MMM YYYY")};
            }
        },
    },
    mounted() {
        if (Object.keys(this.data).length > 0) {
            this.createFormData.taskTitle = this.data.task.title;
            this.createFormData.taskId = this.data.task.id;
        }
        this.filterDaysOption();
    },
    beforeDestroy() {
        this.clearForm();
    },
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
