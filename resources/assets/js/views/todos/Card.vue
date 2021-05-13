<template>
    <div class="flex-auto w-60 md:max-w-full mr-2 mt-2 py-3 rounded-md shadow bg-white dark:bg-gray-800 flex-no-shrink w-64 p-2 mr-3"
         :class="AddClass">
        <h3 class="text-center font-bold">{{ title }}</h3>
        <div class="listDropZone relative rounded pb-6 px-1 pt-1 text-sm mt-2 bg-gray-500 bg-opacity-40"
             :id="id"
             :cardType="status"
             @dragover.prevent
             @dragenetr.prevent
             @drop.prevent="dropItem($event, todoId)">

            <slot name="Item"/>

        </div>

        <slot name="Button"/>

    </div>
</template>

<script>
import {mapActions, mapState} from "vuex";
import store from "../../store";

export default {
    name: 'TodoItem',
    props: ['id', 'title', 'AddClass', 'status', 'todoId', 'todoData'],
    data() {
        return {
            taskUpdateData: {
                taskId: '',
                status: this.status,
            },
            errors: {},
        }
    },
    computed: {
        ...mapState({
            getErrors: state => state.todo.error
        }),
    },
    methods: {
        ...mapActions({
            updateTask: 'todo/updateTask',
        }),
        dropItem(e, todoId) {
            const card_id = e.dataTransfer.getData('card_id');
            const todo_id = e.dataTransfer.getData('todo_Id');
            const card = document.getElementById(card_id);
            // Prevent from dropping tasks in different todo ...
            if (todoId == todo_id) {
                e.target.appendChild(card);
                card.style.display = "block";
                this.taskUpdateData.taskId = card_id.replace('item-', '');
                this.updateTaskStatus();
            } else {
                store.dispatch('snackbar/addSnack', {color: 'red-500', msg: 'Task dropped in wrong todo list!'}, {root: true});
            }
        },
        async updateTaskStatus() {
            let __this = this;
            __this.$Progress.start();

            await __this.updateTask(this.taskUpdateData);

            if (__this.getErrors != null) {
                __this.errors = __this.getErrors;
                store.dispatch('snackbar/addSnack', {
                    color: 'red-500',
                    msg: 'Error: ' + __this.errors.task
                }, {root: true})
                    .then(() => {
                        __this.$Progress.fail();
                    });
                return;
            }
            __this.$Progress.finish();
        }
    },
}
</script>

<style scoped>
.listDropZone {
    min-height: 40px;
    max-height: 100%;
    width: 100%;

}
</style>
