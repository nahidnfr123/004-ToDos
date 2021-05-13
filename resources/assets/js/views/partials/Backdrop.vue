<template>
    <div>
        <div v-show="isSideMenuOpen" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
             @click.stop.prevent="closeSideMenu">
        </div>

        <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
               v-show="isSideMenuOpen" @click.away="closeSideMenu" @keydown.escape="closeSideMenu">
            <div class="py-4 text-gray-500 dark:text-gray-400">
                <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
                    ToDo App NFR
                </a>
                <ul class="mt-6">
                    <li class="relative px-6 py-3">
                        <span class="isActiveIndicator absolute inset-y-0 left-0 w-1 bg-blue-400 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                        <router-link to="/" active-class="active-nav" class="p-2 pr-4 pl-4 rounded-lg inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-300 dark:text-gray-200">
                            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="ml-4">Dashboard</span>
                        </router-link>
                    </li>
                </ul>
                <ul>
                    <li class="relative px-6 py-3">
                        <span class="isActiveIndicator absolute inset-y-0 left-0 w-1 bg-blue-400 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                        <router-link to="/todo-lists" active-class="active-nav" class="p-2 pr-4 pl-4 rounded-lg inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-300 dark:text-gray-200">
                            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="ml-4">Todo List</span>
                        </router-link>
                    </li>

                </ul>
                <div class="px-6 my-6">
                    <button class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Create account
                        <span class="ml-2" aria-hidden="true">+</span>
                    </button>
                </div>
            </div>
        </aside>
    </div>
</template>

<style scoped>
.navFade-enter, .navFade-leave-to {
    opacity: 0;
    transform: translateX(-4em);
}

.navFade-enter-active, .navFade-leave-active {
    transition: all .3s ease;
}
</style>

<script>
export default {
    name: 'backdrop',
    data(){
        return{

        }
    },
    props: {
        isSideMenuOpen: Boolean,
    },
    methods: {
        togglePagesMenu() {

        },
        closeSideMenu() {
            this.$emit('isSideMenuOpen', !this.isSideMenuOpen);
        }
    }
}
</script>
