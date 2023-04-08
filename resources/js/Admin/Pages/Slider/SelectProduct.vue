<template>
    <div class="w-100 p-1 d-flex justify-content-between" >
        <div class="d-flex w-75 flex-column">
            <form  class="d-flex w-100 position-relative"
                   @submit.prevent="wrapWithinProcess(paginatorActions.fulfillSearch)"
            >
                <select class="form-select w-25" aria-label="Default select example"
                        style="border-top-right-radius: 0;border-bottom-right-radius: 0"
                        v-model="searchValue.searchBy"
                >
                    <option selected :value="searchBy" v-for="searchBy in SELECT_TYPES">
                        {{ searchBy === DEFAULT_SEARCH ? "Search by" : searchBy }}
                    </option>
                </select>
                <input type="search" v-model="searchValue.input"  class="form-control flex-grow-1 rounded-0" />
                <button type="submit" class="btn btn-primary "
                        style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
                <div class="d-flex position-absolute operators rounded-1 gap-1 p-1 align-items-center"
                     v-if="searchHelperOpened && searchValue.searchBy!==DEFAULT_SEARCH">
                <span class="btn btn-sm " style="white-space: nowrap">
                  Hot keys
                </span>
                    <div class="d-flex flex-grow-1 pr-1 pl-1 gap-2">
                    <span class="search_helper_text"
                          v-for="searchHelper in searchHelperTexts"
                          @click="addToSearchInput(searchHelper)"
                    >
                        {{ correctTextForSearchHelpers(searchHelper) }}
                    </span>
                    </div>
                </div>
            </form>
            <div class="flex-column w-100 d-flex  search_results">
                <div class="w-100 " v-if="paginator.products.length" style="height: 85%">
                    <div class="form-check w-100 justify-content-center gap-2 d-flex">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label text-white fonted" for="flexCheckChecked">
                            Mark all as checked
                        </label>
                    </div>
                    <div class="w-100 h-100 d-flex flex-wrap gap-2">
                        <div v-for="product in paginator.products"
                             :key="product.id">
                            <div style="width: 180px;">
                                <div class="w-100 d-flex justify-content-center gap-1">
                                    <label class="form-check-label text-white fonted" >
                                        <input class="form-check-input" type="checkbox" value="" >
                                        Select
                                    </label>
                                </div>
                                <div class="w-100" style="height: 285px">
                                    <product-cart :product="product"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" w-100 h-100 d-flex justify-content-center align-items-center" v-else>
                    <span class="text-center fonted text-white fw-bold">
                        No search result
                    </span>
                </div>
            </div>
        </div>

        <div class="w-25 d-flex flex-column overflow-auto">
            <h6 class="w-100 text-center fw-bold fonted">
                Selected products
            </h6>
            <div class="prods">
                <div v-for="i in 15" class="single_prod">
                    <img alt="" src="/images/posts/2.webp">
                    <div class="d-flex flex-column justify-content-evenly">
                        <span class="single_prod_text">Name</span>
                        <span class="single_prod_price">$145.05</span>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
import processWrappes from "../../../Mixins/processWrappes";
import ProductCart from "../../../Customer/Pages/Components/Product-cart.vue";
export default {
    name: "SelectProduct",
    mixins:[processWrappes],
    components:{ProductCart}
}
</script>
<script setup>
import {computed, onMounted, reactive, ref,watch} from "vue";
import HTTP from "../../Axios/axiosCongif";
import {errorNotification} from "../../../Services/NotificationService";
import {extractValidationErrors} from "../../../Services/GlobalHelpers";

const DISCOUNT='discounts';
const DEFAULT_SEARCH='default'
const SELECT_TYPES=[DEFAULT_SEARCH,'tags','categories','sizes','colors',DISCOUNT];
const searchHelperOpened=ref(false)

const toggleSearchHelper=(state)=>searchHelperOpened.value=state

const searchValue=reactive({
    input:'',
    searchBy:DEFAULT_SEARCH
})

const correctTextForSearchHelpers=(text)=>{
    if (searchValue.searchBy === DISCOUNT){
        return text
    }
    if (searchValue.searchBy === 'sizes'){
        return text.size
    }
    return text.name
}
const searchHelpers=reactive({
    tags:[],
    categories:[],
    sizes:[],
    colors:[],
    discounts:['>','<','<=','>=','=','!=']
})

const searchHelperTexts = computed(()=>searchHelpers[searchValue.searchBy]??[])
const addToSearchInput=(text)=>{
    toggleSearchHelper(false)
    if (searchValue.searchBy === DISCOUNT){
        searchValue.input+=text;
        return;
    }
    if (searchValue.searchBy === 'sizes'){
        searchValue.input+=text.size;
        return text.size
    }
    searchValue.input+=text.name;
}

const paginatorActions={
    fulfillSearch:(url='/product/search')=>{
        HTTP.post(url,{
            type:searchValue.searchBy,
            value:searchValue.input,
        }).then(({data:{products}})=>{
           paginator.products=products.data
           paginator.next_page_url=products.next_page_url
           paginator.prev_page_url=products.prev_page_url
           paginator.current_page=products.current
           paginator.last_page=products.last_page
        }).catch(e=>errorNotification(extractValidationErrors(e)))
    }
}


const paginator = reactive({
    products:[],
    last_page:0,
    current_page:0,
    next_page_url:'',
    prev_page_url:'',
})
watch(()=>searchValue.searchBy,(val)=>{
    if (val!==DEFAULT_SEARCH){
        toggleSearchHelper(true)
    }
})
onMounted(()=>{
    HTTP.get('/slider/initial')
    .then(({data})=>{
        searchHelpers.tags=data.tags
        searchHelpers.categories=data.categories
        searchHelpers.sizes=data.sizes
        searchHelpers.colors=data.colors
    })
})
</script>

<style  lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Anuphan:wght@200&display=swap');
.fonted{
    font-family: "Anuphan";
}
.operators{
    left: 0;
    right: 0;
    height: 30px;
    top: 100%;
    z-index: 150;
    background: #bbc0c8;
    overflow: auto;
}
.operators::-webkit-scrollbar {
   display: none;
}


.search_helper_text{
    font-family: "Anuphan";
    padding:2px 10px;
    border-radius: 2px;
    text-align: center;
    outline: none;
    color: #adb5bd;
    background-color: #2d3748;
    border: #0c163b;
    white-space: nowrap;
}
.search_helper_text:hover{
    color: #b34a00;
    cursor: pointer;
}
.search_results{
    padding: 5px;
    height: 500px;
    background-color: rgb(45, 55, 72);;
}
.prods {
    margin-top: 10px;
    max-height: 450px;
    overflow: auto;

    .single_prod {
        display: flex;
        flex-direction: row;
        margin-bottom: 10px;
        padding-left: 5px;

        img {
            width: 70px;
            height: 70px;
            border: 1px solid #E0E0E0;
            border-radius: 6px;
            margin-right: 10px;
        }
        video{
            width: 70px;
            height: 70px;
            border: 1px solid #E0E0E0;
            border-radius: 6px;
            margin-right: 10px;
        }

        .single_prod_text {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            /* or 150% */

            letter-spacing: -0.2px;

            /* dark */

            color: #1C1C1C;
        }

        .single_prod_price {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            /* identical to box height, or 150% */

            letter-spacing: -0.2px;

            /* gray-500 */

            color: #8B96A5;

        }
    }
}

.prods::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.prods {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}
</style>
