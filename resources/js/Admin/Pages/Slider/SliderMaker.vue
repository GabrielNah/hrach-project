<template>
    <div class="container">
        <div class="w-100 d-flex flex-column p-1">
            <slider-component :key="key">
                <template #default="{slider}">
                    <div class="btn btn-success btn-sm rounded-0" @click="editProduct(slider)"
                         type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                        <i class="fa fa-edit"></i>
                    </div>
                </template>
            </slider-component>
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
                                       @change="fileUploader.getFile"
                                       style="left: 0;right: 0;bottom: 0;top: 0"
                                >
                            </label>
                            <div class="flex-grow-1 d-flex justify-content-between align-items-center p-1" >
                                <img class="product_color_image "
                                     v-if="slider.img.value"
                                     :src="'/'+slider.img.value"
                                     style="width: 45%;height: 300px"
                                />
                                <div class="position-relative  align-self-start h-100 "
                                     style="width: 45%;height: 300px"
                                    v-if="slider.img.uploaded.value"
                                >
                                    <img class="product_color_image w-100"
                                         style="width: 45%;height: 300px"
                                         :src="slider.img.uploaded.path"
                                    />
                                    <button class="btn btn-close btn-danger position-absolute bg-danger" style="top: 0;right: 0"
                                        @click="removeUploadedImage"
                                    >
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="text-white">Group of products :</label>
                        <label class="text-white btn btn-secondary ml-1" @click="toggleProductSearch">
                            {{ slider.values.length ? "View" : "Select" }} products
                        </label>
                        <span class="fonted text-white">
                            {{ slider.values.length ?? "0" }} product selected
                        </span>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-1"
                        @click="wrapWithinProcess(actionsWithSlides.addNew)"
                    >
                        <button class="btn btn-primary" type="button">Save changes</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
    <teleport to="#app">
        <Modal v-if="searchProductsIsOpen" @close="toggleProductSearch">
            <select-product
                :initial-selected="slider.values"
                @SELECT_DONE="setProducts"
            />
        </Modal>
    </teleport>

</template>

<script>
import SliderComponent from "../../../SharedComponents/SliderComponent.vue";
import Modal from "../../../SharedComponents/ReusableComponents/Modal.vue";
import SelectProduct from "./SelectProduct.vue";
import processWrappes from "../../../Mixins/processWrappes";
export default {
    name: "SliderMaker",
    components: {SliderComponent,Modal,SelectProduct},
    mixins:[processWrappes]
}
</script>
<script setup>
import {reactive, ref, watch} from "vue";
import HTTP from "../../Axios/axiosCongif";
import {errorNotification, successNotification} from "../../../Services/NotificationService";
import {extractValidationErrors} from "../../../Services/GlobalHelpers";
const searchProductsIsOpen=ref(false);
const toggleProductSearch=()=>{
    searchProductsIsOpen.value=!searchProductsIsOpen.value
}
const removeUploadedImage = ()=>{
    slider.img.uploaded.path='';
    slider.img.uploaded.value=null
}
const editProduct=(product)=>{
    slider.id =product.id
    slider.title=product.id
    slider.link_text = product.link_text
    slider.values = product.value
    slider.img.value = product.image
}
const key = ref(1)
const reloadSlider=()=>key.value++

const actionsWithSlides={
    addNew(){
        const data=new FormData
        data.append('title',slider.title)
        data.append('link_text',slider.link_text)
        slider.values.forEach((id)=>data.append('value[]',id))
        data.append('image',slider.img.uploaded.value)

        HTTP.post('/slider/store',data)
        .then(({data})=>{
            if (data.success){
                successNotification('Reloading slider component to view changes');
                slider.title=""
                slider.link_text=""
                slider.values=[]
                slider.img.uploaded.value=null
                slider.img.uploaded.path=''
                slider.img.value=''
                reloadSlider();
                return;
            }
        })
        .catch(e=>errorNotification(extractValidationErrors(e)))
    }
}

const fileUploader = {
    getFile(e){
        slider.img.uploaded.value = e.target.files[0]
        this.getFilePath(e.target.files[0])
            .then((path)=>slider.img.uploaded.path = path)

    },
    async getFilePath(file){
        return new Promise((resolve)=>{
            const reader=new FileReader();
            reader.onload=()=>{
                resolve(reader.result)
            }
            reader.readAsDataURL(file)
        })
    }
}
const slider=reactive({
    id:'',
    title:'',
    link_text:'',
    img:{
        uploaded: {
            path:'',
            value:null
        },
        value:'',
    },
    values:[]
})

const setProducts=(prods)=>{
    slider.values = prods
    toggleProductSearch()
}


</script>

<style scoped>

</style>
