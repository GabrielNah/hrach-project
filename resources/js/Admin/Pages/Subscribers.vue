<template>
    <div class="w-100 container d-flex flex-column">
        <h4 class="w-100 text-center text-white">Subscribers</h4>
        <table class="table">
            <thead>
            <tr>
                <th scope="col " class="text-white">#</th>
                <th scope="col " class="text-white">Email</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(subsriber,index) in subscribers" :key="subsriber.id">
                <th scope="row " class="text-white">{{ index+1 }}</th>
                <td class="text-white">{{ subsriber.subscriber }}</td>
            </tr>
            <div class="text-center fw-bold text-white" v-if="!subscribers.length">
                You have no subscriber yet
            </div>
            </tbody>
        </table>
    </div>
</template>
<script setup>
import {ref} from "vue";
import HTTP from "../Axios/axiosCongif";

const subscribers=ref([])
const getSubscribers=()=>{
    HTTP.get('/subscribers')
    .then(({data})=>{
        subscribers.value=data.subscribers
    })
}
getSubscribers()
</script>
<script>
export default {
    name: "Subscribers"
}
</script>

<style scoped>

</style>
