<template>
    <div class="container">
        <div class="w-100 d-flex flex-column p-1">
            <slider-component/>
            <section class="d-flex flex-column w-100 p-1 m-0">
                <form >
                    <div class="form-group">
                        <label class="text-white"> Slider title </label>
                        <input type="text" class="form-control"
                               v-model="slider.title"
                               placeholder="Product name"
                        >
                    </div>
                    <div class="form-group">
                        <label class="text-white"> Slider Link text </label>
                        <input type="text" class="form-control"
                               v-model="slider.link_text"
                               placeholder="Product name"
                        >
                    </div>
                    <div class="w-100 d-flex flex-column">
                        <label class="text-white">Slides image</label>
                        <div class="form-group w-100 d-flex justify-content-between" style="max-height: 300px">

                            <label class="position-relative btn btn-secondary btn-sm align-self-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                </svg>
                                <input type="file"
                                       class="position-absolute d-none"
                                       style="left: 0;right: 0;bottom: 0;top: 0"
                                >
                            </label>
                            <div class="flex-grow-1 d-flex justify-content-between align-items-center p-1" >
                                <img class="product_color_image " style="width: 45%;max-height: 300px"
                                />
                                <div class="position-relative  align-self-start h-100 " style="width: 45%;max-height: 300px"
                                >
                                    <img class="product_color_image w-100"
                                    />
                                    <button class="btn btn-close btn-danger position-absolute bg-danger" style="top: 0;right: 0"
                                    >
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="text-white btn btn-dark" @click="toggleProductSearch">
                            Select products
                        </label>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-1">
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
    <teleport to="#app">
        <Modal v-if="searchProductsIsOpen" @close="toggleProductSearch">
            <select-product/>
        </Modal>
    </teleport>

</template>

<script>
import SliderComponent from "../../../SharedComponents/SliderComponent.vue";
import Modal from "../../../SharedComponents/ReusableComponents/Modal.vue";
export default {
    name: "SliderMaker",
    components: {SliderComponent,Modal}
}
</script>
<script setup>
import {reactive, ref, watch} from "vue";
import SelectProduct from "./SelectProduct.vue";
const searchProductsIsOpen=ref(false);
const toggleProductSearch=()=>{
    searchProductsIsOpen.value=!searchProductsIsOpen.value
}
const slider=reactive({
    title:'',
    link_text:'',
    img:{
        uploaded:'',
        value:'',
    },
    values:null
})




</script>

<style scoped>

</style>
