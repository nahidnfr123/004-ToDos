<template>
    <div class="relative flex h-screen bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300" :class="{ 'overflow-hidden': isSideMenuOpen }">

        <!-- Desktop sidebar -->
        <SideNav
            v-if="authenticated"
            @showTodoFormModal="showTodoFormModal=true"
            formType='create'
            :currentDateTimeValue="currentDateTimeValue"
        ></SideNav>
        <!-- Mobile sidebar -->

        <!-- Backdrop -->
        <Backdrop
            v-if="authenticated"
            @showTodoFormModal="showTodoFormModal=true"
            :currentDateTimeValue="currentDateTimeValue"
            formType='create'
            :isSideMenuOpen="isSideMenuOpen"
        ></Backdrop>

        <div class="flex flex-col flex-1 w-full">

            <!-- Top header -->
            <TopHeader
                v-if="authenticated"
                :isSideMenuOpen="isSideMenuOpen"
                @isSideMenuOpen="sideMenuOpen"
                :user="user"
            ></TopHeader>

            <main id="mainContainer" class="h-full relative overflow-y-auto overflow-x-hidden">
                <div class="container px-6 mx-auto grid">

                    <!-- Load Contents -->
                    <transition name="fade" mode="out-in">
                        <router-view :BaseUrl="BaseUrl" :user="user" @showTaskFormModal="editTaskModal" @showTodoFormModal="editTodoModal"></router-view>
                    </transition>

                </div>
            </main>
        </div>

        <!-- Add and Edit todo modal -->
        <TodoFormModal
            v-if="authenticated && showTodoFormModal"
            :showTodoFormModal="showTodoFormModal"
            :formType="formType"
            @closeModal="showTodoFormModal=false"
            :data="editTodoData"
        />

        <!-- Edit task modal -->
        <TaskFormModal
            v-if="authenticated && showTaskFormModal"
            :showTaskFormModal="showTaskFormModal"
            formType="update"
            @closeModal="showTaskFormModal=false"
            :data="editTaskData"
        />

        <snackbar/>

        <vue-progress-bar></vue-progress-bar>
    </div>

</template>

<script>
import SideNav from '../views/partials/SideNav';
import Header from '../views/partials/Header';
import Backdrop from '../views/partials/Backdrop';
import TodoFormModal from '../components/modals/TodoForm';
import TaskFormModal from '../components/modals/TaskForm';
import Snackbar from "../CustomComponents/Snackbar/components/Snackbar";

import {mapGetters, mapActions} from 'vuex';
import dayjs from "dayjs";
import Modal from "../components/modals/Modal";

export default {
    name: 'TodoAppMain',
    components: {
        Modal,
        Snackbar,
        SideNav,
        'TopHeader': Header,
        Backdrop,
        TodoFormModal,
        TaskFormModal,
    },
    data() {
        return {
            BaseUrl: 'http://127.0.0.1:8000/',
            isSideMenuOpen: false,
            closeSideMenu: false,
            showTodoFormModal: false,
            showTaskFormModal: false,
            currentDateTimeValue: {
                time: '',
                date: ''
            },
            editTaskData: null,
            editTodoData: null,
            formType: "create"
        }
    },
    methods: {
        ...mapActions({
            logoutAction: 'auth/logout'
        }),
        editTaskModal(e) {
            this.showTaskFormModal = true;
            this.editTaskData = e;
        },
        editTodoModal(e) {
            this.showTodoFormModal = true;
            this.editTodoData = e;
            this.formType = "update";
        },
        sideMenuOpen(e) {
            this.isSideMenuOpen = e;
        },
        async logout() {
            await this.logoutAction();
            await this.$router.replace({name: 'Login'});
        },
        themeChanger() {
            if (this.getCookie('theme') == 'light') {
                let html = document.getElementsByTagName('html')[0];
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    this.createThemeCookie('theme', 'light', 90);
                } else {
                    html.classList.add('dark');
                    this.createThemeCookie('theme', 'dark', 90);
                }
            }
        },
        createThemeCookie(cName, cValue, exDays) {
            let d = new Date();
            d.setTime(d.getTime() + (exDays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cName + "=" + cValue + ";" + expires + ";path=/";
        },
        getCookie(cName) {
            let name = cName + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        currentDateTime() {
            this.currentDateTimeValue.date = dayjs().format("DD MMM YYYY, dddd");
            this.currentDateTimeValue.time = dayjs().format("hh:mm:ss, A");
            setTimeout(this.currentDateTime, 1000);
        },
    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
        }),
    },
    mounted() {
        this.isSideMenuOpen = false;
        this.$Progress.finish();

        this.themeChanger();
        this.currentDateTime();
    },
    created() {
        // **** Progressbar Start *** //
        //  [App.vue specific] When App.vue is first loaded start the progress bar
        this.$Progress.start()
        //  hook the progress bar to start before we move router-view
        this.$router.beforeEach((to, from, next) => {
            //  does the page we want to go to have a meta.progress object
            if (to.meta.progress !== undefined) {
                let meta = to.meta.progress
                // parse meta tags
                this.$Progress.parseMeta(meta)
            }
            //  start the progress bar
            this.$Progress.start()
            // Scroll to top ...
            document.getElementById('mainContainer').scrollTo(0, 0);
            //  continue to next page
            next()
        })
        //  hook the progress bar to finish after we've finished moving router-view
        this.$router.afterEach((to, from) => {
            //  finish the progress bar
            this.$Progress.finish()
        })
        // **** Progressbar end **** //
    }
}
</script>

<style>
.isActiveIndicator {
    opacity: 0;
}

.router-link-exact-active.active-nav {
    background-color: dodgerblue !important;
    color: white;
}

.fade-enter, .fade-leave-to {
    opacity: 0;
    transform: translateX(2em);
}

.fade-enter-active, .fade-leave-active {
    transition: all .3s ease;
}
</style>
