<template>

    <section class="section-intro padding-y">
        <div class="container">
            <slider-component/>
        </div>
    </section>
    <div class="container">

        <!-- =============== SECTION 1 =============== -->


         <recomended-items/>

        <!-- =============== SECTION 1 END =============== -->
        <banners-component />

        <!-- =============== SECTION 2 =============== -->
        <daily-deals/>
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
    components: {
        DailyDeals,
        RecomendedItems,
        HeaderComponent,
        BannersComponent,
        SliderComponent
    }
}
</script>

<style scoped>

</style>
