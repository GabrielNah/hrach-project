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
                                        <div class="form-group ">
                                            <label >Sizes</label>
                                            <multiselect :values="sizes" @selected="setSize" :unique-key="'id'" :showable-key="'size'"/>
                                        </div>
                                        <div class="form-group ">
                                            <label>Colors</label>
                                            <multiselect :values="colors" @selected="setColors" :unique-key="'id'" :showable-key="'name'"/>
                                        </div>
                                        <div class="form-group ">
                                            <label>Tags</label>
                                            <multiselect :values="existingTags" @selected="setTags" :unique-key="'id'" :showable-key="'name'"/>
                                        </div>
                                        <div class="form-group ">
                                            <label>Prices</label>
                                            <div class="d-flex flex-row justify-content-between border p-1" v-for="price in priceCount" :key="price.id">
                                                <div class="form-group ">
                                                    <label>Price</label>
                                                    <input class="form-control" :name="price.forMany ? 'prices[]' : 'price_for_one[]'" type="text">
                                                    <label >Currency</label>
                                                    <select class="form-select" :name="price.forMany ? 'currencies[]':'currencies_for_one[]'">
                                                        <option selected>Open this select menu</option>
                                                        <option v-for="(currency,index) in currencies" :key="index" :value="currency">
                                                            {{ currency }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check form-group form-switch d-flex justify-content-between gap-5">
                                                        <label class="form-check-label" >Price for many
                                                            <input v-model="price.forMany" class="form-check-input"  type="checkbox"  >
                                                        </label>
                                                        <div class="position-relative" @click="removePrice(price)">
                                                            <button type="button" class="btn-close"></button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group " v-if="price.forMany">
                                                        <label class="d-flex">
                                                              <span style="margin-right: 5px;">Min </span>
                                                              <input class="form-control" name="counts_min[]" type="text">
                                                        </label>
                                                        <label class="d-flex mt-3">
                                                                <span style="margin-right: 5px;">Max </span>
                                                                <input class="form-control" name="count_max[]" type="text">
                                                        </label>
                                                    </div>
                                                </div>


                                            </div>
                                            <button type="button" @click="addPrice" class="btn btn-primary mt-2">Add price</button>
                                        </div>
                                        <div class="form-check form-group form-switch">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Product is active</label>
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="is_active">
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
    useAddProductsInitialData,
    useMetaDataHandler, usePriceAdder, useProductSizeAndColorSetter
} from "../../Composables/useProductFileUploading";
import useLoader from "../../../GlobalComposables/useLoader";
import Loader from "../../../SharedComponents/Loader.vue";
import HTTP from "../../Axios/axiosCongif";
import {errorNotification, successNotification} from "../../../Services/NotificationService";
import {extractValidationErrors} from "../../../Services/GlobalHelpers";

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
                let {data}=await HTTP.post('/product/store',productInfo)
                // setLoaded(false)
                if (data.success){
                    successNotification('Auto opening product details','Product added successfully')
                }

            }catch (e) {
                console.log(e)
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
            loaded
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
