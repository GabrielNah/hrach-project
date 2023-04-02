<template>
    <div class="w-100 p-1 ">
        <!-- HTML !-->
        <h4 class="text-center text-white"> What do you want to edit ?</h4>
        <div class="d-flex justify-content-between align-items-center">
            <button class="button-37" role="button" @click="actions.selectAction(actions.ACTIONS.EDIT_FILES)">
                Files
            </button>
            <button class="button-37" role="button" @click="actions.selectAction(actions.ACTIONS.EDIT_PRICES)">
                Prices
            </button>
            <button class="button-37" role="button" @click="actions.selectAction(actions.ACTIONS.EDIT_ADDITIONAL_INFO)">
                Additional info
            </button>
            <button class="button-37" role="button" @click="actions.selectAction(actions.ACTIONS.EDIT_MAIN_INFO)">
                Main info
            </button>
        </div>

    </div>
    <div class="container pt-2">
        <product-details ref="productPage" :key="key"/>
    </div>

    <teleport to="#app">
        <Modal v-if="chosenAction" @close="actions.selectAction('')">
            <edit-files v-if="chosenAction === actions.ACTIONS.EDIT_FILES" />
            <template v-if="chosenAction === actions.ACTIONS.EDIT_MAIN_INFO">
                <h1>main</h1>
            </template>
            <template v-if="chosenAction === actions.ACTIONS.EDIT_ADDITIONAL_INFO">
                <h1>add</h1>
            </template>
            <template v-if="chosenAction === actions.ACTIONS.EDIT_PRICES">
                <h1>price</h1>
            </template>
        </Modal>

    </teleport>
</template>

<script>
import {computed, ref, watch, watchEffect} from "vue";
import ProductDetails from "../../../SharedComponents/Product/ProductDetails.vue";
import Modal from "../../../SharedComponents/ReusableComponents/Modal.vue";
import EditFiles from "./EditProduct/EditFiles.vue";
export default {
    name: "EditProduct",
    components: {EditFiles, ProductDetails,Modal},
    setup(){
        const key = ref(0)
        const rerenderProduct=()=>{
            key.value++
        }
        const productPage = ref(null)
        const product = computed(()=>productPage.value.product)
        const actionsControlInstance = () => {
            const selectedAction = ref('')
            const selectAction = (action)=>{
                selectedAction.value=action
            }
            const ACTIONS={
                EDIT_PRICES:'edit_prices',
                EDIT_MAIN_INFO:'edit_main',
                EDIT_FILES:'edit_files',
                EDIT_ADDITIONAL_INFO:'edit_additional',
            };

            return{
                selectedAction,
                selectAction,
                ACTIONS
            }
        }
        const actions=actionsControlInstance()
        const chosenAction=computed(()=>actions.selectedAction.value)

        watch(()=>chosenAction.value,(val,old)=>{
            if (!val && old){
                rerenderProduct()
            }
        })



        return {
            productPage,
            product,
            actions,
            chosenAction,
            key
        }
    }
}
</script>

<style scoped lang="scss">
.button-37 {
    background-color: #13aa52;
    border: 1px solid #13aa52;
    border-radius: 4px;
    box-shadow: rgba(0, 0, 0, .1) 0 2px 4px 0;
    box-sizing: border-box;
    color: #fff;
    cursor: pointer;
    font-family: "Akzidenz Grotesk BQ Medium", -apple-system, BlinkMacSystemFont, sans-serif;
    font-size: 16px;
    font-weight: 400;
    outline: none;
    outline: 0;
    padding: 10px 25px;
    text-align: center;
    transform: translateY(0);
    transition: transform 150ms, box-shadow 150ms;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
}

.button-37:hover {
    box-shadow: rgba(0, 0, 0, .15) 0 3px 9px 0;
    transform: translateY(-2px);
}

@media (min-width: 768px) {
    .button-37 {
        padding: 10px 30px;
    }
}

</style>
