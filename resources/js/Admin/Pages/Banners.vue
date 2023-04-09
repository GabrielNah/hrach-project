<template>
    <div class="d-flex container flex-column ">
        <banners-component :key="key">
            <template #default="{banner}">
                <button class="btn btn-success btn-sm rounded-0 position-absolute" @click="selectBanner(banner)"
                     style="top: 10px;right: 10px;z-index: 200"
                     type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                    <i class="fa fa-edit"></i>
                </button>
            </template>
        </banners-component>
        <section class="d-flex flex-column w-100 p-1 m-0">
            <form @submit.prevent="wrapWithinProcess(actionsHandler.saveChanges)">
                <div class="form-group">
                    <label class="text-white"> Banner title </label>
                    <input type="text" class="form-control"
                           v-model="banner.title"
                           placeholder="Product name"
                    >
                </div>
                <div class="form-group">
                    <label class="text-white"> Banner Link text </label>
                    <input type="text" class="form-control"
                           v-model="banner.link_text"
                           placeholder="Product name"
                    >
                </div>
                <div class="form-group">
                    <label class="text-white"> Banner description </label>
                    <textarea type="text" class="form-control"
                           v-model="banner.description"
                           placeholder="Product name"
                    ></textarea>
                </div>
                <div class="w-100 d-flex flex-column">
                    <label class="text-white">Banners image</label>
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
                                 v-if="banner.image.value"
                                 :src="'/'+banner.image.value"
                                 style="width: 45%;height: 300px"
                            />
                            <div class="position-relative  align-self-start h-100 "
                                 style="width: 45%;height: 300px"
                                 v-if="banner.image.uploaded.value"
                            >
                                <img class="product_color_image w-100"
                                     style="width: 45%;height: 300px"
                                     :src="banner.image.uploaded.path"
                                />
                                <button class="btn btn-close btn-danger position-absolute bg-danger" style="top: 0;right: 0"
                                        @click="fileUploader.removeFile"
                                >
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label class="text-white">Group of products :</label>
                    <label class="text-white btn btn-secondary ml-1"
                           @click="productSearchHandler.toggleProductSearch">
                        {{ banner.value.length ? "View" : "Select" }} products
                    </label>
                        <span class="fonted text-white">
                            {{ banner.value.length }} product selected
                        </span>
                </div>
                <div class="d-flex justify-content-center align-items-center mt-1 gap-1 "
                >
                    <button class="btn btn-primary" type="submit">
                        Save changes
                    </button>
                    <button class="btn btn-secondary " type="button"
                            @click="actionsHandler.dropBanner"
                    >
                        Drop
                    </button>
                    <button class="btn btn-danger" type="button" v-if="banner.id"
                        @click="wrapWithinProcess(actionsHandler.removeBanner)"
                    >
                        Delete
                    </button>
                </div>
            </form>
        </section>
    </div>
    <teleport to="#app">
        <Modal v-if="productSearchOpened">
            <select-product
                :initial-selected="banner.value"
                @SELECT_DONE="productSearchHandler.getSearchResult"
            />
        </Modal>
    </teleport>
</template>

<script>
import Modal from "../../SharedComponents/ReusableComponents/Modal.vue";
import BannersComponent from "../../SharedComponents/BannersComponent.vue";
import SelectProduct from "./Slider/SelectProduct.vue";
import processWrappes from "../../Mixins/processWrappes";
export default {
    name: "Banners",
    mixins:[processWrappes],
    components: {BannersComponent,Modal,SelectProduct}
}
</script>
<script setup>
 import useComponentReloader from "../Composables/useComponentReloader";
 import {nextTick, reactive, ref} from "vue";
 import HTTP from "../Axios/axiosCongif";
 import {errorNotification, successNotification} from "../../Services/NotificationService";
 import {extractValidationErrors} from "../../Services/GlobalHelpers";


 const {key,reloadComponent}=useComponentReloader()

 const banner=reactive({
     id:0,
     title:'',
     description:'',
     link_text:'',
     image:{
         value:'',
         uploaded:{
             value:null,
             path:''
         }
     },
     value:[]
 })

 const productSearchOpened=ref(false)


 const selectBanner=(bannerData)=>{
     banner.id=bannerData.id
     banner.title=bannerData.title
     banner.description=bannerData.description
     banner.link_text=bannerData.link_text
     banner.value=bannerData.value
     banner.image.value = bannerData.image
 }
 const fileUploader = {
     getFile(e){
         banner.image.uploaded.value = e.target.files[0]
         this.getFilePath(e.target.files[0])
             .then((path)=>banner.image.uploaded.path = path)

     },
     async getFilePath(file){
         return new Promise((resolve)=>{
             const reader=new FileReader();
             reader.onload=()=>{
                 resolve(reader.result)
             }
             reader.readAsDataURL(file)
         })
     },
     removeFile(){
         banner.image.uploaded.value=null
         banner.image.uploaded.path=""
     }
 }

 const productSearchHandler={
     toggleProductSearch(){
         productSearchOpened.value=!productSearchOpened.value
     },
     getSearchResult(prods){
         banner.value = prods
         productSearchHandler.toggleProductSearch()
     }
 }

 const actionsHandler={
     saveNew(){
         const data=new FormData;
         data.append('title',banner.title)
         data.append('description',banner.description)
         data.append('link_text',banner.link_text)
         data.append('image',banner.image.uploaded.value)
         banner.value.forEach((id)=>data.append('value[]',id))

         HTTP.post('/banners',data)
         .then(({data})=>{
             if (data.success){
                 successNotification('Created successfully, reloading banners to view changes')
                 nextTick(()=>{
                     actionsHandler.dropBanner()
                     reloadComponent()
                 })
             }
         })
         .catch((e)=>errorNotification(extractValidationErrors(e)))
     },
     updateExisting(){
         const data=new FormData;
         data.append('title',banner.title)
         data.append('description',banner.description)
         data.append('link_text',banner.link_text)
         if (banner.image.uploaded.value){
             data.append('image',banner.image.uploaded.value)
         }
         data.append('_method','PUT')
         banner.value.forEach((id)=>data.append('value[]',id))

         HTTP.post(`/banners/${banner.id}`,data)
             .then(({data})=>{
                 if (data.success){
                     successNotification('Updated successfully, reloading banners to view changes')
                     nextTick(()=>{
                         actionsHandler.dropBanner()
                          reloadComponent()
                     })
                 }
             })
             .catch((e)=>errorNotification(extractValidationErrors(e)))
     },
     removeBanner(){
         HTTP.delete(`/banners/${banner.id}`)
         .then((r)=>{
             if (r.status === 204){
                 successNotification('Removed successfully, reloading banners to view changes')
                 nextTick(()=>{
                     actionsHandler.dropBanner()
                      reloadComponent()
                 })
             }
         }).catch((e)=>errorNotification(extractValidationErrors(e)))
     },
     saveChanges(){
         if (banner.id){
             actionsHandler.updateExisting();
             return;
         }
         actionsHandler.saveNew();
     },
     dropBanner(){
         banner.id=0
         banner.title=''
         banner.description=''
         banner.link_text=''
         banner.value=[]
         banner.image.value = ''
         banner.image.uploaded.path=''
         banner.image.uploaded.value=null
     }
 }


</script>

<style scoped>

</style>
