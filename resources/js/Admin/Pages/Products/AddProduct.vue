<template >
    <loader v-if="loaded"/>
    <div v-else class="container-fluid">


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Basic Information</h4>
                        <p class="card-title-desc">Fill all information below</p>

                        <div class="w-100 d-flex flex-row">
                            <form class="w-50" id="productMainData">
                                <div class="row w-100">
                                    <div class="col-sm-6 w-100">
                                        <div class="form-group">
                                            <label >Category</label>
                                            <select class="form-select" aria-label="Default select example" name="category">
                                                <option value="0" selected></option>
                                                <option :value="category.id" v-for="category in categories" :key="category.id" >
                                                    {{ category.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="productname">Product Name</label>
                                            <input id="productname" name="name" type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="manufacturername">Product title</label>
                                            <input id="manufacturername" name="title" type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="productdesc">Product Description</label>
                                            <textarea class="form-control" id="productdesc" rows="5" name="description"></textarea>
                                        </div>
                                        <div class="form-group ">
                                            <label >Rating</label>
                                            <input class="form-control" min="0"  max="5" type="number" name="rating" >
                                        </div>
                                        <div class="d-flex flex-column mt-2 p-1" style="border: 1px solid #050a1b">
                                            <h4 class="text-center text-white w-100 bg-dark">Sizes</h4>
                                            <div class="form-group mt-2">
                                                <div class="d-flex justify-content-between w-100 ">
                                                    <label>Individual Sizes</label>
                                                    <button type="button" class="btn btn-primary" @click="individualSizes.addSize">Add One</button>
                                                </div>
                                                <div class="w-100 d-flex align-items-start justify-content-center mt-1 position-relative"
                                                     v-for="(i,index) in individualSizes.sizesCount.value"
                                                     :key="i.id"
                                                >
                                                    <input type="text" class="w-100" style="height:30px " name="individual_size_name[]" placeholder="name"/>

                                                    <button class="btn btn-close"  @click.self="individualSizes.removeOne(i.id)" type="button"></button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>General Sizes</label>
                                                <multiselect :values="sizes" @selected="setSize" :unique-key="'id'" :showable-key="'size'"/>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column mt-2 p-1" style="border: 1px solid #050a1b">
                                            <h4 class="text-center text-white w-100 bg-dark">Colors</h4>
                                            <div class="form-group mt-2">
                                                <div class="d-flex justify-content-between w-100 ">
                                                    <label>Individual Colors</label>
                                                    <button type="button" class="btn btn-primary" @click="individualColors.addColor">Add One</button>
                                                </div>
                                                <div class="w-100 d-flex align-items-start mt-1 position-relative"
                                                     v-for="(i,index) in individualColors.colorsCount.value"
                                                     :key="i.id"
                                                >
                                                    <input type="text" style="height:30px " name="individual_colors_name[]" placeholder="name"/>

                                                    <label class="position-relative btn btn-secondary btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                                        </svg>
                                                        <input type="file"
                                                               class="position-absolute d-none"
                                                               style="left: 0;right: 0;bottom: 0;top: 0"
                                                               name="individual_colors[]"
                                                               @change="individualColors.handleFileUpload($event,i.id)"
                                                        >
                                                    </label>
                                                    <div class="flex-grow-1 d-flex justify-content-center align-items-center">
                                                        <img class="w-75" :id="'individual_size'+i.id"/>
                                                    </div>
                                                    <button class="btn btn-close"  @click.self="individualColors.removeOne(i.id)" type="button"></button>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label>General Colors</label>
                                                <multiselect :values="colors" @selected="setColors" :unique-key="'id'" :showable-key="'name'"/>
                                            </div>
                                        </div>
                                        <div class="form-group mt-1" >
                                            <label>Tags</label>
                                            <multiselect :values="existingTags" @selected="setTags" :unique-key="'id'" :showable-key="'name'"/>
                                        </div>
                                        <div class="form-group p-1" style="border: 1px solid #050a1b">
                                            <h4 class="text-white bg-dark w-100 text-center">Prices</h4>
                                            <div class="form-group ">
                                                <label>Price for one</label>
                                                <input class="form-control" name='price_for_one' type="text">
                                            </div>
                                            <label >Prices for many</label>
                                            <div class="d-flex flex-row justify-content-between border p-1 position-relative mt-2" v-for="price in priceCount" :key="price.id">
                                                <div class="form-group ">
                                                    <label>Price</label>
                                                    <input class="form-control" name='prices[]' type="text">
                                                </div>
                                                <div class="form-group ">
                                                    <label>Min set</label>
                                                    <input class="form-control" name='counts_min[]' type="text">
                                                </div>
                                                <div class="form-group ">
                                                    <label>Max max</label>
                                                    <input class="form-control" name='count_max[]' type="text">
                                                </div>
                                                 <button type="button" class="btn-close position-absolute" @click="removePrice(price)"></button>
                                            </div>
                                            <button type="button" @click="addPrice" class="btn btn-primary mt-2">Add price</button>
                                        </div>
                                        <div class="form-check form-group form-switch">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Product is active</label>
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="is_active">
                                        </div>
                                        <div class="form-check form-group form-switch">
                                            <label class="form-check-label">Product is is stock
                                            <input class="form-check-input" type="checkbox" value="yes" name="in_stock">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <main class="w-50 d-flex flex-column">
                                <h3 class="card-title text-center">Product files</h3>
                                <section v-if="files.length+1">
                                    <figure class="general_image card position-relative">
                                        <figcaption class="fw-bold card-title mt-1">Products files</figcaption>
                                        <div v-if="selectedFile" class="checkmark tooltipp" @click="setGeneralFile(selectedFile)">

                                            <template v-if="fileIsGeneral(selectedFile)">
                                                <span class="text text-success fw-bold">File is marked as general</span>
                                            </template>
                                            <template v-else>
                                                <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check " viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                                </svg>
                                                <span class="tooltiptext"> Mark as general</span>
                                            </template>


                                        </div>
                                        <template v-if="selectedFile">
                                            <template v-if="getFilesType(selectedFile) === 'video'">
                                                <video controls :src="getFilesUrl(selectedFile)" class="w-100 card-img"  ></video>
                                            </template>
                                            <template v-if="getFilesType(selectedFile) === 'image'">
                                                <img :src="getFilesUrl(selectedFile)"  class=" card-img"  />
                                            </template>
                                        </template>
                                    </figure>
                                    <div class="d-flex w-100 files_wrapper" style="max-width: 100%">
                                        <div class="position-relative"  v-for="(file,index) in files" :key="index">
                                            <template v-if="getFilesType(file) === 'video'">
                                                <video :src="getFilesUrl(file)" @click="setSelectedFile(file)" class="product_image" muted autoplay style="width: 150px"></video>
                                            </template>
                                            <template v-if="getFilesType(file) === 'image'">
                                                <img :src="getFilesUrl(file)" @click="setSelectedFile(file)" class="product_image"  style="width: 150px"/>
                                            </template>
                                            <button type="button" @click="removeImage(index)" class="btn-close"  aria-label="Close"></button>
                                        </div>
                                    </div>
                                </section>
                                <h5 class="card-text" v-else>No file selected</h5>
                                <div class="w-100 d-flex justify-content-between mt-2">
                                    <div class="btn btn-primary position-relative" style="width: 25%">
                                        <input type="file"
                                               multiple
                                               @change="displayFiles($event)"
                                               ref="fileUploader"  class=" file_input" />
                                        Add  files
                                    </div>
                                </div>
                            </main>
                        </div>


                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Meta Data</h4>
                        <p class="card-title-desc">Fill all information below</p>

                        <form id="metaDataForm">
                            <div class="col">
                                <div class="d-flex flex-row w-50 justify-content-between" v-for="i in metadataCount" :key="i.id">
                                    <div class="form-group">
                                        <label >Meta data name</label>
                                        <input  name="metaDataName[]" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label >Meta data value</label>
                                        <input  name="metaDataValue[]" type="text" class="form-control">
                                    </div>
                                    <div class="position-relative remove-metadat-btn">
                                        <button type="button" class="btn-close" @click="removeMetaData(i)"></button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary mt-2" @click="addMetadata">Add meta data</button>
                            </div>
                            <div class="btn-group mt-2">
                                <button type="button" @click="addProduct" class="btn btn-success mr-1 waves-effect waves-light">Save Changes</button>
                                <button type="button" @click="reload" class="btn btn-secondary waves-effect" style="margin-left: 5px">Cancel</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <teleport to="#app">
        <modal v-if="modalOpened" @close="closeModal">
            <div>
                <template v-for="(file,index) in files">
                    <template v-if="getFilesType(index) === 'video'">
                        <video :src="getFilesUrl(file)" muted autoplay @click="removeImage(index)" style="width: 150px"></video>
                    </template>
                    <template v-if="getFilesType(index) === 'image'">
                        <img :src="getFilesUrl(file)" @click="removeImage(index)" style="width: 150px"/>
                    </template>
                </template>
            </div>
        </modal>
        </teleport>




    </div>
</template>

<script>
import Multiselect from "../../../SharedComponents/ReusableComponents/Multiselect.vue";
import Modal from "../../../SharedComponents/ReusableComponents/Modal.vue";
import {getCurrentInstance, ref, watch} from "vue";
import useProductFileUploading, {
    useAddProductsInitialData, useIndividualColors, useIndividualSizeHandler,
    useMetaDataHandler, usePriceAdder, useProductSizeAndColorSetter
} from "../../Composables/useProductFileUploading";
import useLoader from "../../../GlobalComposables/useLoader";
import Loader from "../../../SharedComponents/Loader.vue";
import HTTP from "../../Axios/axiosCongif";
import {errorNotification, infoNotification, successNotification} from "../../../Services/NotificationService";
import {extractValidationErrors, redirectToRouteByName} from "../../../Services/GlobalHelpers";
import {useRouter} from "vue-router";
import {ADMIN_PRODUCT_EDIT} from "../../../router/Admin/adminRoutes";

export default {
    name: "AddProduct",
    components: {Loader, Modal, Multiselect},
    setup(){
        const {loaded,setLoaded}=useLoader()
        const reload=()=>window.location.reload()
        const metadata=useMetaDataHandler()
        const fileUploading=useProductFileUploading();
        const initialData=useAddProductsInitialData();
        const priceAdder=usePriceAdder();
        const colorAndPrice=useProductSizeAndColorSetter()
        const individualColors = useIndividualColors()
        const individualSizes = useIndividualSizeHandler()
        const router = useRouter()

        const handleEmptyInputs=(e)=>{
            if (!e.target.value.trim()){
                e.target.value=null
            }
        }

        const addProduct=async ()=>{
            try {
                // setLoaded(true)
                const productInfo=new FormData(document.querySelector('#productMainData'))
                const productMetaData=new FormData(document.querySelector('#metaDataForm'))
                for (const [key,value] of productMetaData) {
                    productInfo.append(key,value)
                }
                productInfo.append('general_file',fileUploading.generalFile.value)
                const files=allFiles(fileUploading.files.value,fileUploading.generalFile.value)??[]
                for(let i=0; i<files.length; i++) {
                    productInfo.append('files[]', files[i]);
                }

                colorAndPrice.tags.value.forEach((val)=>{
                    if (!val?.id){
                        return
                    }
                    productInfo.append('tags[]',val.id)
                })
                colorAndPrice.color.value.forEach((val)=>{
                    if (!val?.id){
                        return
                    }
                    productInfo.append('colors[]',val.id)
                })
                colorAndPrice.size.value.forEach((val)=>{
                    if (!val?.id){
                        return
                    }
                    productInfo.append('sizes[]',val.id)
                })
                infoNotification('Inserting products, please wait')
                let {data}=await HTTP.post('/product/store',productInfo)
                // setLoaded(false)
                if (data.success){
                    successNotification('Auto opening product details','Product added successfully')
                    setTimeout(()=>{
                        router.push({
                            name:ADMIN_PRODUCT_EDIT,
                            params:{id:data.product_id}
                        })
                    },2000)
                }

            }catch (e) {
                errorNotification(extractValidationErrors(e))
            }
            setLoaded(false)



        }

        const allFiles=(all,general)=>{
            const index=all.findIndex(s=>JSON.stringify(s)===JSON.stringify(general))
            if (index===-1){
                return general;
            }
            all.splice(index,1)
            return all;
        }


        return {
           ...fileUploading,
           ...metadata,
            ...initialData,
            ...priceAdder,
            addProduct,
            setColors:colorAndPrice.setColors,
            setSize:colorAndPrice.setSize,
            setTags:colorAndPrice.setTags,
            reload,
            loaded,
            handleEmptyInputs,
            individualColors,
            individualSizes
        }
    }

}
</script>

<style scoped>
.product_image{
    max-width: 150px;
    margin-left: 5px;
    margin-bottom: 3px;
}
.btn-close{
    position: absolute;
    top: 0;
    right: 0;
    background-color: #e90606;
    opacity: 1 !important;
    z-index: 250;
    cursor: pointer !important;
}
.general_image{
    width: 80%;
}
.files_wrapper{
    overflow: hidden;
    overflow-x: scroll;
    display: flex;
    flex-direction: row;
}
.file_input{
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    opacity: 0;
}
.checkmark{
    position: absolute;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    top: 5px;
    right: 5px;
    cursor: pointer;
}

.checkmark svg{
    width: 35px;
    height: 30px;
}

/* Tooltip text */
.tooltipp .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;

    /* Position the tooltip text - see examples below! */
    position: absolute;
    z-index: 1;
    top: -35px;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltipp:hover .tooltiptext {
    visibility: visible;
}
.remove-metadat-btn{
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    align-self: center;
}
.remove-metadat-btn .btn-close {
    position: relative;

}
</style>
