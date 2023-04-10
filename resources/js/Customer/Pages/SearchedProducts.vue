<template>


    <!-- sidebar + content -->
    <section class="">
        <div class="container">
            <div class="row">
                <!-- sidebar -->
                <div class="col-lg-3">
                    <!-- Toggle button -->
                    <form >
                        <button
                            class="btn btn-outline-secondary mb-3 w-100 d-lg-none"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent"
                            aria-expanded="false"
                            aria-label="Toggle navigation"
                        >
                            <span>Show filter</span>
                        </button>
                        <!-- Collapsible wrapper -->
                        <div class="collapse card d-lg-block mb-5" id="navbarSupportedContent">
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button
                                            class="accordion-button text-dark bg-light"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseOne"
                                            aria-controls="panelsStayOpen-collapseOne"
                                        >
                                            Categories
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne">
                                        <div class="accordion-body">
                                            <ul class="list-unstyled">
                                                <li v-for="category in searchHelpers.categories"
                                                    :key="category.id"
                                                >
                                                    <div class="form-check">
                                                        <label class="form-check-label" >{{  category.name }}
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="categories[]"
                                                                   :value="category.id"  />
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button
                                            class="accordion-button text-dark bg-light"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseTwo"
                                            aria-controls="panelsStayOpen-collapseTwo"
                                        >
                                            Tags
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse " aria-labelledby="headingTwo">
                                        <div class="accordion-body">
                                            <ul class="list-unstyled">

                                                <li v-for="tag in searchHelpers.tags"
                                                    :key="tag.id">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            {{ tag.name }}
                                                            <input class="form-check-input" type="checkbox" :value="tag.id" name="tags[]" />
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" >
                                        <button
                                            class="accordion-button text-dark bg-light"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseThree"
                                            aria-expanded="false"
                                            aria-controls="panelsStayOpen-collapseThree"
                                        >
                                            Price
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse " aria-labelledby="headingThree">
                                        <div class="accordion-body">
                                            <div class="range">
                                                <input type="range" class="form-range" id="customRange1" />
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <p class="mb-0">
                                                        Min
                                                    </p>
                                                    <div class="form-outline">
                                                        <input type="number"  class="form-control" />
                                                        <label class="form-label" >$0</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-0">
                                                        Max
                                                    </p>
                                                    <div class="form-outline">
                                                        <input type="number"  class="form-control" />
                                                        <label class="form-label" >$1,0000</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" >
                                        <button
                                            class="accordion-button text-dark bg-light"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseFour"
                                            aria-expanded="false"
                                            aria-controls="panelsStayOpen-collapseFour"
                                        >
                                            Colors
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse " aria-labelledby="headingThree">
                                        <div class="accordion-body">
                                            <div class="w-100 p-2 d-flex gap-2 flex-wrap">
                                                <div class="checkbox-container" v-for="color in searchHelpers.colors" :key="color.id">
                                                    <label :style="{backgroundColor:color.value}">
                                                        <input type="checkbox" @change="changeStyles"
                                                               name="colors[]"
                                                               :value="color.id"
                                                        />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" >
                                        <button
                                            class="accordion-button text-dark bg-light"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseSize"
                                            aria-expanded="false"
                                            aria-controls="panelsStayOpen-collapseSize"
                                        >
                                            Sizes
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseSize" class="accordion-collapse collapse " aria-labelledby="headingThree">
                                        <div class="accordion-body">
                                            <div class="w-100 p-2 d-flex gap-2 flex-wrap">

                                                    <label class="custom-checkbox" v-for="size in searchHelpers.sizes" :key="size.id">
                                                    <input type="checkbox"  @change="changeStyles"
                                                           name="sizes[]"
                                                           :value="size.id"
                                                    />

                                                        {{ size.size }}
                                                    </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button
                                            class="accordion-button text-dark bg-light"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseFive"
                                            aria-expanded="false"
                                            aria-controls="panelsStayOpen-collapseFive"
                                        >
                                            Ratings
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse " aria-labelledby="headingThree">
                                        <div class="accordion-body">
                                            <!-- Default checkbox -->
                                            <div class="form-check" v-for="star in 5">
                                                <label class="form-check-label" >
                                                <input class="form-check-input" type="checkbox" :value="star" name="rating[]"/>
                                                    <svg v-for="i in 5" fill="none" height="15" viewBox="0 0 16 15" width="16"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path :fill="i <= star ?'#FF9017':'#D5CDC5'" clip-rule="evenodd" d="M8 12.0553L12.944 15L11.632 9.45L16 5.71579L10.248 5.23421L8 0L5.752 5.23421L0 5.71579L4.368 9.45L3.056 15L8 12.0553Z"
                                                              fill-rule="evenodd"/>
                                                    </svg>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div class="d-flex w-100 justify-content-center align-items-center">
                                        <button class="btn btn-primary">
                                            Apply
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                <!-- sidebar -->
                <!-- content -->
                <div class="col-lg-9">
                    <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
                        <strong class="d-block py-2">{{ paginator.total }} Items found </strong>
                        <div class="ms-auto">
                            <div class="btn-group shadow-0 border">
                                <a href="#" class="btn btn-light" title="List view">
                                    <i class="fa fa-bars fa-lg"></i>
                                </a>
                                <a href="#" class="btn btn-light active" title="Grid view">
                                    <i class="fa fa-th fa-lg"></i>
                                </a>
                            </div>
                        </div>
                    </header>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 d-flex" v-for="product in paginator.products"
                            :key="product.id"
                        >
                            <div class=" w-100 my-2 ">
                                <product-cart :product="product"/>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <!-- Pagination -->
                    <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-3">
                        <ul class="pagination">
                            <li class="page-item "
                                :class="{'disabled':!paginator.prev_page_url}"
                            >
                                <span class="page-link"  aria-label="Previous"
                                      :class="{'disabled':!paginator.prev_page_url}"
                                      :aria-disabled="!paginator.prev_page_url"
                                      @click="getPageData(paginator.prev_page_url)"
                                >
                                    <span aria-hidden="true">&laquo;</span>
                                </span>
                            </li>
                            <template v-for="page in paginator.last_page">
                                <li class="page-item "
                                    :class="{'active':page===paginator.current_page}"
                                    @click="getPageData(page)"
                                >
                                    <span class="page-link">{{ page }}</span>
                                </li>
                            </template>

                            <li class="page-item"
                                :class="{'disabled':!paginator.next_page_url}"
                            >
                                <span class="page-link"  aria-label="Next"
                                      :class="{'disabled':!paginator.next_page_url}"
                                      :aria-disabled="!paginator.next_page_url"
                                      @click="getPageData(paginator.next_page_url)"
                                >
                                    <span aria-hidden="true">&raquo;</span>
                                </span>
                            </li>
                        </ul>
                    </nav>
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </section>
    <!-- sidebar + content -->
</template>

<script>
import ProductCart from "./Components/Product-cart.vue";
export default {
    name: "SearchedProducts",
    components:{ProductCart}
}
</script>
<script setup>
import {computed, inject, onMounted, reactive, watch, watchEffect} from "vue";
import  {executeSearch} from "../Camposables/useSearchExacuter";
import {useRoute} from "vue-router";

const {search,searchByCategories} = inject('searchHelper')
const route = useRoute()
const paginator=reactive({
    current_page:0,
    total:0,
    products:[],
    last_page:0,
    per_page:0,
    prev_page_url:'',
    next_page_url:'',
})
const changeStyles=(e)=>{
    const checkbox=e.target;

    if (checkbox.checked){
        checkbox.parentNode.classList.add('checked_color_size')
        return;
    }
    checkbox.parentNode.classList.remove('checked_color_size')
}
const searchHelpers=reactive({
    tags:[],
    colors:[],
    categories:[],
    sizes:[],
})

const getSearchHelpers=()=>{
    axios.get('/api/product/searchHelpers')
    .then(({data})=>{
       searchHelpers.categories=data.categories
       searchHelpers.tags=data.tags
       searchHelpers.colors=data.colors
       searchHelpers.sizes=data.sizes
    })
}
const category=computed(()=>route.params.category)
const setPaginatorData=({products})=>{
    const keys=Object.keys(paginator)
    keys.forEach((key)=>{
        paginator[key]=products[key === 'products' ?'data':key] ?? null
    })
}

const fulfillSearch=async (path='/api/product/search')=>{

    let result =await executeSearch(search,path)
    setPaginatorData(result.data)
}
const correctPathForSearch=(page)=>{
    if (typeof page === "string"){
        return page
    }
    return `/api/product/search?page=${page}`
}

const getPageData=(page)=>{
    if (page===paginator.current_page) return;
    fulfillSearch(correctPathForSearch(page))
}


watchEffect(async()=>{
       if (search.value){
            await fulfillSearch()
       }
})
watch(()=>category.value,(val)=>{
     searchByCategories(val)
})

onMounted(()=>{
    if (!search.value){
        searchByCategories(category.value || 'all')
    }
    getSearchHelpers()
})

</script>

<style scoped>
.icon-hover:hover {
    border-color: #3b71ca !important;
    background-color: white !important;
}

.icon-hover:hover i {
    color: #3b71ca !important;
}

.checked_color_size{
    box-shadow: 1px 5px 15px -2px rgba(20,17,17,0.75);
    -webkit-box-shadow: 1px 5px 15px -2px rgba(20,17,17,0.75);
    -moz-box-shadow: 1px 5px 15px -2px rgba(20,17,17,0.75);
    border: 3px solid rgb(23,190,136);
}
.checkbox-container {
    position: relative;
    width: 30px;
    height: 30px;
}

.checkbox-container input[type="checkbox"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    z-index: 2;
}
.checkbox-container label {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    box-sizing: border-box;
    z-index:3;
    cursor: pointer;
}

.custom-checkbox input[type="checkbox"] {
    position: absolute;
    opacity: 0;
}

.custom-checkbox{
    position: relative;
    display: block;
    min-width: 50px;
    box-sizing: border-box;
    white-space: nowrap;
    padding: 8px;
    text-align: center;
    line-height: 1;
    font-size: 14px;
    cursor: pointer;
    z-index: 3;
}




</style>
