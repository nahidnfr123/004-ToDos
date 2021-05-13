<template>
    <button :type="type"
            :class="[Replace_Input_Class ? Replace_Input_Class : default_button_styles, Add_Input_Class,
            disabled || processing ? 'hover:bg-indigo-600 cursor-not-allowed' : '']"
            @click.stop.prevent="btnClicked()"
            :disabled="disabled || processing">
        <span class="inline-flex items-center px-2 py-1">
            <svg v-if="processing" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <slot></slot>
        </span>
    </button>
</template>

<script>
import {default_button_style} from "../config";

export default {
    props: {
        type: {
            type: String,
            default: 'submit',
        },
        disabled:{
            type: Boolean,
            default: false
        },
        processing: {
            type: Boolean,
            default: false
        },
        Replace_Input_Class: String, // Replace Existing design ...
        Add_Input_Class: String, // Add more design ...
    },
    data() {
        return {
            default_button_styles: default_button_style,
        }
    },
    methods: {
        btnClicked() {
            this.$emit('button_clicked');
        }
    }
}
</script>
