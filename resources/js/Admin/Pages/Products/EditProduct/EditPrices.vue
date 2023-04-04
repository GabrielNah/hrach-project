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
                    <th scope="col">Remove</th>
                    <div class="d-flex gap-1">
                        <button class="btn btn-success btn-sm " type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                        </button>
                        <button @click="addPrice" class="btn btn-success d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                        </button>
                    </div>

                </tr>
                </thead>
                <tbody>

                    <tr v-for="(price,index) in pricesOfSelectedCurrency"
                        :key="price.id"
                    >
                        <th scope="row">{{ index + 1 }}</th>
                        <td >
                            <input name="price" :id="'price'+price.id" class="w-100"
                                   v-bind="{
                                        'disabled':price.currency !=='USD',
                                        'readonly':price.currency !=='USD',
                                   }"
                                   :value=" price.price ">
                        </td>
                        <td>
                            <input type="text" :id="'min_count'+price.id" class="w-100"
                                   v-bind="{
                                        'disabled':price.currency !=='USD',
                                        'readonly':price.currency !=='USD',
                                   }"
                                   name="min_count" :value="price.min_count">
                        </td>
                        <td>
                            <input type="text" :id="'max_count'+price.id" class="w-100"
                                   v-bind="{
                                        'disabled':price.currency !=='USD',
                                        'readonly':price.currency !=='USD',
                                   }"
                                   name="max_count" :value="price.max_count">
                        </td>
                        <td>
                              <button
                                  @click="removePrice(price)"
                                  style="margin-left: 5px" class="btn btn-danger btn-sm rounded-0" type="button"
                                  data-toggle="tooltip" data-placement="top" title="Delete"
                              >
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                      <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                  </svg>
                              </button>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditPrices"
}
</script>
<script setup>
 import {useRoute} from "vue-router";
 import {computed, onMounted, ref} from "vue";
 import HTTP from "../../../Axios/axiosCongif";

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

 const addPrice = ()=>{
     if (selectedCurrency.value !== 'USD'){
         return;
     }
     prices.value['USD'].push({
         id:Date.now(),
         min_count:'',
         max_count:'',
         currency:'USD',
         added:true
     })
 }
 const removePrice =(price)=>{
     let index = prices.value[selectedCurrency.value].findIndex((pr)=>pr.id === price.id)
     if (index === -1){
         return;
     }
     if (price.added){
         prices.value[selectedCurrency.value].splice(index,1)
         return;
     }
 }

 const saveChanges = ({id,added=false})=>{
     // if (added)
     const price = document.getElementById('price'+id)?.value;
     const min_cont = document.getElementById('min_count'+id).value;
     const max_count = document.getElementById('max_count'+id).value;
     let index =  prices.value[selectedCurrency.value].findIndex(pr=>pr.id === id)
     if (index === -1){
         return;
     }

 }

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
