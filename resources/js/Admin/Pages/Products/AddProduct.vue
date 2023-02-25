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
                                <button type="submit" class="btn btn-success mr-1 waves-effect waves-light">Save Changes</button>
                                <button type="submit" class="btn btn-secondary waves-effect">Cancel</button>
                            </form>
                            <main class="w-50 d-flex flex-column">
                                <h3 class="card-title text-center">Product files</h3>
                                <section>
                                    <h3 class="card-title text-center">Product images</h3>
                                    <div class="d-flex flex-wrap">
                                        <div class="position-relative"  v-for="i in 10">
                                            <img src="/images/posts/1.webp" class="product_image" alt="">
                                            <button type="button" class="btn-close" disabled aria-label="Close"></button>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <h3 class="card-title text-center">Product videos</h3>
                                    <div class="d-flex flex-wrap">
                                        <div class="position-relative" v-for="i in 10">
                                             <img src="/images/posts/1.webp" class="product_image" alt="" >
                                            <button type="button" class="btn-close" disabled aria-label="Close"></button>
                                        </div>
                                    </div>
                                </section>
                            </main>
                        </div>


                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Meta Data</h4>
                        <p class="card-title-desc">Fill all information below</p>

                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="metatitle">Meta title</label>
                                        <input id="metatitle" name="productname" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="metakeywords">Meta Keywords</label>
                                        <input id="metakeywords" name="manufacturername" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="metadescription">Meta Description</label>
                                        <textarea class="form-control" id="metadescription" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success mr-1 waves-effect waves-light">Save Changes</button>
                            <button type="submit" class="btn btn-secondary waves-effect">Cancel</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <teleport to="#app">
            <modal/>
        </teleport>




    </div>
</template>

<script>
import Multiselect from "../../../SharedComponents/ReusableComponents/Multiselect.vue";
import Modal from "../../../SharedComponents/ReusableComponents/Modal.vue";
export default {
    name: "AddProduct",
    components: {Modal, Multiselect}

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
</style>
