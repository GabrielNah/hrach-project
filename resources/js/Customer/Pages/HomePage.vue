<template>

    <section class="section-intro padding-y">
        <div class="container">
            <slider-component @loaded="loadCount++"/>
        </div>
    </section>
    <div class="container">

        <!-- =============== SECTION 1 =============== -->


         <recomended-items @loaded="loadCount++"/>

        <!-- =============== SECTION 1 END =============== -->
        <banners-component @loaded="loadCount++"/>

        <!-- =============== SECTION 2 =============== -->
        <daily-deals @loaded="loadCount++"
        />
        <!-- =============== SECTION 2 END =============== -->


    </div>


</template>

<script>
import SliderComponent from "../../SharedComponents/SliderComponent.vue";
import HeaderComponent from "../Layouts/Components/HeaderComponent.vue";
import RecomendedItems from "./Components/RecomendedItems.vue";
import DailyDeals from "./Components/Daily-deals.vue";
import BannersComponent from "../../SharedComponents/BannersComponent.vue";
export default {
    name: "HomePage",
    emits:['loaded'],
    components: {
        DailyDeals,
        RecomendedItems,
        HeaderComponent,
        BannersComponent,
        SliderComponent
    },data:()=>({
        loadCount:0
    }),
    watch:{
        loadCount(val){
            if (val===4){
                this.$emit('loaded')
            }
        }
    }
}
</script>

<style scoped>

</style>
