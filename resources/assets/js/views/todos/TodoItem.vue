<template>
    <div>
        <div class="mb-2">
            <p class="animate-bounce mt-2 text-sm text-center text-gray-400 dark:text-gray-600">
                Drag and Drop Items.
            </p>
            <p class="text-sm text-pink-500 py-3">
                <strong>Date:</strong> {{ date | dateFormatCustom("ddd, DD MMM YYYY") }}

                <span v-if="!restriction.canDrag" class="ml-2 text-red-500 text-xs font-bold">
                    (Drag mode is Disabled!)
                </span>
                <span v-if="!restriction.canAdd" class="ml-2 text-red-500 text-xs font-bold">
                    (Add task mode is Disabled!)
                </span>
                <span v-if="!restriction.canEdit" class="ml-2 text-red-500 text-xs font-bold">
                    (Edit mode is Disabled!)
                </span>
            </p>

            <div class="h-0.5 w-full bg-gray-300 dark:bg-gray-700 rounded-lg"></div>

            <template v-if="todo.length && loading === false">
                <div v-for="td in todo" :key="td.id">
                    <div class="flex my-4 justify-between">
                        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200"
                            :class="{'line-through text-green-500 dark:text-green-300':td.status==1}">
                            {{ td.title }}
                        </h2>


                        <div id="todoMenu" class="relative" v-if="todoMenuState.todoId === null || todoMenuState.todoId == td.id">
                            <div class="px-2 py-2 flex space-x-0.5 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800 rounded-md"
                                 :class="{'bg-gray-200 dark:bg-gray-800':todoMenuState.todoId == td.id}"
                                 @click="showTodoMenu(td)">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-800 dark:bg-gray-200"></span>
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-800 dark:bg-gray-200"></span>
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-800 dark:bg-gray-200"></span>
                            </div>

                            <div class="absolute z-50 top-5 right-0 shadow-md text-center w-44 h-auto bg-gray-200 dark:bg-gray-800 rounded-lg p-2"
                                 v-if="todoMenuState.showMenu && todoMenuState.todoId == td.id">
                                <!-- Edit button -->
                                <div v-if="restriction.canMoveToOtherDate && dayOptions">
                                    <button class="flex items-center justify-center space-x-2 mb-2 w-full bg-purple-500 hover:bg-purple-400 shadow text-white hover:text-black py-2 px-3 rounded text-xs"
                                            title="Delete Todo"
                                            v-for="dayOption in dayOptions"
                                            @click="moveTodoSubmit(dayOption, td.id)">
                                        <span>Move to: <strong>{{ dayOption }}</strong></span>
                                    </button>
                                </div>
                                <button class="flex items-center justify-center space-x-2 mb-2 w-full bg-blue-500 hover:bg-blue-400 shadow text-white hover:text-black py-2 px-3 rounded text-xs"
                                        title="Delete Todo"
                                        v-if="restriction.canEdit"
                                        @click="editTodoShowModal(td)">
                                    <span>Edit</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </button>
                                <!-- Delete button -->
                                <button class="flex items-center justify-center space-x-2 w-full bg-red-500 hover:bg-red-400 shadow text-white hover:text-black py-2 px-3 rounded text-xs"
                                        title="Delete Todo"
                                        @click="deleteTodoSubmit(td)">
                                    <span>Delete</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div v-if="td.description">
                        <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-500">
                            Description: {{ td.description | capitalize }}
                        </h2>
                    </div>


                    <div class="flex flex-row flex-wrap content-start px-4 pb-8 items-start">
                        <Card :id="'card-'+td.id" title="Incomplete" status="incomplete" :todoId="td.id">
                            <template v-slot:Item v-if="td.todo_tasks">
                                <Item v-for="(task, taskIndex) in td.todo_tasks" class="relative"
                                      :AddClass="{'bg-purple-400 dark:bg-purple-600':taskMenuState.taskId == task.id}"
                                      :key="task.id"
                                      :taskData="task"
                                      :draggable="restriction.canDrag"
                                      v-if="task.status == 'incomplete'"
                                      @dblclick.native="showTaskMenu(task.id)">

                                    <p class="ml-2 tracking-wide text-xs">
                                        {{ task.title | capitalize }}
                                    </p>

                                    <div id="taskMenu" class="taskMenuBlock bg-gray-200 dark:bg-gray-800 shadow-lg text-gray-800 dark:text-gray-100"
                                         :class="{'taskMenuExpand':taskMenuState.taskId == task.id && taskMenuState.showMenu}"
                                         :style="'z-index:'+ 2 + taskIndex +'!important'"
                                         v-if="taskMenuState.taskId == null || taskMenuState.taskId == task.id">

                                        <div class="animate-pulse duration-200 taskMenuButton bg-blue-400 dark:bg-blue-400"
                                             :style="'animation-delay:'+ 300 * taskIndex+'ms'"
                                             @click.prevent="showTaskMenu(task.id)"></div>

                                        <ul class="taskMenuItem text-xs">
                                            <li class="border-b-2 border-red-500 border-opacity-60 hover:bg-gray-300 dark:hover:bg-gray-700"
                                                @click.prevent="copyToClipboard(task.title)">Copy Text
                                            </li>
                                            <li class="border-b-2 border-red-500 border-opacity-60 hover:bg-gray-300 dark:hover:bg-gray-700"
                                                @click.prevent="editTaskShowModal(task, td.date)">Edit
                                            </li>
                                            <li class="hover:bg-gray-300 dark:hover:bg-gray-700"
                                                @click.prevent="deleteTaskSubmit(task)">Delete
                                            </li>
                                        </ul>
                                    </div>

                                </Item>
                            </template>

                            <template v-slot:Button v-if="restriction.canAdd">
                                <button class="bg-red-500 hover:bg-red-600 shadow text-white mt-3 py-2 px-4 rounded-md text-xs"
                                        v-if="createTask.todoId !== td.id" @click="toggleAddTaskForm(td.id)">
                                    Add Task
                                </button>
                                <div v-else>
                                    <div class="relative">
                                        <Custom_Text_Input
                                            :ref="'inputRef-'+td.id"
                                            class="mt-3"
                                            :id="'newTask-'+td.id"
                                            type="text"
                                            placeholder="Task title"
                                            v-model="createTask.taskTitle"
                                            :error="errors.taskTitle && Array.isArray(errors.taskTitle) ? errors.taskTitle[0] : errors.taskTitle"
                                            Add_Input_Class="h-10 bg-gray-100 dark:bg-gray-900 ring-1 ring-teal-600"
                                            @keyup.enter.native="submitAddTask(td.id)"
                                            @focusin.native="restriction.buttonOpacityLow=true"
                                            @focusout.native="restriction.buttonOpacityLow=false"
                                        />
                                        <!-- Buttons -->
                                        <div class="absolute right-1.5 top-1.5 flex flex-row flex-wrap content-start hover:opacity-100"
                                             :class="{'opacity-30 hover:opacity-100':restriction.buttonOpacityLow}">
                                            <button type="button" title="Save" @click="submitAddTask(td.id)"
                                                    class="flex-none flex items-center justify-center h-7 w-7 mr-1 bg-green-600 hover:bg-green-500 px-2 py-1 cursor-pointer rounded-md text-white">
                                                <svg class="stroke-current text-white dark:text-white feather feather-check-circle" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                </svg>
                                            </button>
                                            <button type="button" title="Cancel" @click="toggleAddTaskForm()"
                                                    class="flex-none flex items-center justify-center h-7 w-7 ml-1 bg-red-500 hover:bg-red-400 px-2 py-1 cursor-pointer rounded-md text-white">
                                                <svg class="stroke-current text-white dark:text-white feather feather-x" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </template>
                        </Card>

                        <Card :id="'card-'+td.id" title="Doing" status="doing" :todoId="td.id"
                              AddClass="">
                            <template v-slot:Item>
                                <Item v-for="(task, taskIndex) in td.todo_tasks" class="relative"
                                      :AddClass="{'bg-purple-400 dark:bg-purple-600':taskMenuState.taskId == task.id}"
                                      :key="task.id"
                                      :taskData="task"
                                      :draggable="restriction.canDrag"
                                      v-if="task.status === 'doing'">

                                    <p class="ml-2 tracking-wide text-xs text-yellow-600 dark:text-yellow-400">
                                        {{ task.title | capitalize }}
                                    </p>

                                    <div id="taskMenu" class="taskMenuBlock bg-gray-200 dark:bg-gray-800 shadow-lg text-gray-800 dark:text-gray-100"
                                         :class="{'taskMenuExpand':taskMenuState.taskId == task.id && taskMenuState.showMenu}"
                                         :style="'z-index:'+ 2 + taskIndex +'!important'"
                                         v-if="taskMenuState.taskId == null || taskMenuState.taskId == task.id">

                                        <div class="animate-pulse duration-200 taskMenuButton bg-blue-400 dark:bg-blue-400"
                                             :style="'animation-delay:'+ 300 * taskIndex+'ms'"
                                             @click.prevent="showTaskMenu(task.id)"></div>

                                        <ul class="taskMenuItem text-xs">
                                            <li class="border-b-2 border-red-500 border-opacity-60 hover:bg-gray-300 dark:hover:bg-gray-700"
                                                @click.prevent="copyToClipboard(task.title)">Copy Text
                                            </li>
                                            <li class="border-b-2 border-red-500 border-opacity-60 hover:bg-gray-300 dark:hover:bg-gray-700"
                                                @click.prevent="editTaskShowModal(task, td.date)">Edit
                                            </li>
                                            <li class="hover:bg-gray-300 dark:hover:bg-gray-700"
                                                @click.prevent="deleteTaskSubmit(task)">Delete
                                            </li>
                                        </ul>
                                    </div>

                                </Item>
                            </template>
                        </Card>

                        <Card :id="'card-'+td.id" title="Completed" status="completed" :todoId="td.id"
                              AddClass="">
                            <template v-slot:Item>
                                <Item v-for="(task, taskIndex) in td.todo_tasks" class="relative"
                                      :AddClass="{'bg-purple-400 dark:bg-purple-600':taskMenuState.taskId == task.id}"
                                      :key="task.id"
                                      :taskData="task"
                                      :draggable="restriction.canDrag"
                                      v-if="task.status === 'completed'">

                                    <p class="ml-2 tracking-wide text-xs" :class="{'line-through text-green-500 dark:text-green-300':task.status=='completed'}">
                                        {{ task.title | capitalize }}
                                    </p>

                                    <div id="taskMenu" class="taskMenuBlock bg-gray-200 dark:bg-gray-800 shadow-lg text-gray-800 dark:text-gray-100"
                                         :class="{'taskMenuExpand':taskMenuState.taskId == task.id && taskMenuState.showMenu}"
                                         :style="'z-index:'+ 2 + taskIndex +'!important'"
                                         v-if="taskMenuState.taskId == null || taskMenuState.taskId == task.id">

                                        <div class="animate-pulse duration-200 taskMenuButton bg-blue-400 dark:bg-blue-400"
                                             :style="'animation-delay:'+ 300 * taskIndex+'ms'"
                                             @click.prevent="showTaskMenu(task.id)"></div>

                                        <ul class="taskMenuItem text-xs">
                                            <li class="border-b-2 border-red-500 border-opacity-60 hover:bg-gray-300 dark:hover:bg-gray-700"
                                                @click.prevent="copyToClipboard(task.title)">Copy Text
                                            </li>
                                            <li class="border-b-2 border-red-500 border-opacity-60 hover:bg-gray-300 dark:hover:bg-gray-700"
                                                @click.prevent="editTaskShowModal(task, td.date)">Edit
                                            </li>
                                            <li class="hover:bg-gray-300 dark:hover:bg-gray-700"
                                                @click.prevent="deleteTaskSubmit(task)">Delete
                                            </li>
                                        </ul>
                                    </div>

                                </Item>
                            </template>
                        </Card>
                    </div>
                </div>
            </template>
            <div v-else>
                <Loading v-if="loading == true"/>
                <div v-else class="mt-4 text-xs text-white bg-red-500 bg-opacity-80 rounded px-4 py-4 text-center">
                    <p>No data found!</p>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import Card from './Card';
import Item from './Item';
import {mapActions, mapState} from "vuex";
import store from "../../store";
import * as dayjs from "dayjs";

export default {
    name: 'TodoItems',
    components: {
        Item,
        Card
    },
    props: {},
    data() {
        return {
            date: this.$route.params.date,
            loading: true,
            createTask: {
                todoId: "",
                taskTitle: "",
            },
            errors: {},
            todoTaskDragId: null,
            restriction: {
                canDrag: false,
                canAdd: false,
                canEdit: false,
                canMoveToOtherDate: false,
                buttonOpacityLow: false,
            },
            dayOptions: {},
            todoMenuState: {
                todoId: null,
                showMenu: false,
            },
            taskMenuState: {
                taskId: null,
                showMenu: false,
            },
        }
    },
    computed: {
        ...mapState({
            todos: state => state.todo.todos,
            todo: state => state.todo.todo,
            getErrors: state => state.todo.error
        }),
    },
    mounted() {
        this.getTodosForDate();
        this.checkDate(this.date);
    },
    created() {
        const escapeHandlerTodo = (e) => {
            e.stopPropagation();
            const element = document.getElementById('todoMenu');
            if (element) {
                const inside = document.getElementById('todoMenu').contains(e.target);
                if (!inside) this.closeTodoMenu();
            }
        };
        document.addEventListener('click', escapeHandlerTodo);

        const escapeHandlerTask = (e) => {
            e.stopPropagation();
            const element = document.getElementById('taskMenu');
            if (element) {
                const inside = document.getElementById('taskMenu').contains(e.target);
                if (!inside) this.closeTaskMenu();
            }
        };
        document.addEventListener('click', escapeHandlerTask);

        // Remove the event listeners ....
        this.$once('hook:destroyed', () => {
            document.removeEventListener('click', escapeHandlerTodo);
            document.removeEventListener('click', escapeHandlerTask);
        });
    },
    methods: {
        ...mapActions({
            addTask: 'todo/addTask',
            updateTask: 'todo/addTask',
            deleteTask: 'todo/deleteTask',
            deleteTodo: 'todo/deleteTodo',
            moveTodo: 'todo/moveTodo',
            clearError: 'todo/clearError',
            getTodoForDate: 'todo/getTodoForDate',
        }),
        checkDate(date) {
            const formatedDate = dayjs(date);
            if (dayjs().isSame(formatedDate, 'date')) {
                this.restriction.canDrag = true;
                this.restriction.canAdd = true;
                this.restriction.canEdit = true;
            } else if (dayjs().isBefore(formatedDate, 'day')) {
                this.restriction.canDrag = false;
                this.restriction.canAdd = true;
                this.restriction.canEdit = false;
            }
        },
        clearErrors() {
            this.errors = {};
            this.clearError();
        },
        toggleAddTaskForm(todoId = null) {
            this.createTask.taskTitle = '';
            this.createTask.todoId = todoId;
            let ref = 'inputRef-' + todoId;
            //this.$refs[ref].focus()
        },
        validateFormData() {
            let __this = this;
            // Todo Title validation ....
            if (__this.createTask.taskTitle.trim() == '') {
                __this.errors.taskTitle = 'Title is required.';
            } else if (__this.createTask.taskTitle.trim().length < 3) {
                __this.errors.taskTitle = 'Title should be at least 3 characters.';
            }
        },
        async submitAddTask(todoId) {
            let __this = this;
            __this.$Progress.start();
            __this.clearErrors();
            __this.createTask.todoId = todoId;

            this.validateFormData();
            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                return;
            }

            await __this.addTask(__this.createTask);

            if (__this.getErrors != null) {
                __this.errors = __this.getErrors;
                __this.$Progress.fail();
                return;
            }
            __this.$Progress.finish();
            __this.createTask.taskTitle = '';
            __this.createTask.todoId = '';
            console.clear();
        },
        getTodosForDate() {
            let __this = this;
            __this.$Progress.start();
            store.dispatch('todo/fetchTodos').then(() => {
                __this.getTodoForDate(__this.date);
                __this.loading = false;
                __this.$Progress.finish();
            });
        },
        dropItem: e => {
            const card_id = e.dataTransfer.getData('card_id');
            const card = document.getElementById(card_id);
            card.style.display = "block";
            e.target.appendChild(card);
        },
        filterDaysOption(todo) {
            this.restriction.canMoveToOtherDate = true;
            if (dayjs().isSame(todo.date, 'date')) {
                this.dayOptions = {Tomorrow: dayjs().add(1, 'day').format("ddd, DD MMM YYYY")};
            } else if (dayjs().isAfter(todo.date, 'day')) {
                this.dayOptions = {
                    Today: "Today",
                    Tomorrow: dayjs().add(1, 'day').format("ddd, DD MMM YYYY")
                };
            } else if (dayjs().isBefore(todo.date, 'day')) {
                this.dayOptions = {Today: "Today"};
            } else {
                this.restriction.canMoveToOtherDate = false;
            }
        },
        showTodoMenu(todo) {
            if (this.todoMenuState.todoId == todo.id) {
                this.todoMenuState.showMenu = false;
                this.todoMenuState.todoId = null;
            } else {
                this.todoMenuState.showMenu = true;
                this.todoMenuState.todoId = todo.id;
            }
            this.filterDaysOption(todo);
        },
        closeTodoMenu() {
            this.todoMenuState.showMenu = false;
            this.todoMenuState.todoId = null;
        },
        showTaskMenu(taskId) {
            if (this.taskMenuState.taskId === taskId) {
                this.taskMenuState.showMenu = false;
                this.taskMenuState.taskId = null;
            } else {
                this.taskMenuState.showMenu = true;
                this.taskMenuState.taskId = taskId;
            }
        },
        closeTaskMenu() {
            this.taskMenuState.showMenu = false;
            this.taskMenuState.taskId = null;
        },
        editTodoShowModal(todo) {
            this.$emit('showTodoFormModal', todo);
        },
        editTaskShowModal(task, todoDate) {
            this.closeTaskMenu();
            this.$emit('showTaskFormModal', {task, todoDate});
        },
        async deleteTodoSubmit(todo) {
            let r = confirm("Are you sure you want to delete this todo.");
            if (r == true) {
                let __this = this;
                __this.$Progress.start();
                __this.clearErrors();

                await __this.deleteTodo(todo);

                if (__this.getErrors != null) {
                    __this.errors = __this.getErrors;
                    __this.$Progress.fail();
                    return;
                }
                __this.closeTaskMenu();
                __this.$Progress.finish();
            }
        },
        async deleteTaskSubmit(task) {
            let r = confirm("Are you sure you want to delete this task.");
            if (r == true) {
                let __this = this;
                __this.$Progress.start();
                __this.clearErrors();

                await __this.deleteTask(task);

                if (__this.getErrors != null) {
                    __this.errors = __this.getErrors;
                    __this.$Progress.fail();
                    return;
                }
                __this.closeTaskMenu();
                __this.$Progress.finish();
            }
        },
        async moveTodoSubmit(dayOption, todoId) {
            let r = confirm("Are you sure you want to move this Todo.");
            if (r == true) {
                let __this = this;
                __this.$Progress.start();
                __this.clearErrors();

                const data = {dayOption: dayOption, todoId: todoId};
                await __this.moveTodo(data);

                if (__this.getErrors != null) {
                    __this.errors = __this.getErrors;
                    __this.$Progress.fail();
                    return;
                }
                __this.closeTodoMenu();
                __this.$Progress.finish();
            }
        },
        copyToClipboard(textToCopy) {
            try {
                navigator.clipboard.writeText(textToCopy);
                store.dispatch('snackbar/addSnack', {color: 'green-500', msg: 'Task title copied to clipboard.'}, {root: true});
                this.closeTaskMenu();
            } catch (e) {
                throw e;
            }
        },
    },
    beforeDestroy() {
        this.date = null;
    }
}
</script>


<style scoped>
.taskMenuBlock {
    cursor: pointer;
    height: 12px;
    width: 12px;
    border-radius: 50%;
    transition: all 200ms;
    position: absolute;
    top: -2px;
    right: -2px;
    z-index: 2;
    overflow: hidden;
}

.taskMenuButton {
    cursor: pointer;
    height: 12px;
    width: 12px;
    border-radius: 50%;
    transition: all 400ms;
    position: absolute;
    top: 0;
    right: 0;
}

.taskMenuBlock.taskMenuExpand {
    padding-top: 1px;
    height: 114px;
    width: 100px;
    border-radius: 6px;
    overflow: auto;
}

.taskMenuItem li {
    text-align: center;
    padding: 10px 10px;
}
</style>
