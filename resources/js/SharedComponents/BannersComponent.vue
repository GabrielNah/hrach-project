<template>
    <section class="padding-bottom position-relative" >
        <span id="left-arrow" class="arrow"
            @click="scrollLeft"
        >&lsaquo;
        </span>
        <span id="right-arrow" class="arrow"
            @click="scrollRight"
        >
            &rsaquo;
        </span>
        <div class="d-flex flex-row justify-content-around align-items-center flex-wrap w-100 holder"
             ref="banners_scrollbar"
        >
            <template v-if="banners.length">
                <div class="col-5 mb-3 position-relative banner" v-for="(banner,i) in banners"
                     :key="banner.id"
                     :class="{'first':i===0}"
                >
                     <slot  :banner="banner" />
                    <div class="card card-banner-lg bg-dark">
                        <img :src="'/'+banner.image" class="card-img opacity">
                        <div class="card-img-overlay text-white">
                            <h2 class="card-title">
                                {{ banner.title }}
                            </h2>
                            <p class="card-text" >
                                {{ banner.description }}
                            </p>
                            <div class="botton">
                                <button  class="btn btn-light"
                                         @click="search.searchByIds(banner.value || [])"
                                >
                                    {{ banner.link_text }}
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </section>
</template>

<script>
import {computed, inject, onMounted, ref} from "vue";

export default {
    name: "BannersComponent",
    methods:{
       scrollLeft(){
           const scrollContainer = this.$refs.banners_scrollbar;
           if (!scrollContainer){
               return;
           }
           if (scrollContainer.scrollLeft <= 0)return;
           scrollContainer.scrollBy({
               left: -window.innerWidth * 0.8,
               behavior: 'smooth'
           });

       },
       scrollRight(){
           const scrollContainer = this.$refs.banners_scrollbar;
           if (!scrollContainer) {
               return;
           }
           if (scrollContainer.scrollLeft >= (scrollContainer.scrollWidth - scrollContainer.clientWidth)) {
               return;
           }
           scrollContainer.scrollBy({
               left: window.innerWidth * 0.8,
               behavior: 'smooth'
           })

       },
    } ,
    setup(props,ctx){
        const banners=ref([])
        const bannersCount=computed(()=>banners?.value?.length -1)
        const search=inject('searchHelper')
        const getBanners=()=>{
            axios.get('/banners')
                .then(({data})=>{
                    banners.value=data.banners
                })
        }
        getBanners()
        onMounted(()=>ctx.emit('loaded'))

        return {
            banners,
            search,
            bannersCount
        }
    },
}
</script>


<style scoped>
.product-item{
    background: #FFFFFF;
    border: 1px solid #EBECF0;
    box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.25);
    border-radius: 15px;
}
.arrow{
    display: none;
    width: 30px;
    height: 30px;
    padding: 2px;
    position: absolute;
    bottom:50%;
    z-index: 3;
    cursor: pointer;
    border-radius: 20px;
    text-align: center;
    line-height: 20px;
    justify-content: center;
    align-items: center;
    font-size: 30px;
    background-color: rgba(255, 255, 255, 0.58);
    transition: opacity 0.5s ease;
}
#left-arrow{
    left: 15px;
}
#right-arrow{
    right: 15px;
}
.banner{
    height: 37vh;
    width: 40vw;
    transition: all 0.2s ease-out;
    box-shadow: -2px 9px 16px 5px rgba(83,56,56,0.75);
    -webkit-box-shadow: -2px 9px 16px 5px rgba(83,56,56,0.75);
    -moz-box-shadow: -2px 9px 16px 5px rgba(83,56,56,0.75);
}
.banner:hover{
    transform: scale(1.3);
    z-index:45 ;
    transition: all 0.2s ease-out;
}
@media (max-width: 992px) and (min-width: 850px){
    .banner{
        height: 34vh;
        width: 34vw;
    }
}
@media (max-width: 850px) and (min-width: 555px){
    .banner{
        height: 40vh;
        width: 40vw;
    }
}
@media (max-width: 555px) {
    .arrow{display: flex}
    .banner{
        height: 25vh;
        width: 80vw;
        margin: 0 5px;
    }
    .holder{
        flex-wrap: nowrap !important;
        max-width: 99vw;
        position: relative;
        overflow: auto;
    }
    #right-arrow:focus,:active #right-arrow{
        background: #F2F3F7;
    }

    #left-arrow:focus,:active #left-arrow{
        background: #F2F3F7;
    }
    .first{
        margin-left:calc(v-bind(bannersCount) * 82vw)
    }
}
.banner img{
    max-width: 100%;
}

.banner:focus{
    height: 33vh;
    width: 33vw;
    transition: all 0.2s ease-out;
}
.banner>div{
    height: 100%
}
.banner>div>img{
    height: 100%;
}
.botton{
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    left: 0;
    right: 0;
    bottom:15px;
}
.card-text{
    overflow: hidden;
    text-overflow: ellipsis;
    max-height:9vh ;
    margin-bottom: 2px;
}
</style>
