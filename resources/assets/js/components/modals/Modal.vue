<template>
    <!--Modal-->
    <div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center z-50 py-16">
        <div class="absolute inset-0 w-full h-full bg-gray-800 opacity-90" @click.stop.prevent="closeModal"
             :class="[showModal?'animateInFade':'']">
        </div>

        <div class="modal-container bg-gray-200 dark:bg-gray-900 w-11/12 md:max-w-md mx-auto rounded-md shadow-lg z-50"
             :class="[showModal ? 'animateInFadeDown' : '' , 'startPosition']">

            <!-- Add margin if you want to see some of the overlay behind the modal-->
            <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-2 mb-2 border-b-2 border-gray-300 dark:border-gray-800">
                    <p class="text-2xl font-bold">{{ modalTitle }}</p>
                    <div class="modal-close cursor-pointer z-50" @click.stop.prevent="closeModal">
                        <svg class="fill-current text-black dark:text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>


                <slot name="modalContent"></slot>


                <!--Footer-->
                <!--<div class="flex justify-end pt-2">
                    <button class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">Action</button>
                    <button class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</button>
                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "modal",
    props: {
        showModal: {
            type: Boolean,
            default: false,
        },
        modalTitle: {
            type: String,
            default: "Modal Title",
        },
        /*formType: {
            type: String,
            default: "create",
        },
        data: {
            type: [Object],
            default: () => [],
        },*/
    },
    data() {
        return {}
    },
    methods: {
        closeModal(clearForm = false) {
            this.$emit('closeModal', false);
            if (clearForm === true) this.$emit('clearForm', clearForm);
        },
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
        opacity: 0.7 !important;
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
