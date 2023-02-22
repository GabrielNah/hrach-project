<template>
    <header-component/>
    <router-view/>
    <footer-component/>
</template>

<script>
import HeaderComponent from "./Components/HeaderComponent.vue";
import FooterComponent from "./Components/FooterComponent.vue";

export default {
    name: "MainLayout",
    components:{
        FooterComponent,
        HeaderComponent
    }
}
</script>

<style scoped>

</style>
