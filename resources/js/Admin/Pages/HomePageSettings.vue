<template>
    <div class="container d-flex flex-column p-2">
        <div class="w-100 d-flex justify-content-between">
            <h3 class="text-white text-center flex-grow-1">
                Home page's settings
            </h3>
        </div>

        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Section title</th>
                <th scope="col">Products(IDs)</th>
                <th scope="col">Count to show</th>
                <th scope="col">Is Main</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>

            <template v-if="!settings.length">
                <h4 class="text-white text-center w-100">
                    No setting added yed
                </h4>
            </template>
            <template v-else>
                <tbody>
                    <tr v-for="(setting,index) in settings" :key="setting.id">
                        <th scope="row">
                            {{ index+1 }}
                        </th>
                        <td>
                            {{ setting.section_name }}
                        </td>
                        <td>
                            {{ setting.products }}
                        </td>
                        <td>
                            {{ setting.showable_count }}
                        </td>
                        <td>
                            {{ setting.main }}
                        </td>
                        <td>
                            <div @click="editSetting(setting)" class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa fa-edit"></i>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </template>

        </table>
        <div class="w-100 p-2">
            <form @submit.prevent="saveChanges">
                <div class="form-group">
                    <label> Section name </label>
                    <input type="text" class="form-control"
                           v-model="settingData.section_name"
                           placeholder="Product name"
                    >
                </div>
                <div class="form-group mt-2 ">
                    <div class="d-flex gap-2">
                        <label> Products :</label>
                        <button class="btn btn-primary" type="button" @click="toggleProductSelect">
                            {{ settingData.products.length ? "View" : "Select" }} products
                        </button>
                        <span>
                             {{ settingData.products.length }} selected
                        </span>
                    </div>

                </div>
                <div class="form-group" v-if="settingData.main">
                    <label> Count to show </label>
                    <input type="number"
                             class="form-control"
                           v-model="settingData.showable_count"
                           placeholder="Count to show"
                    >
                </div>
                <div class="form-check form-switch mt-1">
                    <input class="form-check-input" type="checkbox" v-model="settingData.main"
                           role="switch" id="flexSwitchCheckChecked" >
                    <label class="form-check-label" for="flexSwitchCheckChecked">Is Main</label>
                </div>
                <div class="d-flex justify-content-center align-items-center mt-1 gap-2">
                    <button class="btn btn-success" type="submit">
                        Save changes
                    </button>
                    <button class="btn btn-secondary" type="button" @click="dropData">
                        Drop
                    </button>
                    <button class="btn btn-danger" type="button"
                            @click="deleteSection"
                            v-if="settingData.id"
                    >
                        Delete
                    </button>
                </div>
            </form>
        </div>

    </div>

    <teleport to="#app">
        <Modal v-if="productSelectOpened" @close="toggleProductSelect">
            <select-product
                :initial-selected="settingData.products"
                @SELECT_DONE="setProducts"
            />
        </Modal>
    </teleport>
</template>

<script>
import SelectProduct from "./Slider/SelectProduct.vue";
import Modal from "../../SharedComponents/ReusableComponents/Modal.vue";
export default {
    name: "HomePageSettings",
    components:{SelectProduct,Modal},
}
</script>
<script setup>
import {nextTick, onMounted, reactive, ref} from "vue";
import HTTP from "../Axios/axiosCongif";
import {errorNotification, successNotification} from "../../Services/NotificationService";
import {extractValidationErrors} from "../../Services/GlobalHelpers";

    const settings=ref([])
    const productSelectOpened=ref(false)
    const toggleProductSelect = () => {
      productSelectOpened.value=!productSelectOpened.value
    }
    const settingData=reactive({
        id:0,
        section_name:'',
        main:false,
        products:[],
        showable_count:5,

    })

    const setProducts=(products)=>{
        settingData.products=products
        toggleProductSelect()
    }


    const getSettings=()=>{
        HTTP.get('/settings/home')
        .then(({data})=>{
            settings.value=data.setting
        })
    }

    const editSetting=(setting)=>{
        settingData.id=setting.id;
        settingData.showable_count=setting.showable_count;
        settingData.section_name=setting.section_name;
        settingData.products=setting.products;
        settingData.main=setting.main
    }
    const dropData=()=>{
        settingData.id=0;
        settingData.showable_count=5;
        settingData.section_name='';
        settingData.products=[];
        settingData.main=false;
    }

    const saveChanges=()=>{
        let url='/settings/home'
        let method='post'
        let data={
            ...settingData,
        }
        if (!data.main){
            data.showable_count=data.products.length
        }
        if (settingData.id){
            url+='/'+settingData.id;
            method='put'
        }
        HTTP[method](url,data)
        .then(({data})=>{
            if (data.success){
                let notification='Home page setting added successfully';
                if (method==='put'){
                    notification='Home page setting edited successfully'
                }
                successNotification(notification)
                nextTick(()=>{
                    dropData();
                    getSettings()
                })
            }
        }).catch(e=>errorNotification(extractValidationErrors(e)))


    }


    const deleteSection=()=>{
        HTTP.delete('/settings/home/'+settingData.id)
        .then(r=>{
            if (r.status === 204){
                successNotification('Home page section removed successfully')
                nextTick(()=>{
                    dropData();
                    getSettings()
                })
            }
        }).catch(e=>errorNotification(extractValidationErrors(e)))
    }

    onMounted(getSettings)
</script>

<style scoped>
form {
    color: white;
}
</style>
