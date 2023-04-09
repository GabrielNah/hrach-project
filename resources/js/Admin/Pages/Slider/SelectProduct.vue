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
                <template v-if="paginator.products.length">
                    <div class="w-100 "  style="height: 95%">
                        <div class="form-check w-100 justify-content-center gap-2 d-flex">
                            <input class="form-check-input"
                                   type="checkbox" value="" id="flexCheckChecked"
                                   v-bind="{'checked':selectedProductsHandler.allProductAreSelected()}"
                                   @change="selectedProductsHandler.toggleAllPresentProducts($event)"
                            >
                            <label class="form-check-label text-white fonted" for="flexCheckChecked">
                                {{ selectedProductsHandler.allProductAreSelected()
                                ? "Unselect" : "Select" }} all present products
                            </label>
                        </div>
                        <div class="w-100  d-flex flex-wrap gap-2 wrapped_search_results">
                            <div v-for="product in paginator.products" style="height: fit-content"
                                 :key="product.id">
                                <div style="width: 180px;">
                                    <div class="w-100 d-flex justify-content-center gap-1">
                                        <label class="form-check-label text-white fonted" >
                                            <input class="form-check-input" type="checkbox"
                                                   v-bind="{
                                                   'value':product.id,
                                                   'checked': selectedProductsHandler.productIsSelected(product)
                                               }"
                                                   @change="selectedProductsHandler.selectProduct(product)"
                                            >
                                            {{ selectedProductsHandler.productIsSelected(product) ? "Unselect" : "Select" }}
                                        </label>
                                    </div>
                                    <div class="w-100" style="height: 285px">
                                        <product-cart :product="product"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 justify-content-center">
                        <div class="d-flex gap-1 pages justify-content-center">
                            <span class="single_page"
                                  v-for="page in paginator.last_page"
                                  :class="{
                                      'active':page === paginator.current_page,
                                      }"
                                  @click="wrapWithinProcess(()=>paginatorActions.getPagesResults(page))"
                            >
                                {{ page }}
                            </span>
                        </div>
                    </div>
                </template>

                <div class=" w-100 h-100 d-flex justify-content-center align-items-center" v-else>
                    <span class="text-center fonted text-white fw-bold">
                        No search result
                    </span>
                </div>
            </div>
        </div>

        <div class="w-25 d-flex flex-column h-100">
            <h6 class="w-100 text-center fw-bold fonted">
                Selected products
            </h6>
            <div class="prods">
                <template v-if="selectedProducts.length">
                    <div v-for="product in selectedProducts" class="single_prod"
                        :key="product.id"
                    >
                        <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                            <button class="btn btn-close" @click="selectedProductsHandler.selectProduct(product)">

                            </button>
                        </div>
                        <template v-if="product.general_file.type === 'image'">
                            <img alt="" :src="'/'+product.general_file.path">
                        </template>
                        <template v-if="product.general_file.type === 'video'">
                            <video :src="'/'+product.general_file.path" autoplay controls></video>
                        </template>
                        <div class="d-flex flex-column justify-content-evenly">
                            <span class="single_prod_text">{{  product.name }}</span>
                            <span class="single_prod_price">${{ product.price_for_one.price }}</span>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <span class="w-100 text-center fonted fw-bold">
                        No product selected
                    </span>
                </template>
            </div>
            <div class="d-flex justify-content-center align-items-center"
                v-if="selectedProducts.length"
            >
                <button class="button-18" role="button" @click="selectedProductsHandler.dispatchSavedProds">
                    Save
                </button>
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
const emit=defineEmits(['SELECT_DONE'])
const props=defineProps({
    initialSelected:{
        type:Array,
        required:false
    }
})
const selectedProducts=ref([])
const selectedProductsHandler = {
    selectProduct:(product,splice=true)=>{
        let productIndex = selectedProducts.value.findIndex((pr)=>pr.id === product.id)
        if (productIndex !== -1){
            if (!splice){
                return;
            }
            selectedProducts.value.splice(productIndex,1)
            return;
        }
        selectedProducts.value.push(product)
    },
    productIsSelected:(product)=>selectedProducts.value.some((pr)=>pr.id === product.id),
    toggleAllPresentProducts(e){
        if (e.target.checked){
            paginator.products.forEach((product)=>{
                this.selectProduct(product,false)
            })
            return;
        }
        paginator.products.forEach((product)=>{
            this.selectProduct(product)
        })

    },
    allProductAreSelected:()=>{
        return  (!paginator.products.length) ? false :
            (paginator.products.every((product)=>{
              return selectedProducts.value.some((pr)=>pr.id === product.id)
             }));
    },
    dispatchSavedProds(){
        emit('SELECT_DONE',selectedProducts.value.map(pr=>pr.id))
    }

}

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
    fulfillSearch(url='/product/search'){
        HTTP.post(url,{
            type:searchValue.searchBy,
            value:searchValue.input,
        }).then(({data:{products}})=>{
           paginator.products=products.data
           paginator.next_page_url=products.next_page_url
           paginator.prev_page_url=products.prev_page_url
           paginator.current_page=products.current_page
           paginator.last_page=products.last_page
        }).catch(e=>errorNotification(extractValidationErrors(e)))
    },
    getPagesResults(page){
      if (paginator.current_page===page)return;
      this.fulfillSearch(this.getPageUrl(page))
    },
    getPageUrl(page){
        return `/product/search?page=${page}`
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
    });
    if (props.initialSelected?.length){
        HTTP.post('/product/exact',{ids:props.initialSelected})
        .then(({data})=>{
            selectedProducts.value=data.products
        })
        .catch((e)=>errorNotification(extractValidationErrors(e)))
    }
})
</script>

<style  lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Anuphan:wght@200&display=swap');
/* CSS */
.button-18 {
    align-items: center;
    background-color: #0A66C2;
    border: 0;
    border-radius: 100px;
    box-sizing: border-box;
    color: #ffffff;
    cursor: pointer;
    display: inline-flex;
    font-family: -apple-system, system-ui, system-ui, "Segoe UI", Roboto, "Helvetica Neue", "Fira Sans", Ubuntu, Oxygen, "Oxygen Sans", Cantarell, "Droid Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Lucida Grande", Helvetica, Arial, sans-serif;
    font-size: 16px;
    font-weight: 600;
    justify-content: center;
    line-height: 20px;
    max-width: 480px;
    min-height: 40px;
    min-width: 0px;
    overflow: hidden;
    padding: 0px;
    padding-left: 20px;
    padding-right: 20px;
    text-align: center;
    touch-action: manipulation;
    transition: background-color 0.167s cubic-bezier(0.4, 0, 0.2, 1) 0s, box-shadow 0.167s cubic-bezier(0.4, 0, 0.2, 1) 0s, color 0.167s cubic-bezier(0.4, 0, 0.2, 1) 0s;
    user-select: none;
    -webkit-user-select: none;
    vertical-align: middle;
}

.button-18:hover,
.button-18:focus {
    background-color: #16437E;
    color: #ffffff;
}
.pages{
    .single_page{
        border-radius: 2px;
        background-color: #adb5bd;
        padding: 2px 10px;
    }
    .active{
        background-color: #00b517;
    }
}
.button-18:active {
    background: #09223b;
    color: rgb(255, 255, 255, .7);
}

.button-18:disabled {
    cursor: not-allowed;
    background: rgba(0, 0, 0, .08);
    color: rgba(0, 0, 0, .3);
}
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
    height: 600px;
    background-color: rgb(45, 55, 72);
    .wrapped_search_results{
        height: 500px;
        overflow-y: scroll;
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
        background-color: #6c757d;
    }
    .wrapped_search_results::-webkit-scrollbar{
        display: none;
    }
}
.prods {
    margin-top: 10px;
    max-height: 500px;
    box-sizing: border-box;
    overflow: auto;
    display: flex;
    flex-direction: column;
    justify-content: center;

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
