<template>
    <div class="d-flex flex-column w-100 p-2">
        <div class="currencies d-flex">
            <h5> Currencies </h5>
            <span class="button3"  v-for="(currency,index) in currencies"
                  :class="{'active':(selectedCurrency === currency)}"
                   :key="index"
                  @click="selectCurrency(currency)"
            >
                {{ currency }}
            </span>
        </div>
        <div class="prices" >
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Price</th>
                        <th scope="col">Min set</th>
                        <th scope="col">Max set</th>
                        <th scope="col">Negotiable</th>
                        <th scope="col">Discount (%)</th>
                        <th scope="col">Discounted price</th>
                        <template v-if="selectedCurrency === 'USD'">
                            <th scope="col">Remove</th>
                            <div class="d-flex gap-1" >
                                <button @click="addPrice" type="button" class="btn btn-success d-flex justify-content-center align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                    </svg>
                                </button>
                            </div>
                        </template>



                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(price,index) in pricesOfSelectedCurrency"
                        :key="price.id"
                    >
                        <th scope="row">{{ index + 1 }}</th>
                        <td >
                            <input name="price[]"  class="w-100"
                                   v-bind="{
                                        'disabled':price.currency !=='USD',
                                        'readonly':price.currency !=='USD',
                                   }"
                                   v-model="price.price ">
                        </td>
                        <td>
                            <input type="text"  class="w-100"
                                   v-bind="{
                                        'disabled':price.currency !=='USD',
                                        'readonly':price.currency !=='USD',
                                   }"
                                   name="min_count[]" v-model="price.min_count">
                        </td>
                        <td>
                            <input type="text"  class="w-100"
                                   v-bind="{
                                        'disabled':price.currency !=='USD',
                                        'readonly':price.currency !=='USD',
                                   }"
                                   name="max_count[]" v-model="price.max_count">
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <label class="form-check-label" >
                                    <input class="form-check-input" type="checkbox" v-model="price.negotiable"
                                           v-bind="{
                                                'disabled':price.currency !=='USD',
                                                'readonly':price.currency !=='USD',
                                            }"
                                           role="switch" >
                                </label>

                            </div>
                        </td>
                        <td>
                            <input type="text"  class="w-100"
                                   v-bind="{
                                        'disabled':price.currency !=='USD',
                                        'readonly':price.currency !=='USD',
                                   }"
                                   name="discount[]" v-model="price.discount">
                        </td>
                        <td>
                            <span>
                                {{ calcDiscountedPrice(price) }}
                            </span>
                        </td>
                        <td v-if="selectedCurrency === 'USD'">
                            <div class="d-flex gap-1">
                                <button class="btn btn-success btn-sm " @click="wrapWithinProcess(()=>saveChanges(price,index))"
                                        type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                    </svg>
                                </button>
                                <button
                                    @click="wrapWithinProcess(()=>removePrice(price))"
                                    style="margin-left: 5px" class="btn btn-danger btn-sm rounded-0" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </button>
                            </div>

                        </td>
                    </tr>
                    </tbody>
                </table>

        </div>
    </div>
</template>

<script>
export default {
    name: "EditPrices",
    data:()=>({
      ongoingProcess:false
    }),
    methods:{
        async wrapWithinProcess(callback){
            if (this.ongoingProcess){
                return;
            }
            this.ongoingProcess=true
            await callback()
            this.ongoingProcess = false
        }
    }
}
</script>
<script setup>
 import {useRoute} from "vue-router";
 import {computed, onMounted, ref, watch} from "vue";
 import HTTP from "../../../Axios/axiosCongif";
 import {errorNotification, infoNotification, successNotification} from "../../../../Services/NotificationService";
 import {extractValidationErrors} from "../../../../Services/GlobalHelpers";
 import calculateDiscountedPrice from "../../../../Services/DiscountCalulator";
 const route = useRoute()
 const productId= computed(()=>route.params.id)
 const prices= ref([])
 const selectedCurrency= ref(null)
 const currencies = ref([])
 const pricesOfSelectedCurrency =computed(() =>{
    return prices.value[selectedCurrency.value]
 })

 const selectCurrency = (currency) =>{
     selectedCurrency.value = currency
 }

 const discountsOfUsdPrices = computed(()=>{
     return prices.value['USD']?.map((price)=>[price.id,price.discount])??[]
 })

 const addPrice = ()=>{
     if (selectedCurrency.value !== 'USD'){
         infoNotification('Can`t add price while selected currency is not "USD"')
         return;
     }
     prices.value['USD'].push({
         id:Date.now(),
         min_count:'',
         max_count:'',
         price:'',
         discount:0,
         currency:'USD',
         negotiable:false,
         added:true
     })
 }
 const removePrice =(price)=>{
     if (selectedCurrency.value!=='USD'){
         infoNotification('Can`t remove price while selected currency is not "USD"');
         return;
     }
     if (price.min_count === 1 && price.max_count === 1 ){
            infoNotification('Can`t remove price for one');
            return;
     }
     let index = prices.value[selectedCurrency.value].findIndex((pr)=>pr.id === price.id)
     if (index === -1){
         return;
     }
     if (price.added){
         prices.value[selectedCurrency.value].splice(index,1)
         return;
     }
     HTTP.delete(`/product/prices/${productId.value}/${price.id}`)
         .then((response)=>{
             if (response.status === 204){
                 successNotification('Price removed successfully')
                 prices.value[selectedCurrency.value].splice(index,1)
             }
         }).catch(e=>errorNotification(extractValidationErrors(e)))

 }
 const calcDiscountedPrice = (price)=>{
     if (!price.price){
         return ''
     }
     return  calculateDiscountedPrice(price.price,price.discount)
 }
 const saveChanges =async (price,index)=>{
     if (selectedCurrency.value !== 'USD'){
         infoNotification('Can`t save changes while selected currency is not "USD"');
         return;
     }
     let method='post';
     let url=`/product/prices/store/${productId.value}`
     let notification='Price added successfully'
     if (!price.added){
        method='put'
        url=`/product/prices/${productId.value}/edit/${price.id}`
        notification='Price modified successfully'
     }
     await HTTP[method](url, {price})
         .then(({data})=>{
             if (data.success){
                 currencies.value.forEach(currnecy=>{
                     if (data.price[currnecy]){
                         prices.value[currnecy][index]=data.price[currnecy][0]
                     }
                 })
                 successNotification(notification);
             }
         }).catch((e)=>errorNotification(extractValidationErrors(e)))

 }
 watch(()=>discountsOfUsdPrices.value,(val)=>{
     if (Array.isArray(val) && val.length){
         val.forEach(([id,discount],index)=>{
             for (const currency in prices.value) {
                 if (currency === "USD"){
                     continue;
                 }
                 const index = prices.value[currency].findIndex(pr=>pr.id === id)
                 if (index === -1){
                     continue;
                 }
                 prices.value[currency][index].discount = discount;
             }
         })

     }
 })
 onMounted(()=>{
     HTTP.get('/product/prices/'+productId.value)
     .then(({data})=>{
         prices.value = data.prices
         currencies.value = Object.keys(data.prices)
         selectedCurrency.value = currencies.value[0]
     })
 })


</script>

<style scoped>
.currencies{
    gap: 10px;
}
span.button3{
    display:inline-block;
    padding:0.3em 1.2em;
    margin:0 0.3em 0.3em 0;
    border-radius:2em;
    box-sizing: border-box;
    text-decoration:none;
    font-family:'Roboto',sans-serif;
    font-weight:300;
    color:#FFFFFF;
    background-color:#4eb5f1;
    text-align:center;
    transition: all 0.2s;
}
span.active {
    background-color: #00b517;
}
span.button3:hover{
    background-color:#4095c6;
}
td input {
    border: none;
    outline: none;
}
@media all and (max-width:30em){
    span.button3{
        display:block;
        margin:0.2em auto;
    }
}
</style>
