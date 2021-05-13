<template>
    <div class="fixed z-50 bottom-2 right-2" v-if="snacks.length">
        <snackbar-m-s-g v-for="snack in snacks" :key="snack.id" :snack="snack"/>
    </div>
</template>

<script>
import SnackbarMSG from "./SnackbarMSG";
import { mapState } from "vuex"
export default {
    name: 'Snackbar',
    components: {
        SnackbarMSG
    },
    computed:{
        ...mapState({
            snacks: state => state.snackbar.snacks,
        })
    }
}
</script>

