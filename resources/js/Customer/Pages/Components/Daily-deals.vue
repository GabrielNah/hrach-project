<template>
    <section class="padding-bottom">

        <header class="section-heading mb-4">
            <h3 class="title-section">{{  sectionName  }}</h3>
        </header>
        <div class="w-100 d-flex overflow-auto gap-3 hidden_scrollbar p-2">
            <div class="col-xl-2 col-lg-3 col-md-4 col-6 product-item" v-for="product in products"
                :key="product.id"
            >
                <product-cart :product="product"/>
            </div>
        </div>
    </section>

</template>

<script>
import ProductCart from "./Product-cart.vue";
export default {
    name: "Daily-deals",
    components: {ProductCart},
}
</script>
<script setup>
import {nextTick, onMounted, ref} from "vue";

    const sectionName=ref('')
    const products=ref([])
    const emit=defineEmits(['loaded'])
    const getItems=()=>{
        axios.get('/product/front_page?main=false')
        .then(({data})=>{
            sectionName.value=data.pageSettings.section_name
            products.value=data.pageSettings.products
        }).finally(()=>nextTick(()=>emit('loaded')))
    }

    onMounted(getItems)
</script>

<style scoped>
.hidden_scrollbar{
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
.hidden_scrollbar::-webkit-scrollbar {
    display: none;
}
.product-item{
    width: 25vw;
    height: 270px;
}
@media (max-width: 600px) {
    .product-item{
        width: 40vw;
        height: 270px;
    }
}
</style>
