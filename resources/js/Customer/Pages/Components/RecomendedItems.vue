<template>
    <section class="padding-bottom">
        <header class="section-heading mb-4">
            <h3 class="title-section">{{ pageSettings.section_name }}</h3>
        </header>
        <div class="row gap-3">
            <template v-if="pageSettings.products.length">
                <template v-for="product in pageSettings.products" :id="product.id">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-6 product-card">
                        <product-cart :product="product"/>
                    </div>
                </template>
            </template>
        </div>
        <div class="d-flex justify-content-center align-items-center w-100 p-1" v-if="onGoingFetch">
            <mini-loader/>
        </div>
        <div class="w-100 text-center button-34" v-if="pageSettings.next_page_url"
            @click="getNextPageData"
        >
            Show more
        </div>

    </section>

</template>

<script>
import ProductCart from "./Product-cart.vue";
import {defineComponent, nextTick, reactive, defineEmits, ref} from "vue";
import MiniLoader from "@/SharedComponents/MiniLoader.vue";

export default defineComponent({
    name: "RecomendedItems",
    components: {MiniLoader, ProductCart },
    setup(prop,{emit}) {
        const pageSettings = reactive({
            section_name: "",
            products: [],
            next_page_url: "",
        });
        const onGoingFetch=ref(false)
        const setOngoingFetch=(state)=>{onGoingFetch.value=state}
        const getNextPageData = () => {
            if (!pageSettings.next_page_url) return;
            setOngoingFetch(true)
            window.axios.get(pageSettings.next_page_url)
                .then(({ data }) => {
                    pageSettings.section_name = data.pageSettings.section_name;
                    pageSettings.products.push(
                        ...data.pageSettings.products.products
                    );
                    pageSettings.next_page_url = data.pageSettings.products.next_page_url
                        ? data.pageSettings.products.next_page_url + "&&main=true"
                        : null;
                })
                .finally(()=>setOngoingFetch(false));
        };
        const getProducts = () => {
            window.axios.get("/product/front_page?main=true")
                .then(({ data }) => {
                    pageSettings.section_name = data.pageSettings.section_name;
                    pageSettings.products = data.pageSettings.products.products;
                    pageSettings.next_page_url = data.pageSettings.products.next_page_url
                        ? data.pageSettings.products.next_page_url + "&&main=true"
                        : null;
                })
            .finally(()=>nextTick(()=>emit('loaded')));
        };
        getProducts()
        return { pageSettings, getNextPageData,onGoingFetch };
    },
});
</script>


<style scoped>
.button-34 {
    margin-top:15px;
    background: #5E5DF0;
    border-radius: 999px;
    box-shadow: #5E5DF0 0 10px 20px -10px;
    box-sizing: border-box;
    color: #FFFFFF;
    cursor: pointer;
    font-family: Inter,Helvetica,"Apple Color Emoji","Segoe UI Emoji",NotoColorEmoji,"Noto Color Emoji","Segoe UI Symbol","Android Emoji",EmojiSymbols,-apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue","Noto Sans",sans-serif;
    font-size: 16px;
    font-weight: 700;
    line-height: 24px;
    opacity: 1;
    outline: 0 solid transparent;
    padding: 8px 18px;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    width: fit-content;
    word-break: break-word;
    border: 0;
}

.product-card{
    width: 20vw;
    height: 350px;
}
</style>
