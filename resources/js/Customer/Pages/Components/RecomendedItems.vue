<template>
    <div class="row">
        <template v-for="i in 12">
            <div class="col-xl-3 col-lg-3 col-md-4 col-6 ">
               <product-cart/>
            </div>
        </template>


    </div>
</template>

<script>
import ProductCart from "./Product-cart.vue";
export default {
    name: "RecomendedItems",
    components: {ProductCart}
}
</script>

<style scoped>

</style>
