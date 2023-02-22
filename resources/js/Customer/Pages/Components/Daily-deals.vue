<template>

    <div class="row row-sm">
        <div class="col-xl-2 col-lg-3 col-md-4 col-6" v-for="i in 6">
            <product-cart/>
        </div>
    </div>
</template>

<script>
import ProductCart from "./Product-cart.vue";
export default {
    name: "Daily-deals",
    components: {ProductCart}
}
</script>

<style scoped>

</style>
