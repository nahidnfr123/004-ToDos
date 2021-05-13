<template>
    <div class="animateInSnackbar rounded-md shadow-md hover:shadow-lg transition-all text-white text-sm w-72 mt-2"
         :class="typeClass"
         @mouseenter.prevent="clearTimer()"
         @mouseleave.prevent="createTimer(1000)">
        <div class="flex justify-between py-3 px-4">
            <div class="flex flex-row space-x-2 items-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                </div>
                <p>{{ snack.msg }}</p>
            </div>

            <button class="rounded-md text-gray-300 hover:text-white hover:ring-1 hover:ring-white focus:outline-none focus:ring-2 focus:ring-white"
                    type="button" data-dismiss="alert" @click="closeSnack(snack)">
                <span class="sr-only">Close panel</span>
                <!-- Heroicon name: x -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="h-2 w-full px-1">
            <div class="bg-white rounded-md h-1 mb-1" style="width: 0" :style="'width:'+progressBar.progress+'%'"></div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: 'SnackbarMSG',
    props: ['snack'],
    data() {
        return {
            timeout: null,
            progressBar: {
                timer: null,
                progress: 0,
            },
        }
    },
    computed: {
        typeClass() {
            return `bg-${this.snack.color} dark:bg-${this.snack.color}`;
        }
    },
    created() {
        this.createTimer()
    },
    beforeDestroy() {
        clearTimeout(this.timeout);
        clearTimeout(this.progressBar.timer);
    },
    methods: {
        ...mapActions({
            removeSnack: 'snackbar/removeSnack'
        }),
        clearTimer() {
            clearTimeout(this.timeout);
            this.progressBar.progress = 0;
            clearInterval(this.progressBar.timer);
        },
        createTimer(time = 4000) {
            this.progressBarStart(time / 100);
            this.timeout = setTimeout(() => {
                this.closeSnack();
            }, time);
        },
        closeSnack(snack = this.snack) {
            this.removeSnack(snack);
        },
        progressBarStart(time = 30) {
            this.progressBar.progress = 0;
            this.progressBar.timer = setInterval(() => {
                if (this.progressBar.progress >= 100) {
                    clearInterval(this.progressBar.timer);
                } else {
                    this.progressBar.progress++;
                }
            }, time);
        }
    },
}
</script>

<style scoped>
.animateInSnackbar {

}
</style>
