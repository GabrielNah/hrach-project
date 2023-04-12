<template>
   <div class="container">
       <template v-if="loaded">
               <section class="mt-2 p-2 d-flex flex-column justify-content-center align-items-start">
                   <div class="d-flex flex-row justify-content-between align-items-center w-100">
                           <h5 class="text-center text-capitalize text-white">Categories diagram</h5>
                           <button class="btn btn-dark"
                                   @click="getCategoriesWithSubCategories">Reload Categories diagram</button>
                       </div>
                       <div class="w-100 d-flex flex-row" >
                           <template v-if="categories.length">
                                <ul class="list-group  w-50">
                               <li class="list-group-item list-group-item-primary mb-1" v-for="category in categories" :key="category.id">

                                   <div class="d-flex w-100 justify-content-between mb-2">
                                       <span>
                                           {{ category.name }}
                                       </span>
                                       <div>
                                           <button class="btn btn-primary " @click="startEditing(category)">Edit</button>
                                           <button class="btn btn-danger margin-left" @click="deleteCategory(category.id)">Delete</button>
                                       </div>
                                   </div>

                                   <ul class="list-group" v-if="category?.sub_categories?.length">
                                       <li  class="list-group-item d-flex flex-row justify-content-between align-items-center"
                                            v-for="subCategory in category?.sub_categories" :key="subCategory.id">
                                           <span>
                                               {{ subCategory.name }}
                                           </span>
                                           <div>
                                               <button class="btn btn-primary " @click="startEditing(subCategory,category)">Edit</button>
                                               <button class="btn btn-danger margin-left" @click="deleteCategory(subCategory.id)">Delete</button>
                                           </div>
                                       </li>
                                   </ul>
                               </li>
                           </ul>
                           </template>
                           <div class="w-50  d-flex justify-content-center align-items-center" v-if="editableItem">
                               <form @submit.prevent="saveChanges" id="categoryForm" class="w-100 margin-left d-flex flex-column justify-content-center bordered p-2 border-gray" style="margin-left: 40px" >
                                   <div class="form-group row ">
                                       <h3 class="text-center text-white">Category data</h3>
                                   </div>
                                   <hr/>
                                   <div class="form-group row ">
                                       <label for="staticEmail" class="col-sm-2 col-form-label text-white">Name</label>
                                       <div class="col-sm-10">
                                           <input type="text" placeholder="Category name" name="name"
                                                  class="form-control w-75" id="staticEmail"
                                                    :value="editableItem?.name??''">
                                       </div>
                                   </div>
                                   <hr/>
                                   <div class="form-group row mt-2 ">
                                       <div class="d-flex justify-content-between">
                                           <label  class="col-sm-2 col-form-label " style="width: 20%">
                                               <p class="p-0 m-0 text-white" style="word-break: keep-all">Subcategory of</p>
                                           </label>
                                           <select name="parent" :disabled="!editableItem?.parent" class="form-select  mr-2" style="width: 70%"  aria-label="Default select example">
                                               <option value="0">Choose SubCategory</option>
                                               <option :value="categorie?.id" v-for="categorie in categories"
                                                       :key="categorie.id"
                                                        :selected="editableItem?.parent?.name === categorie.name">
                                                   {{ categorie.name }}
                                               </option>
                                           </select>
                                       </div>
                                   </div>
                                   <hr/>
                                   <div class="form-check form-group form-switch row mt-2 " style="padding-left: 0">
                                       <label class="col-sm-2 form-check-label d-flex pl-0 flex-row w-100" >
                                           <p class="text-white">Category is active</p>
                                         <input class="form-check-input" :checked="editableItem?.active" style="margin-left: 40px" name="active" value="1" type="checkbox"  >
                                       </label>
                                   </div>
                                   <hr/>
                                   <div class="w-100 d-flex justify-content-center mt-2 ">
                                       <button type="submit" class="btn btn-primary">Save</button>
                                       <button type="button" @click="dropEditing" class="btn btn-secondary margin-left">Drop</button>
                                   </div>
                               </form>
                           </div>
                       </div>


                   <p class="text-info" v-if="!categories?.length && !editableItem">There is no category yet</p>
               </section>

           <div class="w-100 d-flex justify-content-start align-items-center" style="margin-left: 20%">
               <button class="btn btn-secondary" @click="startAddingCategory">
                   Add Category
               </button>
           </div>

           <div class="container mt-2">
               <h3 class="w-100 text-center text-white">Categories to show in header</h3>
               <multiselect :unique-key="'id'"
                            :showable-key="'name'"
                            :initial-values="categoriesInHeader"
                            :values="categoriesWithSubCategory"
                            @selected="setCategoriesToShow"
               />
               <div class="w-100 d-flex justify-content-center mt-2">
                   <button type="button" class="btn-success btn w-25"
                    @click="makeShowable"
                   >
                       Save
                   </button>
               </div>
           </div>
       </template>
       <loader v-else/>
   </div>
</template>

<script>
import {computed, nextTick, onMounted, ref} from "vue";
import HTTP from "../Axios/axiosCongif";
import useLoader from "../../GlobalComposables/useLoader";
import Loader from "../../SharedComponents/Loader.vue";
import {errorNotification, successNotification} from "../../Services/NotificationService";
import {extractValidationErrors} from "../../Services/GlobalHelpers";
import Multiselect from "../../SharedComponents/ReusableComponents/Multiselect.vue";

export default {
    name: "Categories",
    components:{
        Multiselect,
        Loader,
    },
    setup(){
        const categories=ref([]);
        const editableItem=ref(null);

        const categoriesToShow=ref([])
        const setCategoriesToShow=(cts)=>categoriesToShow.value=cts
        const makeShowable=()=>{
            const ids=categoriesToShow.value.map(ct=>ct.id)
            HTTP.put('/category/showable',{ids})
            .then(async ({data})=>{
                if (data.success){
                    successNotification('Categories are made presentable')
                    await getCategoriesWithSubCategories()
                }
            })
            .catch(e=>errorNotification(extractValidationErrors(e)))
        }
        const categoriesInHeader=computed(()=>{
            if (!categories.value.length){
                return [];
            }
            return  categories.value.filter((ct)=>ct.in_header)
        })

        const categoriesWithSubCategory=computed(()=>{
            if (!categories.value.length){
                return [];
            }
            return  categories.value.filter((ct)=>!!(ct?.sub_categories))
        })


        const setCategories = (versions) => {
          categories.value=versions
        }
        const {loaded,setLoaded}=useLoader()
        const startAddingCategory=()=>{
            editableItem.value={parent:{}}
        }
        const startEditing=(category,parentCategory=null)=>{
            editableItem.value= {...category,...{parent:parentCategory}}
        }
        const saveChanges=async ()=>{
            try {
                loaded.value=false
                const form=document.querySelector('#categoryForm');
                const data=new FormData(form)
                let {data:{success}}=await HTTP.post(`/category/store/${editableItem.value?.id ??''}`,data)
                editableItem.value=null
                setLoaded()
                await nextTick()
                if (success){
                    successNotification('Reload category diagram to view changes','Success');
                }
            }catch (e) {
                setLoaded()
                await nextTick()
                errorNotification(extractValidationErrors(e))
            }



        }
        const dropEditing=()=>editableItem.value=null
        const getCategoriesWithSubCategories=async ()=>{
            try {
                loaded.value=false;
                let {data:{categories}}=await HTTP.get('/category')
                setCategories(categories)
                setLoaded()
            }catch (e) {
                console.log(e)
            }
        }


        const deleteCategory = async (category_id) => {
            try {

            let response=await HTTP.delete('/category/'+category_id)
            if (response.status === 204){
                successNotification('Reload diagram to view changes','Deleted successfully')
            }
            }catch (e) {
                errorNotification(extractValidationErrors(e))
            }
        }


        onMounted( ()=>{
          getCategoriesWithSubCategories()
        })

        return {
            loaded,
            categories,
            getCategoriesWithSubCategories,
            editableItem,
            startAddingCategory,
            dropEditing,
            startEditing,
            saveChanges,
            deleteCategory,
            categoriesInHeader,
            categoriesWithSubCategory,
            setCategoriesToShow,
            makeShowable
        }

    },
}
</script>

<style scoped>
.margin-left{
    margin-left: 5px;
}
.bordered{
    border: 1px solid black;
    border-radius: 8px;
}
</style>
