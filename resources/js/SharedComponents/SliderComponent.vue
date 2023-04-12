<template>
    <div id="carouselExampleCaptions" v-show="slides.length"
         class="carousel slide" data-bs-interval="3000"
         data-bs-ride="carousel">
        <div class="carousel-inner" id="slider-component">
            <template v-for="(slide,index) in slides" :key="slide.id">
                    <div class="carousel-item "  :class="{'active':index===0}">
                        <div class="position-absolute" style="top: 10px;right: 10px;z-index: 2000">
                            <slot :slider="slides[activeIndex]"/>
                        </div>
                        <img :src="'/'+slide.image" class="d-block w-100" alt="...">
                        <div class="carousel-caption  d-md-block">
                            <h5>{{ slide.title }}</h5>
                            <p class="pointer" @click="searchByIds(slide.value || [])">
                                {{ slide.link_text}}
                            </p>
                        </div>
                    </div>
            </template>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</template>

<script>
import {Carousel} from "bootstrap"
import {inject} from "vue";
export default {
    name: "SliderComponent",
    data:()=>({
        activeIndex:0,
        slides:[]
    }),
    methods:{
        getSlides(){
            axios.get('/slider')
            .then(({data})=>{
                this.slides=data.sliders
            })
        }
    },
    setup(){
        const {searchByIds}=inject('searchHelper')

        return{
            searchByIds
        }
    },
    mounted() {
                this.getSlides()
                const carousel = new Carousel(document.getElementById("carouselExampleCaptions"))

                carousel._element.addEventListener('slide.bs.carousel', (event) => {
                    this.activeIndex = event.to
                });
                setTimeout(()=>{
                    document.querySelector('.carousel-control-next')?.click();
                },3000)
    }
}
</script>

<style scoped>
.pointer{
    cursor: pointer;
}
</style>
