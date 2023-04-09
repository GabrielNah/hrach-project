<template>
    <section class="padding-bottom">
        <div class="d-flex flex-row justify-content-around align-items-center flex-wrap w-100 ">
            <div class="col-5 mb-3 position-relative" v-for="banner in banners"
                 :key="banner.id"
            >
                <div class="card card-banner-lg bg-dark">
                    <img :src="'/'+banner.image" class="card-img opacity">
                    <slot  :banner="banner" />
                    <div class="card-img-overlay text-white">
                        <h2 class="card-title">
                            {{ banner.title }}
                        </h2>
                        <p class="card-text" style="max-width: 80%">
                            {{ banner.description }}
                        </p>
                        <a href="#" class="btn btn-light">
                            {{ banner.link_text }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "BannersComponent",
    data:()=>({
        banners:[],
    }),
    methods:{
        getBanners(){
            axios.get('/api/banners')
            .then(({data})=>{
              this.banners=data.banners
            })
        },
    },
    mounted() {
        this.getBanners()
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
