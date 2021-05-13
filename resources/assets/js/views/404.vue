<template>
    <div class="h-screen w-full flex items-center justify-center align-middle ">
        <div class="text-center py-4 lg:px-4">
            <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none rounded-full flex lg:inline-flex" role="alert">
                <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">404</span>
                <span class="font-semibold mr-2 text-left flex-auto">Page Not Found!</span>
                <button class="rounded-full bg-blue-500 p-1 ml-2 shadow transition duration-500 ease-in-out hover:bg-blue-400 hover:shadow-lg" @click="$router.go(-1)">
                    <svg class="fill-current opacity-100 h-4 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'page_not_found',
}
</script>
