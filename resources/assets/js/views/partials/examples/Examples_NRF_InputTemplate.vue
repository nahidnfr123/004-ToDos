<template>
    <div>
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Example component
        </h2>

        <!-- Cards -->
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-2">
            <form action="">

                <div>
                    <h1 class="text-white mb-2">My form</h1>
                    <hr class="mb-4">

                    <!-- Text Input -->
                    <Custom_Text_Input
                        class="mb-5"
                        label="Text Box"
                        id="text_box"
                        type="text"
                        placeholder="Text Input"
                        v-model="textbox"
                        :error="errors.text && Array.isArray(errors.text) ? errors.text[0] : errors.text"
                        Add_Input_Class="h-10"
                    />

                    <!-- Number Input -->
                    <Custom_Text_Input
                        class="mb-5"
                        label="Number Input"
                        id="text_number"
                        type="number"
                        placeholder="Number Input"
                        v-model="numberInput"
                        :error="errors.numberInput && Array.isArray(errors.numberInput) ? errors.numberInput[0] : errors.numberInput"
                        Add_Input_Class="h-10"
                    />

                    <!-- Date Input -->
                    <Custom_Text_Input
                        class="mb-5"
                        label="Date Input"
                        id="dateInput"
                        type="date"
                        placeholder="Date Input"
                        v-model="dateInput"
                        :error="errors.dateInput && Array.isArray(errors.dateInput) ? errors.dateInput[0] : errors.dateInput"
                        Add_Input_Class="h-10"
                    />

                    <!-- Textarea -->
                    <Custom_Text_Input
                        class="mb-5"
                        label="Textarea"
                        id="textarea"
                        type="textarea"
                        placeholder="Textarea"
                        v-model="textarea"
                        :error="errors.textarea && Array.isArray(errors.textarea) ? errors.textarea[0] : errors.textarea"
                        Add_Input_Class="resize-none"
                    />

                    <!-- Radio Input -->
                    <div class="flex">
                        <Custom_Radio_Input
                            class="mb-5"
                            type="radio"
                            label="Gender Radio"
                            id="gender"
                            name="Gender"
                            v-model="gender"
                            :error="errors.gender && Array.isArray(errors.gender) ? errors.gender[0] : errors.gender"
                            :options="{male:'Male', female:'Female', others:'Others'}"
                            orientation="flex"
                        />
                    </div>

                    <!-- Checkbox Input -->
                    <div class="flex">
                        <Custom_MultipleCheckbox_Input
                            class="mb-5"
                            id="checkbox"
                            type="checkbox"
                            v-model="checkbox"
                            :error="errors.checkbox && Array.isArray(errors.checkbox) ? errors.checkbox[0] : errors.checkbox"
                            name="CheckBox"
                            label="Check Box"
                            :options="{apple:'Apple', mango:'Mango', orange:'Orange', pineapple:'Pineapple'}"
                        />
                    </div>
                </div>


                <div class="mb-10">
                    <h3 class="mb-2">Select Components</h3>
                    <hr class="mb-4">

                    <!-- Select Input 1 -->
                    <Custom_Select_Input
                        class="mb-5"
                        label="Select Option 'String'"
                        id="select"
                        type="select"
                        placeholder="Select an option"
                        v-model="selectStringOption"
                        :error="errors.selectStringOption && Array.isArray(errors.selectStringOption) ? errors.selectStringOption[0] : errors.selectStringOption"
                        Add_Input_Class="px-4 h-10"
                        :options="stringOptions"
                    />

                    <!-- Select Input 2 -->
                    <Custom_Select_Input
                        class="mb-5"
                        label="Select Option 'Array/Object'"
                        id="select2"
                        type="select"
                        placeholder="Select an option"
                        Add_Input_Class="px-4 h-10"
                        :options="objectOptions"
                        v-model="selectObjectOption"
                        :error="errors.selectObjectOption && Array.isArray(errors.selectObjectOption) ? errors.selectObjectOption[0] : errors.selectObjectOption"
                    />

                    <!-- Select Input 3 -->
                    <Custom_Select_Input
                        class="mb-5"
                        label="Select Option 'Dynamic Options & Value'"
                        id="select3"
                        type="select"
                        placeholder="Select an option"
                        Add_Input_Class="px-4 h-10"
                        :options="dynamicOptionValue"
                        displayProperty="dayName"
                        valueProperty="id"
                        v-model="selectDynamicOptionValue"
                        :error="errors.selectDynamicOptionValue && Array.isArray(errors.selectDynamicOptionValue) ? errors.selectDynamicOptionValue[0] : errors.selectDynamicOptionValue"
                    />
                    <!--
                        ref="DynamicSelect"
                        :validation="['required']"
                        @errorsEvent="errors.selectDynamicOptionValue = $event"
                        -->
                </div>


                <div class="mb-10">
                    <h3 class="mb-2">Switch Component</h3>
                    <hr class="mb-4">
                    <!-- Switch Input -->
                    <Switch_Input
                        class="mb-5"
                        label="Switch Input"
                        switchLabel="Toggle Switch"
                        id="switchInput"
                        v-model="switchInput"
                        :error="errors.switchInput && Array.isArray(errors.switchInput) ? errors.switchInput[0] : errors.switchInput"
                    />
                </div>

                <Custom_Loading_Button type="button" @button_clicked="alertMe">
                    Custom Button
                </Custom_Loading_Button>

                <input class="mt-6 text-white bg-blue-600 py-2 px-4 rounded-lg shadow-md text-sm font-semibold cursor-pointer hover:bg-blue-500"
                       type="submit" value="Submit" name="Submit" @click.stop.prevent="submitForm">
            </form>

        </div>
    </div>
</template>


<script>
// #-Notes: Form Components are registered as global components in app.js file.
export default {
    name: "ExampleFormComponents",
    data() {
        return {
            textbox: '',
            numberInput: '',
            dateInput: '',
            textarea: '',
            gender: '',
            checkbox: [],
            selectStringOption: "",
            selectObjectOption: "",
            selectDynamicOptionValue: "",
            stringOptions: ['Apple', 'Orange', 'Banana', 'Pineapple', 'Pumpkin', 'Mango', 'Guava'],
            objectOptions: [
                {id: 1, name: "Bengali"},
                {id: 2, name: "English"},
                {id: 3, name: "Arabic"},
            ],
            dynamicOptionValue: [
                {id: 1, value: "sun", dayName: "Sunday", slug: "Sun"},
                {id: 2, value: "mon", dayName: "Monday", slug: "Mon"},
                {id: 3, value: "tue", dayName: "Tuesday", slug: "Tue"},
                {id: 4, value: "wed", dayName: "Wednesday", slug: "Wed"},
                {id: 5, value: "thurs", dayName: "Thursday", slug: "Thurs"},
                {id: 6, value: "fri", dayName: "Friday", slug: "Fri"},
                {id: 7, value: "sat", dayName: "Saturday", slug: "Sat"},
            ],
            switchInput: false,
            repeater: [
                {
                    user_name: ''
                },
            ],
            errors: {},
        }
    },
    methods: {
        submitForm() {
            let __this = this;
            __this.errors = {};

            // Manual Validation ....
            if (!__this.textbox.trim()) __this.errors.text = 'Textbox field is required';
            if (!__this.numberInput.trim()) __this.errors.numberInput = 'Number Input field is required';
            if (!__this.dateInput.trim()) __this.errors.dateInput = 'Date Input field is required';
            if (!__this.textarea.trim()) __this.errors.textarea = 'Textarea field is required';
            if (!__this.gender.trim()) __this.errors.gender = 'Gender Input field is required';
            if (!__this.selectObjectOption) __this.errors.selectObjectOption = 'selectObjectOption field is required';
            if (!__this.selectDynamicOptionValue) __this.errors.selectDynamicOptionValue = 'selectDynamicOptionValue field is required';
            if (!__this.switchInput) __this.errors.switchInput = 'Switch Input field is required';

            // Automated Validation ....
            /*if (!this.$refs.ArrayObjectSelect.validateForm()) ;
            if (!this.$refs.DynamicSelect.validateForm()) ;*/

            if (Object.keys(__this.errors).length) {
                console.log('Form Has Errors!');
                return;
            }
        },
        alertMe() {
            alert('button clicked');
        },
        getErrors(e, errorFieldName) {
            this.errors.selectDynamicOptionValue = e;
        },
    },
    mounted() {

    }
};
</script>
