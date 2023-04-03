<template>
    <div class="d-flex flex-column  justify-content-center align-items-center gap-1">
        <div class="d-flex w-100">
            <h3 class="w-75 text-center text-white">
                Currency rates
            </h3>
            <div class="flex-grow-1 d-flex justify-content-center align-items-center gap-1">
                <button @click="saveChanges" class="btn btn-success d-flex justify-content-center align-items-center mr-1" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                    </svg>
                </button>
                <button @click="addCurrency" class="btn btn-success d-flex justify-content-center align-items-center ml-1" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="w-75">
            <form action="">
                <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="text-white">#</th>
                    <th scope="col" class="text-white">Currency</th>
                    <th scope="col" class="text-white">Rete (to 1 USD)</th>
                    <th scope="col" class="text-info">Remove</th>
                </tr>
                </thead>
                <tbody>
                    <template v-for="(currency,index) in currencies" :key="currency.id">
                        <tr>
                            <th scope="row">
                                {{ index + 1}}
                            </th>
                            <td>
                                <input type="text" v-model="currency.currency" name="currency[]">
                            </td>
                            <td>
                                <input type="text"  v-model="currency.rate" name="rate[]">
                            </td>
                            <td>

                                <button style="margin-left: 5px" class="btn btn-danger btn-sm rounded-0" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete"
                                        @click="removeCurrency(index)"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>

                </tbody>
            </table>
            </form>
        </div>

    </div>
</template>

<script>
export default {
    name: "CurrencyRates"
}
</script>

<script setup>
import {onMounted, ref} from "vue";
 import HTTP from "../../Axios/axiosCongif";
import {errorNotification, successNotification} from "../../../Services/NotificationService";
import {extractValidationErrors} from "../../../Services/GlobalHelpers";

 const currencies = ref([])
 const addCurrency = ()=>{
     currencies.value.push({
         id:Date.now()+Math.random(),
         currency:'',
         rate:''
     })
 }

 const saveChanges = ()=>{
     HTTP.post('/settings/currency_rates',{
         data:currencies.value
     }).then(({data})=>{
         if (data.success){
             successNotification('Currencies modified successfully')
         }
     }).catch((e)=>{
        errorNotification(extractValidationErrors(e))
     })
 }
 const getCurrencies = ()=>{
     HTTP.get('/settings/currency_rates')
     .then(({data})=>{
         currencies.value = data.currency_rates
     })
 }
 const removeCurrency=(index)=>{
     currencies.value.splice(index,1)
 }

 onMounted(getCurrencies)

</script>

<style scoped>
    td input{
        border: unset;
        outline: unset;
    }
</style>
