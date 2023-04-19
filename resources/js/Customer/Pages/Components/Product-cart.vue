<template>
    <div class="card card-product-grid product-item w-100 h-100 d-flex position-relative"
         v-if="product"
         :class=" horizontal ?'flex-row':'flex-column'"
    >
        <div v-if="(product?.tags?.length && !horizontal)"
            class="position-absolute tag-wrapper"
        >
            {{ product.tags[0].name }}
        </div>
        <div v-if="(product?.price_for_one?.discount && !horizontal)"
            class="position-absolute discount-wrapper"
        >
            {{ product.price_for_one.discount }} % OFF
        </div>


        <router-link class="img-wrap p-1 "
                     :style="{height:horizontal ? '90%' : '65%'}"
                     :to="productRoute(product.id)"
                     :class="horizontal ? 'w-50' :'w-100'"
        >
            <template v-if="product.general_file.type === 'video'">
                <video :src="'/'+product.general_file.path" autoplay loop muted
                       class="w-100 h-100"></video>
            </template>
            <template v-if="product.general_file.type === 'image'">
                <img :src="'/'+product.general_file.path" class="w-100 h-100">
            </template>

        </router-link>
        <figcaption class="info-wrap">
            <div class="d-flex gap-1">
                <svg v-for="i in 5" fill="none" height="15" viewBox="0 0 16 15" width="16"
                     xmlns="http://www.w3.org/2000/svg">
                    <path :fill="i <= product.rating ?'#FF9017':'#D5CDC5'" clip-rule="evenodd" d="M8 12.0553L12.944 15L11.632 9.45L16 5.71579L10.248 5.23421L8 0L5.752 5.23421L0 5.71579L4.368 9.45L3.056 15L8 12.0553Z"
                          fill-rule="evenodd"/>
                </svg>
            </div>
            <div class="product_title">
                <router-link class="title" :to="productRoute(product.id)"
                >
                    {{ product.title }}
                </router-link>
            </div>
            <template v-if="horizontal">
                <div class="price h5 mt-2 d-flex justify-content-between" >
                    <span style="max-width: 23ch;">{{ product.name }}</span>
                </div>
                <div class="price h5 mt-2 d-flex justify-content-between" >
                    <span style="max-width: 120ch;">{{ product.description }}</span>
                </div>
                <template v-if="product?.tags?.length">
                    <div class="d-flex gap-1">
                        <div class="tag-wrapper" v-for="tag in product.tags"
                             :key="tag.id"
                        >
                            {{ tag.name }}
                        </div>
                    </div>

                </template>
            </template>

            <div class="price h5 mt-2 d-flex gap-2 align-items-center ">
                <span
                  :class="{'text-decoration-line-through':product?.price_for_one?.discount}"
                >
                    {{ product?.price_for_one?.price }}$
                </span>
                <span v-if="product?.price_for_one?.discount">
                    {{
                    calculateDiscountedPrice(
                        product?.price_for_one?.price,
                        product?.price_for_one?.discount
                        )
                    }}$
                </span>
                <span class="discount-wrapper" v-if="(product?.price_for_one?.discount) && horizontal">
                    {{ product?.price_for_one?.discount }} % OFF
                </span>
            </div> <!-- price.// -->
        </figcaption>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import calculateDiscountedPrice from "../../../Services/DiscountCalulator";
export default defineComponent({
    name: "Product-cart",
    props:{
        product:{
            type:Object,
            required:true
        },
        horizontal:{
            type:Boolean,
            required: false,
            default:()=>false
        }
    },
    methods:{
        productRoute(id){
            return {name:'product.detail',params:{id}}
        }
    },
    setup(){
        return {
            calculateDiscountedPrice
        }
    }
})
</script>

<style scoped>
.card{
    transition: 0.2s ease-out all;
}
.tag-wrapper{
    right: 12px;
    top: 16px;
    z-index: 10;
    background: linear-gradient(266.67deg, #FC56FF 1.03%, #9543C8 74.14%);
    border-radius: 20px;
    font-family: 'Inter';
    font-style: normal;
    font-weight: 600;
    font-size: 12px;
    line-height: 20px;
    padding: 4px 12px;
    /* or 195% */

    display: flex;
    align-items: center;
    text-align: center;

    color: #FFFFFF;
}

    .discount-wrapper{


        font-family: 'Inter';
        z-index: 5;
        font-style: normal;
        font-weight: 600;
        font-size: 12px;
        line-height: 12px;
        /* identical to box height, or 100% */

        display: flex;
        align-items: center;
        text-align: center;

        color: #FFFFFF;
        flex-direction: row;
        padding: 4px;

        left: 10px;
        top: 16px;

        background: #FA3434;
        border-radius: 5.55px;
    }

    .card:hover,:focus{
        transition: 0.2s ease-out all;
        transform: scale(1.08);
        box-shadow: 5px 7px 15px -1px rgba(0,0,0,0.75);
        -webkit-box-shadow: 5px 7px 15px -1px rgba(0,0,0,0.75);
        -moz-box-shadow: 5px 7px 15px -1px rgba(0,0,0,0.75);
    }
</style>
