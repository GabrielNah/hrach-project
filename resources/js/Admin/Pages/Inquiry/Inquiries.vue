<template>
    <div class="w-100 container">
        <div class="w-100 d-flex justify-content-between">
            <h4 class="text-white text-center flex-grow-1">Inquiries</h4>
            <button class="text-white p-2 btn btn-dark"
                @click="toggleEditHotKeysModal(true)"
            >
                Edit Hot Keys
            </button>
        </div>
    </div>

    <teleport to="#app">
        <Modal v-if="EditHotKeysOpened"
            @close="toggleEditHotKeysModal(false)"
        >
            <edit-hot-keys/>

        </Modal>
    </teleport>
</template>
<script setup>
import {ref} from "vue";

const EditHotKeysOpened=ref(false)
const toggleEditHotKeysModal=(state)=>EditHotKeysOpened.value=state
</script>
<script>
import EditHotKeys from "./EditHotKeys.vue";
import Modal from "../../../SharedComponents/ReusableComponents/Modal.vue";
export default {
    name: "Inquiries",
    components:{
        Modal,
        EditHotKeys
    }
}
</script>

<style scoped>

</style>
