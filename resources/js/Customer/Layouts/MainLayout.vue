<template>
    <header-component/>
    <router-view/>
    <footer-component/>
</template>

<script>
import HeaderComponent from "./Components/HeaderComponent.vue";
import FooterComponent from "./Components/FooterComponent.vue";
import useProductSeachHelper from "../Camposables/useProductSeachHelper";
import {provide} from "vue";

export default {
    name: "MainLayout",
    components:{
        FooterComponent,
        HeaderComponent
    },setup(){
        const search=useProductSeachHelper
        provide('searchHelper',search)
    }
}
</script>

<style scoped>

</style>
