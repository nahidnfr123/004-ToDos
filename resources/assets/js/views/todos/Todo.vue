<template>
    <div class="w-full overflow-hidden mt-8 mb-8">
        <h3 class="text-lg font-bold">My Todo List</h3>
        <!--<div class="w-full rounded-lg shadow-xs overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-2 py-3 text-sm">
                        <label class="inline-flex items-center mt-3">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-red-500 bg-red-600 dark:text-red-800"
                                   :disabled="!todos">
                        </label>
                    </th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Date</th>
                </tr>
                </thead>
                <tbody v-if="todos" class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                <tr v-for="(todo, index) in todos" :key="todo.id" class="text-gray-700 dark:text-gray-400">
                    <td class="px-2 py-3 text-sm">
                        <label class="inline-flex items-center mt-1">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-red-500 bg-red-600 dark:text-red-800">
                        </label>
                    </td>
                    <td class="px-4 py-3">
                        <p class="font-semibold">{{ todo.title | capitalize }}</p>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ todo.description }}
                    </td>
                    <td class="px-4 py-3 text-xs">
                            <span v-if="todo.status" class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                              Completed
                            </span>
                        <span v-else class="px-2 py-1 font-semibold leading-tight text-green-700 bg-red-100 rounded-full dark:bg-red-600 dark:text-green-100">
                              Incomplete
                            </span>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ todo.todo_date | dateFormatCustom }}
                    </td>
                </tr>
                </tbody>
                <tbody v-else>
                <tr v-show="loading == false" class="bg-red-500 h-4 text-white bg-opacity-50 py-4 px-2  text-center">
                    <td colspan="5" class="h-4 py-4">
                        No Data Available.
                    </td>
                </tr>
                </tbody>
            </table>
        </div>-->
        <!-- Pagination -->

        <!--<template v-if="todos">
                    <div class="mt-10" v-for="(todo, index) in todos" :key="index">
                        <div class="text-xs pb-2 text-pink-500">
                            <router-link :to="{ name:'TodoItems', params:{id:todo.id}}">{{ todo.todo_date | dateFormatForTodo("ddd, DD MMM YYYY") }}</router-link>
                        </div>
                        <div class="flex flex-row flex-wrap content-start">
                            <div class="flex-auto mr-2 mt-2 w-60 md:max-w-full">
                                <div class="rounded shadow bg-white dark:bg-gray-800 hover:shadow-md">
                                    <div class="px-4 py-3 border-b-2 border-pink-500">
                                        <h3 class="font-bold">{{ todo.title }}</h3>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ todo.description }}</p>
                                    </div>
                                    <div class="text-xs" v-if="todo.todo_tasks">
                                        <p class="flex flex-row align-middle  p-2 px-6 hover:bg-gray-100 dark:hover:bg-gray-900"
                                           v-for="(item, i) in todo.todo_tasks" :key="i">
                                                        <span>
                                                            <svg id="Capa_1" enable-background="new 0 0 497 497" height="20px" viewBox="0 0 497 497" width="20px" xmlns="http://www.w3.org/2000/svg"><g><path d="m425 48v439c0 5.52-4.48 10-10 10h-333c-5.52 0-10-4.48-10-10v-439c0-5.52 4.48-10 10-10h333c5.52 0 10 4.48 10 10z" fill="#fad207"/><path d="m88 87.349v386.57c0 3.911 3.17 7.081 7.081 7.081h201.777c2.652 0 5.196-1.054 7.071-2.929l77.071-77.071v-319h-273.074l-1.686-12.171-13.79 9.202c-2.781 1.855-4.45 4.976-4.45 8.318z" fill="#faa515"/><path d="m395 78v309l-60 22-20 58h-203c-5.523 0-10-4.477-10-10v-379c0-5.523 4.477-10 10-10h273c5.523 0 10 4.477 10 10z" fill="#f5f5f5"/><path d="m395 387-80 80v-70c0-5.523 4.477-10 10-10z" fill="#e6e6e6"/><path d="m349.14 68v19.43c0 13.78-11.22 25-25 25h-151.28c-13.78 0-25-11.22-25-25v-19.43z" fill="#e6e6e6"/><path d="m147.86 38h201.28v30h-201.28z" fill="#faa515"/><path
                                                                d="m334.138 37.979v49.447c0 5.523-4.477 10-10 10h-151.276c-5.523 0-10-4.477-10-10v-49.447l55.507.001c-.738-3.171-.989-6.529-.669-9.991 1.382-14.945 13.632-26.88 28.605-27.913 18.078-1.247 33.13 13.049 33.13 30.86 0 2.423-.279 4.782-.806 7.044z" fill="#50758d"/><path d="m171.891 198.096c-1.935 0-3.799-.748-5.198-2.094l-25.337-24.362c-2.986-2.871-3.079-7.619-.208-10.604s7.62-3.078 10.604-.208l19.689 18.933 30.877-35.051c2.737-3.107 7.477-3.409 10.586-.67 3.107 2.738 3.408 7.478.67 10.586l-36.056 40.929c-1.353 1.535-3.273 2.451-5.317 2.535-.103.004-.207.006-.31.006z" fill="#5ed297"/><path d="m344 177.631h-106c-4.143 0-7.5-3.357-7.5-7.5s3.357-7.5 7.5-7.5h106c4.143 0 7.5 3.357 7.5 7.5s-3.357 7.5-7.5 7.5z" fill="#50758d"/><path
                                                                d="m171.891 286.327c-1.935 0-3.799-.748-5.198-2.094l-25.337-24.362c-2.986-2.871-3.079-7.619-.208-10.604 2.871-2.986 7.62-3.079 10.604-.208l19.701 18.943 30.929-34.971c2.743-3.103 7.483-3.394 10.587-.649 3.103 2.744 3.394 7.484.649 10.587l-36.109 40.827c-1.354 1.53-3.273 2.442-5.315 2.525-.101.004-.203.006-.303.006z" fill="#5ed297"/><g fill="#50758d"><path d="m344 265.5h-106c-4.143 0-7.5-3.357-7.5-7.5s3.357-7.5 7.5-7.5h106c4.143 0 7.5 3.357 7.5 7.5s-3.357 7.5-7.5 7.5z"/><path d="m344 356.631h-17.5c-4.143 0-7.5-3.357-7.5-7.5s3.357-7.5 7.5-7.5h17.5c4.143 0 7.5 3.357 7.5 7.5s-3.357 7.5-7.5 7.5z"/><path d="m291.5 356.631h-53.5c-4.143 0-7.5-3.357-7.5-7.5s3.357-7.5 7.5-7.5h53.5c4.143 0 7.5 3.357 7.5 7.5s-3.357 7.5-7.5 7.5z"/></g><path d="m199 379.631h-46c-4.143 0-7.5-3.357-7.5-7.5v-46c0-4.143 3.357-7.5 7.5-7.5h46c4.143 0 7.5 3.357 7.5 7.5v46c0 4.142-3.357 7.5-7.5 7.5zm-38.5-15h31v-31h-31z" fill="#fd646f"/></g></svg>
                                                        </span>
                                            <span>{{ item.title }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>-->

        <!-- Backend Group by Date -->
        <template v-if="todos.length">
            <div class="mt-10 mb-8" v-for="(days, d) in groupedTodos" :key="d">
                <div class="text-xs pb-2 text-pink-600">
                    <router-link :to="{name:'Todo Task', params:{date:d}}">{{ d | dateFormatCustom('ddd, DD MMM YYYY') }}</router-link>
                </div>
                <div class="flex flex-row flex-wrap content-start">
                    <div class="flex-auto mr-2 mt-2 w-60 md:max-w-full" v-for="todo in days" :key="todo.id">
                        <div class="rounded-md shadow bg-white dark:bg-gray-800 hover:shadow-md">
                            <div class="px-4 py-3 border-b-2 border-pink-500 flex align-middle justify-between">
                                <h3 class="font-bold"
                                    :class="{'line-through text-green-500 dark:text-green-300':todo.status==1}">
                                    {{ todo.title | capitalize }}
                                </h3>
                                <button class="bg-red-500 hover:bg-red-600 shadow text-white mt-0 py-1 px-2 rounded-md text-xs">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="text-xs" v-if="todo.todo_tasks">
                                <div class="flex flex-row items-center space-x-2 p-2 px-6 hover:bg-gray-100 dark:hover:bg-gray-900"
                                     v-for="task in todo.todo_tasks" :key="task.id">
                                    <span v-if="task.status == 'completed'">
                                        <svg class="p-0.5 w-5 h-5 stroke-current text-green-500 dark:text-green-300 feather feather-check-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                           <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                           <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                       </svg>
                                    </span>
                                    <span v-else-if="task.status == 'doing'">
                                        <svg class="w-5 h-5 stroke-current text-yellow-600 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                          <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/>
                                          <rect x="9" y="3" width="6" height="4" rx="2"/>
                                          <path d="M9 14l2 2l4 -4"/>
                                        </svg>
                                    </span>
                                    <span v-else>
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                    </span>
                                    <p :class="[{'line-through text-green-500 dark:text-green-300':task.status=='completed'}, {'text-yellow-600 dark:text-yellow-400':task.status=='doing'}]">
                                        {{ task.title | capitalize }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="animate-bounce mt-2 text-sm text-center text-gray-400 dark:text-gray-600">
                Showing todos for last 7 days.
            </div>
        </template>
        <div v-else>
            <Loading v-if="loading === true"/>
            <div v-else class="mt-4 text-xs text-white bg-red-500 bg-opacity-80 rounded px-4 py-4 text-center">
                <p>No data found!</p>
            </div>
        </div>

    </div>
</template>

<script>
//import todoStore from '../../store/todo';
import {mapState} from 'vuex';
import store from '../../store';

export default {
    name: 'Todo-Lists',
    data() {
        return {
            env: process.env.MIX_APP_NAMES,
            loading: true,
            todo: [],
        }
    },
    computed: {
        ...mapState({
            todos: state => state.todo.todos,
            groupedTodos: state => state.todo.groupedTodos,
        }),
    },
    created() {

    },
    mounted() {
        this.getTodos();
    },
    methods: {
        getTodos() {
            let __this = this;
            __this.$Progress.start();
            store.dispatch('todo/fetchTodos').then(() => {
                __this.loading = false;
                __this.$Progress.finish();
            }).catch(error => {
                __this.loading = false;
                __this.$Progress.fail();
            });
        },
        getTodoForDate(date) {
            let __this = this;
            let res = __this.todos.filter(o => Object.values(o).includes(date));
            __this.todo = res;
            console.log(res);
        }
    }
}
</script>


<style scoped>
[x-cloak] {
    display: none;
}

[type="checkbox"] {
    box-sizing: border-box;
    padding: 0;
}

.form-checkbox {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-print-color-adjust: exact;
    color-adjust: exact;
    display: inline-block;
    vertical-align: middle;
    background-origin: border-box;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    flex-shrink: 0;
    color: currentColor;
    background-color: #fff;
    border-color: #e2e8f0;
    border-width: 1px;
    border-radius: 0.25rem;
    height: 1.2em;
    width: 1.2em;
}

.form-checkbox:checked {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M5.707 7.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4a1 1 0 0 0-1.414-1.414L7 8.586 5.707 7.293z'/%3e%3c/svg%3e");
    border-color: transparent;
    background-color: currentColor;
    background-size: 100% 100%;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
