<template>
    <div class="container-fluid">


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Basic Information</h4>
                        <p class="card-title-desc">Fill all information below</p>

                        <div class="w-100 d-flex flex-row">
                            <form class="w-50">
                                <div class="row w-100">
                                    <div class="col-sm-6 w-100">
                                        <div class="form-group">
                                            <label >Category</label>
                                            <select class="form-select" aria-label="Default select example">
                                                <option selected>Open this select menu</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="productname">Product Name</label>
                                            <input id="productname" name="productname" type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="manufacturername">Product title</label>
                                            <input id="manufacturername" name="manufacturername" type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="productdesc">Product Description</label>
                                            <textarea class="form-control" id="productdesc" rows="5"></textarea>
                                        </div>
                                        <div class="form-group ">
                                            <label >Rating</label>
                                            <input class="form-control" min="0"  max="5" type="number"  >
                                        </div>
                                        <div class="form-group ">
                                            <label >Sizes</label>
                                            <multiselect/>
                                        </div>
                                        <div class="form-group ">
                                            <label>Colors</label>
                                            <multiselect/>
                                        </div>
                                        <div class="form-group ">
                                            <label>Prices</label>
                                            <div class="d-flex flex-row justify-content-between">
                                                <div class="form-group ">
                                                    <label>Price</label>
                                                    <input class="form-control" type="text">
                                                </div>
                                                <div class="form-group">
                                                    <label >Currency</label>
                                                    <select class="form-select" >
                                                        <option selected>Open this select menu</option>
                                                        <option>RU</option>
                                                        <option>USD</option>
                                                        <option>EUR</option>
                                                    </select>
                                                </div>
                                                <div class="form-check form-group form-switch">
                                                    <label class="form-check-label" >Price for many
                                                        <input class="form-check-input"  type="checkbox"  >
                                                    </label>
                                                </div>
                                                <div class="form-group ">
                                                    <label>Min count</label>
                                                    <input class="form-control" type="text">
                                                </div>
                                                <div class="form-group ">
                                                    <label>Max count</label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <button class="btn btn-primary mt-2">Add price</button>
                                        </div>
                                        <div class="form-check form-group form-switch">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Product is active</label>
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" >
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <main class="w-50 d-flex flex-column">
                                <h3 class="card-title text-center">Product files</h3>
                                <section v-if="files.length">
                                    <figure class="general_image card position-relative">
                                        <figcaption class="fw-bold card-title mt-1">Products general file</figcaption>
                                        <div class="checkmark tooltipp" @click="setGeneralFile(selectedFile)">
                                            <svg v-if="selectedFile" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check " viewBox="0 0 16 16">
                                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                            </svg>
                                            <span class="tooltiptext">Mark as general</span>
                                        </div>
                                        <template v-if="selectedFile">
                                            <template v-if="getFilesType(selectedFile) === 'video'">
                                                <video :src="getFilesUrl(selectedFile)" class="w-100 card-img" muted autoplay></video>
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

                        <form>
                            <div class="col">
                                <div class="d-flex flex-row w-50 justify-content-between" v-for="i in 3">
                                    <div class="form-group">
                                        <label for="metatitle">Meta data name</label>
                                        <input id="metatitle" name="productname" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="metakeywords">Meta data value</label>
                                        <input id="metakeywords" name="manufacturername" type="text" class="form-control">
                                    </div>
                                </div>
                                <button class="btn btn-primary mt-2">Add meta data</button>
                            </div>
                            <div class="btn-group mt-2">
                                <button type="submit" class="btn btn-success mr-1 waves-effect waves-light">Save Changes</button>
                                <button type="submit" class="btn btn-secondary waves-effect" style="margin-left: 5px">Cancel</button>
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
import {ref, watch} from "vue";
import useProductFileUploading from "../../Composables/useProductFileUploading";

export default {
    name: "AddProduct",
    components: {Modal, Multiselect},
    setup(){

        const fileUploading=useProductFileUploading();

        return {
           ...fileUploading
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
</style>
