<template>


    <!-- sidebar + content -->
    <section class="pt-3">
        <div class="container">
            <div class="row">
                <!-- sidebar -->
                <div class="col-lg-3">
                    <!-- Toggle button -->
                    <form  @submit.prevent="applyFilter">
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
                                        <div class="accordion-body price-rang-acordeon">
                                            <div class="price-input">
                                                <div class="field">
                                                    <span>Min</span>
                                                    <input type="number" class="input-min" value="2500" name="price_min">
                                                </div>
                                                <div class="separator">-</div>
                                                <div class="field">
                                                    <span>Max</span>
                                                    <input type="number" class="input-max" value="7500" name="price_max">
                                                </div>
                                            </div>
                                            <div class="slider">
                                                <div class="progress"></div>
                                            </div>
                                            <div class="range-input">
                                                <input type="range" class="range-min" min="0" max="10000" value="2500" step="100">
                                                <input type="range" class="range-max" min="0" max="10000" value="7500" step="100">
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
                                    <div class="d-flex w-100 justify-content-center align-items-center p-2">
                                        <button class="btn btn-primary p-1 text-center w-50">
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
                                <a href="#" class="btn btn-light" :class="{'active':position===COLUMN}"
                                   title="List view" @click="setPosition(COLUMN)"
                                >
                                    <i class="fa fa-bars fa-lg"></i>
                                </a>
                                <a href="#" class="btn btn-light " :class="{'active':position===ROW}"
                                    @click="setPosition(ROW)"
                                   title="Grid view">
                                    <i class="fa fa-th fa-lg"></i>
                                </a>
                            </div>
                        </div>
                    </header>

                    <div class="row"  :class="{'flex-column':position===COLUMN}">
                        <div class="col-lg-4 col-md-6 col-sm-6 d-flex" v-for="product in paginator.products"
                            :key="product.id"
                             :class="{'w-100':position===COLUMN}"
                        >
                            <div class=" w-100 my-2 ">
                                <product-cart
                                    :product="product"
                                    :horizontal="position===COLUMN"
                                />
                            </div>
                        </div>
                    </div>

                    <hr />

                    <!-- Pagination -->
                    <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-3"
                        v-if="paginator.last_page > 1"
                    >
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
                                    <template v-if="showablePages.includes(page)">
                                        <li class="page-item "
                                            :class="{'active':page===paginator.current_page}"
                                            @click="getPageData(page)"
                                        >
                                            <span class="page-link">{{ page }}</span>
                                        </li>
                                    </template>
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
    components:{ProductCart},
    mounted() {
        const rangeInput = document.querySelectorAll(".range-input input"),
            priceInput = document.querySelectorAll(".price-input input"),
            range = document.querySelector(".slider .progress");
        let priceGap = 500;
        priceInput.forEach(input =>{
            input.addEventListener("input", e =>{
                let minPrice = parseInt(priceInput[0].value),
                    maxPrice = parseInt(priceInput[1].value);

                if((maxPrice - minPrice >= priceGap) && maxPrice <= rangeInput[1].max){
                    if(e.target.className === "input-min"){
                        rangeInput[0].value = minPrice;
                        range.style.left = ((minPrice / rangeInput[0].max) * 100) + "%";
                    }else{
                        rangeInput[1].value = maxPrice;
                        range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                    }
                }
            });
        });
        rangeInput.forEach(input =>{
            input.addEventListener("input", e =>{
                let minVal = parseInt(rangeInput[0].value),
                    maxVal = parseInt(rangeInput[1].value);
                if((maxVal - minVal) < priceGap){
                    if(e.target.className === "range-min"){
                        rangeInput[0].value = maxVal - priceGap
                    }else{
                        rangeInput[1].value = minVal + priceGap;
                    }
                }else{
                    priceInput[0].value = minVal;
                    priceInput[1].value = maxVal;
                    range.style.left = ((minVal / rangeInput[0].max) * 100) + "%";
                    range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
                }
            });
        });
    }
}
</script>
<script setup>
import {computed, inject, onMounted, reactive, ref, watch, watchEffect} from "vue";
import {SEARCH_TYPE_FILTER} from "../Camposables/useProductSeachHelper";
import  {executeSearch} from "../Camposables/useSearchExacuter";
import {useRoute} from "vue-router";
import {errorNotification} from "../../Services/NotificationService";
import {extractValidationErrors} from "../../Services/GlobalHelpers";

const {search,searchByCategories} = inject('searchHelper')
const route = useRoute()
const ROW='row';
const COLUMN='column';
const position=ref(ROW)
const setPosition=(pos)=>{
    position.value=pos
}

const paginator=reactive({
    current_page:0,
    total:0,
    products:[],
    last_page:0,
    per_page:0,
    prev_page_url:'',
    next_page_url:'',
})

const showablePages=computed(()=>{
    let firstPage=1;
    const prevPage=paginator.current_page-1;
    const nextPage=paginator.current_page+1;
    const nextPage1=paginator.current_page+2;
    return [firstPage,prevPage,paginator.current_page,nextPage,nextPage1,paginator.last_page];
})

const applyFilter=(e)=>{

    const data=new FormData(e.target)
    const searchData={};
    const existingKeys=[];
    for (const [key, value] of data.entries()) {
        if (key.includes('[]')){
            if (existingKeys.includes(key)){
                searchData[key].push(value)
                continue;
            }
            existingKeys.push(key)
            searchData[key]=[value];
            continue;
        }

        searchData[key]=value
    }

    for (let key of Object.keys(searchData)) {
        let newKey;
        if (key.includes('[]')){
            newKey=key.slice(0,-2)
            searchData[newKey]=searchData[key]
            delete searchData[key]
        }

    }
    search.type=SEARCH_TYPE_FILTER
    search.value=searchData
}
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

    try {
        let result =await executeSearch(search,path)
        setPaginatorData(result.data)
    }catch (e) {
        errorNotification(extractValidationErrors(e))
    }

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

<style scoped lang="scss">
.icon-hover:hover {
    border-color: #3b71ca !important;
    background-color: white !important;
}

.icon-hover:hover i {
    color: #3b71ca !important;
}
.price-rang-acordeon{
    .price-input{
        width: 100%;
        display: flex;
        margin: 30px 0 35px;
    }
    .price-input .field{
        display: flex;
        width: 100%;
        height: 45px;
        align-items: center;
    }
    .field input{
        width: 55%;
        height: 85%;
        outline: none;
        font-size: 19px;
        margin-left: 12px;
        border-radius: 5px;
        text-align: center;
        border: 1px solid #999;
        -moz-appearance: textfield;
    }
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }
    .price-input .separator{
        width: 130px;
        display: flex;
        font-size: 19px;
        align-items: center;
        justify-content: center;
    }
    .slider{
        height: 5px;
        position: relative;
        background: #ddd;
        border-radius: 5px;
    }
    .slider .progress{
        height: 100%;
        left: 25%;
        right: 25%;
        position: absolute;
        border-radius: 5px;
        background: #17A2B8;
    }
    .range-input{
        position: relative;
    }
    .range-input input{
        position: absolute;
        width: 100%;
        height: 5px;
        top: -5px;
        background: none;
        pointer-events: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }
    input[type="range"]::-webkit-slider-thumb{
        height: 17px;
        width: 17px;
        border-radius: 50%;
        background: #17A2B8;
        pointer-events: auto;
        -webkit-appearance: none;
        box-shadow: 0 0 6px rgba(0,0,0,0.05);
    }
    input[type="range"]::-moz-range-thumb{
        height: 17px;
        width: 17px;
        border: none;
        border-radius: 50%;
        background: #17A2B8;
        pointer-events: auto;
        -moz-appearance: none;
        box-shadow: 0 0 6px rgba(0,0,0,0.05);
    }
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
