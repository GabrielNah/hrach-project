<template>
    <product-details>
        <template v-slot:inquiry>
            <div class="send_inquiry">
                <div class="send_inquiry_button">
                    Send inquiry
                </div>
            </div>
        </template>
        <template v-slot:product_yo_may_like>
            <section class="prods_you_may_like">

                <h6>Products you may like</h6>

                <div class="prods">
                    <div v-for="i in 15" class="single_prod">
                        <img alt="" src="/images/posts/2.webp">
                        <div class="d-flex flex-column justify-content-evenly">
                            <span class="single_prod_text">Name</span>
                            <span class="single_prod_price">$145.05</span>
                        </div>

                    </div>
                </div>
            </section>
        </template>
        <template v-slot:related_product>
            <div class="related_products">
                <h6>Related products</h6>
                <div class="d-flex w-100 related_products_wrapper">
                    <div v-for="i in 8" class="one_related_product">
                        <img alt="" src="/images/posts/1.webp">
                        <span class="related_product_text">Product name</span>
                        <span class="related_product_price">$32.00-$40.00</span>
                    </div>
                </div>
            </div>
        </template>
    </product-details>
</template>

<script>
import ProductDetails from "../../../SharedComponents/Product/ProductDetails.vue";
export default {
    name: "Product-Details",
    components: {ProductDetails}
}
</script>

<style scoped>

</style>
