<template>
    <div class="d-flex w-50 flex-column">
        <h4 class="text-center text-white bg-dark">Product Main info</h4>
        <form @submit.prevent="wrapWithinProcess(saveChanges)" >
            <div class="form-group">
                <label> Name </label>
                <input type="text" class="form-control"
                       v-model="productInfo.name"
                       placeholder="Product name"
                >
            </div>
            <div class="form-group">
                <label> Title </label>
                <input type="text" class="form-control"
                       v-model="productInfo.title"
                       placeholder="Product name"
                >
            </div>
            <div class="form-group">
                <label> Rating </label>
                <div class="d-flex align-items-center" style="padding-left: 5px">
                    <svg v-for="i in 5" fill="none" height="15" viewBox="0 0 16 15" width="16"
                         @click="setRating(i)"
                         xmlns="http://www.w3.org/2000/svg">
                        <path :fill="i <= productInfo.rating ?'#FF9017':'#D5CDC5'" clip-rule="evenodd" d="M8 12.0553L12.944 15L11.632 9.45L16 5.71579L10.248 5.23421L8 0L5.752 5.23421L0 5.71579L4.368 9.45L3.056 15L8 12.0553Z"
                              fill-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="form-group">
                <label >Description</label>
                <textarea class="form-control" v-model="productInfo.description"></textarea>
            </div>
            <div class="form-group">
                <label >Category</label>
                <select class="form-control" v-model="productInfo.category">
                    <option v-for="category in allCategories" :key="category.id"
                        v-bind="{'selected':category.id === productInfo.category}"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </select>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" v-model="productInfo.active" role="switch" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">Is Active</label>
            </div>
            <div class="d-flex justify-content-center align-items-center mt-1">
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
        </form>
    </div>
</template>

<script>
import processWrappes from "../../../../Mixins/processWrappes";

export default {
    name: "EditMainInfo",
    mixins:[processWrappes]
}
</script>
<script setup>
import {computed, onMounted, reactive, ref} from "vue";
 import {useRoute} from "vue-router";
 import HTTP from "../../../Axios/axiosCongif";
import {errorNotification, successNotification} from "../../../../Services/NotificationService";
import {extractValidationErrors} from "../../../../Services/GlobalHelpers";
 const allCategories = ref([]);
 const productInfo = reactive({
     name:'',
     title:'',
     rating:0,
     description:'',
     category:0,
     active:false
 })
 const route = useRoute()
 const productId = computed(()=>route.params.id)
 const setRating = (rating)=>productInfo.rating = rating
 const getProductsMainInfo = ()=>{
     HTTP.get(`/product/main/${productId.value}`)
     .then(({data})=>{
        allCategories.value = data.categories
        productInfo.name = data.product.name;
        productInfo.title = data.product.title;
        productInfo.description = data.product.description;
        productInfo.rating = data.product.rating;
        productInfo.active = data.product.active;
        productInfo.category = data.product.category.id;
     })
 }

 const saveChanges = ()=>{
     HTTP.post(`/product/main/${productId.value}`,{...productInfo})
     .then(({data})=>{
         productInfo.name = data.product.name;
         productInfo.title = data.product.title;
         productInfo.description = data.product.description;
         productInfo.rating = data.product.rating;
         productInfo.active = data.product.active;
         productInfo.category = data.product.category.id;
         successNotification('Products main info modified successfully')
     })
     .catch((e)=>errorNotification(extractValidationErrors(e)))
 }

 onMounted(getProductsMainInfo)
</script>

<style scoped>

</style>
