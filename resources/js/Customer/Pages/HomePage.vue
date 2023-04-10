<template>

    <section class="section-intro padding-y">
        <div class="container">
            <slider-component/>
        </div>
    </section>
    <div class="container">

        <!-- =============== SECTION 1 =============== -->
        <section class="padding-bottom">
            <header class="section-heading mb-4">
                <h3 class="title-section">Recommended items</h3>
            </header>

<!--            <recomended-items/>-->
        </section>
        <!-- =============== SECTION 1 END =============== -->
        <banners-component />

        <!-- =============== SECTION 2 =============== -->
        <section class="padding-bottom">

            <header class="section-heading mb-4">
                <h3 class="title-section">Daily deals</h3>
            </header>
<!--            <daily-deals/>-->
        </section>
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
