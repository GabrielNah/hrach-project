<template>
    <h1>edit</h1>
</template>

<script>
import {useRoute} from "vue-router";
import {onMounted, watchEffect} from "vue";
import HTTP from "../../Axios/axiosCongif";

export default {
    name: "EditProduct",
    setup(){
        let route = useRoute();
        const getProduct = async (product_id)=>{
            try {
                let {data:{product}}=await HTTP.get(`product/edit/${product_id}`)
                console.log(product)
            }catch (e) {
                console.warn(e)
            }
        }
        watchEffect(()=>{
            if (route.params.id){
                getProduct(route.params.id).then()
            }
        })
    }
}
</script>

<style scoped>

</style>
