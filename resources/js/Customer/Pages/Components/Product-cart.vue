<template>
    <div class="card card-product-grid product-item w-100 h-100 d-flex flex-column">
        <a href="#" class="img-wrap w-100 p-1 flex-grow-1">
            <template v-if="product.general_file.type === 'video'">
                <video :src="'/'+product.general_file.path" autoplay controls class="w-100 h-100"></video>
            </template>
            <template v-if="product.general_file.type === 'image'">
                <img :src="'/'+product.general_file.path" class="w-100 h-100">
            </template>

        </a>
        <figcaption class="info-wrap">
            <div class="d-flex gap-1">
                <svg v-for="i in 5" fill="none" height="15" viewBox="0 0 16 15" width="16"
                     xmlns="http://www.w3.org/2000/svg">
                    <path :fill="i <= product.rating ?'#FF9017':'#D5CDC5'" clip-rule="evenodd" d="M8 12.0553L12.944 15L11.632 9.45L16 5.71579L10.248 5.23421L8 0L5.752 5.23421L0 5.71579L4.368 9.45L3.056 15L8 12.0553Z"
                          fill-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <a href="#" class="title">{{ product.title }}</a>
            </div>
            <div class="price h5 mt-2 d-flex justify-content-between">
                <span>{{ product.price_for_one.price }}$</span>
            </div> <!-- price.// -->
        </figcaption>
    </div>
</template>

<script>
export default {
    name: "Product-cart",
    props:{
        product:{
            type:Object,
            required:true
        }
    }
}
</script>

<style scoped>

</style>
