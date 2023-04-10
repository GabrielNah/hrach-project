<template>


    <!-- sidebar + content -->
    <section class="">
        <div class="container">
            <div class="row">
                <!-- sidebar -->
                <div class="col-lg-3">
                    <!-- Toggle button -->
                    <button
                        class="btn btn-outline-secondary mb-3 w-100 d-lg-none"
                        type="button"
                        data-mdb-toggle="collapse"
                        data-mdb-target="#navbarSupportedContent"
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
                                        data-mdb-toggle="collapse"
                                        data-mdb-target="#panelsStayOpen-collapseOne"
                                        aria-expanded="true"
                                        aria-controls="panelsStayOpen-collapseOne"
                                    >
                                        Related items
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled">
                                            <li><a href="#" class="text-dark">Electronics </a></li>
                                            <li><a href="#" class="text-dark">Home items </a></li>
                                            <li><a href="#" class="text-dark">Books, Magazines </a></li>
                                            <li><a href="#" class="text-dark">Men's clothing </a></li>
                                            <li><a href="#" class="text-dark">Interiors items </a></li>
                                            <li><a href="#" class="text-dark">Underwears </a></li>
                                            <li><a href="#" class="text-dark">Shoes for men </a></li>
                                            <li><a href="#" class="text-dark">Accessories </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button
                                        class="accordion-button text-dark bg-light"
                                        type="button"
                                        data-mdb-toggle="collapse"
                                        data-mdb-target="#panelsStayOpen-collapseTwo"
                                        aria-expanded="true"
                                        aria-controls="panelsStayOpen-collapseTwo"
                                    >
                                        Brands
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo">
                                    <div class="accordion-body">
                                        <div>
                                            <!-- Checked checkbox -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked1" checked />
                                                <label class="form-check-label" for="flexCheckChecked1">Mercedes</label>
                                                <span class="badge badge-secondary float-end">120</span>
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
                                        data-mdb-toggle="collapse"
                                        data-mdb-target="#panelsStayOpen-collapseThree"
                                        aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseThree"
                                    >
                                        Price
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree">
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
                                        <button type="button" class="btn btn-white w-100 border border-secondary">apply</button>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" >
                                    <button
                                        class="accordion-button text-dark bg-light"
                                        type="button"
                                        data-mdb-toggle="collapse"
                                        data-mdb-target="#panelsStayOpen-collapseFour"
                                        aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseFour"
                                    >
                                        Size
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingThree">
                                    <div class="accordion-body">
                                        <input type="checkbox" class="btn-check border justify-content-center" id="btn-check1" checked autocomplete="off" />
                                        <label class="btn btn-white mb-1 px-1" style="width: 60px;" for="btn-check1">XS</label>
                                        <input type="checkbox" class="btn-check border justify-content-center" id="btn-check2" checked autocomplete="off" />
                                        <label class="btn btn-white mb-1 px-1" style="width: 60px;" for="btn-check2">SM</label>
                                        <input type="checkbox" class="btn-check border justify-content-center" id="btn-check3" checked autocomplete="off" />
                                        <label class="btn btn-white mb-1 px-1" style="width: 60px;" for="btn-check3">LG</label>
                                        <input type="checkbox" class="btn-check border justify-content-center" id="btn-check4" checked autocomplete="off" />
                                        <label class="btn btn-white mb-1 px-1" style="width: 60px;" for="btn-check4">XXL</label>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button
                                        class="accordion-button text-dark bg-light"
                                        type="button"
                                        data-mdb-toggle="collapse"
                                        data-mdb-target="#panelsStayOpen-collapseFive"
                                        aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseFive"
                                    >
                                        Ratings
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingThree">
                                    <div class="accordion-body">
                                        <!-- Default checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   checked />
                                            <label class="form-check-label" >
                                                <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                            </label>
                                        </div>
                                        <!-- Default checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                  checked />
                                            <label class="form-check-label">
                                                <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-secondary"></i>
                                            </label>
                                        </div>
                                        <!-- Default checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                    checked />
                                            <label class="form-check-label" >
                                                <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-secondary"></i>
                                            </label>
                                        </div>
                                        <!-- Default checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-secondary"></i><i class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-secondary"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
import {all} from "axios";


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
</style>
