<template>
    <section class="padding-bottom">
        <div class="d-flex flex-row justify-content-around align-items-center flex-wrap w-100 ">
            <template v-if="banners.length">
                <div class="col-5 mb-3 position-relative" v-for="banner in banners"
                     :key="banner.id"
                >
                     <slot  :banner="banner" />
                    <div class="card card-banner-lg bg-dark">
                        <img :src="'/'+banner.image" class="card-img opacity">
                        <div class="card-img-overlay text-white">
                            <h2 class="card-title">
                                {{ banner.title }}
                            </h2>
                            <p class="card-text" style="max-width: 80%">
                                {{ banner.description }}
                            </p>
                            <button  class="btn btn-light"
                                     @click="search.searchByIds(banner.value || [])"
                             >
                                {{ banner.link_text }}
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </section>
</template>

<script>
import {inject, onMounted, ref} from "vue";

export default {
    name: "BannersComponent",
    setup(){
        const banners=ref([])
        const search=inject('searchHelper')
        const getBanners=()=>{
            axios.get('/banners')
                .then(({data})=>{
                    banners.value=data.banners
                })
        }
        onMounted(getBanners)

        return {
            banners,
            search
        }
    }
}
</script>


<style scoped>
.product-item{
    background: #FFFFFF;
    border: 1px solid #EBECF0;
    box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.25);
    border-radius: 15px;
}
</style>
