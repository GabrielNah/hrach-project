<template>
        <div class="wrapped"
             v-show="!(headerLoaded && contentLoaded && footerLoaded)"
        >
            <loader/>
        </div>
        <header-component @loaded="headerLoaded=true"
        />
        <router-view @loaded="contentLoaded=true"
        />
        <footer-component @loaded="footerLoaded=true"
        />
</template>

<script>
import HeaderComponent from "./Components/HeaderComponent.vue";
import FooterComponent from "./Components/FooterComponent.vue";
import useProductSeachHelper from "../Camposables/useProductSeachHelper";
import {provide, ref} from "vue";
import Loader from "../../SharedComponents/Loader.vue";

export default {
    name: "MainLayout",
    components:{
        Loader,
        FooterComponent,
        HeaderComponent
    },setup(){
        const search=useProductSeachHelper


        const headerLoaded=ref(false)
        const footerLoaded=ref(false)
        const contentLoaded=ref(false)
        provide('searchHelper',search)



        return {
            headerLoaded,
            footerLoaded,
            contentLoaded
        }
    }
}
</script>

<style >
#app{
    background-color: #8B8B8B;
}
</style>
<style scoped>
.wrapped{
    width: 100vw;
    height: 100vh;
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    background: black;
    z-index: 30000;
}
</style>
