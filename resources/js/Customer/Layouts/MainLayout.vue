<template>
        <div class="wrapped"
             v-show="!(headerLoaded && contentLoaded && footerLoaded)"
        >
            <loader/>
        </div>
        <header-component @loaded="headerLoaded=true"
                          :appearance="appearanceFor('header')"
        />
        <div class="main-content" :style="properAppearance(appearanceFor('main'))">
            <router-view @loaded="contentLoaded=true"
            />
        </div>
        <footer-component @loaded="footerLoaded=true"
                          :appearance="appearanceFor('footer')"
        />
</template>

<script>
import HeaderComponent from "./Components/HeaderComponent.vue";
import FooterComponent from "./Components/FooterComponent.vue";
import useProductSeachHelper from "../Camposables/useProductSeachHelper";
import {provide, ref} from "vue";
import Loader from "../../SharedComponents/Loader.vue";
import handleAppearance from "../../Mixins/handleAppearance";

export default {
    name: "MainLayout",
    components:{
        Loader,
        FooterComponent,
        HeaderComponent
    },mixins:[handleAppearance],
    setup(){
        const search=useProductSeachHelper


        const headerLoaded=ref(false)
        const footerLoaded=ref(false)
        const contentLoaded=ref(false)
        const appearances=ref([]);

        const appearanceFor=(section)=>{
            if (!appearances.value.length){
                return {}
            }
            let appearance=appearances.value.find(sec=>sec.section === section)
            if (!appearance){
                return {}
            }
            return appearance
        }
        const getAppearances=()=>{
            window.axios.get('/appearance')
                .then(({data})=>{
                    appearances.value=data.appearance
                })
        }
        getAppearances()
        provide('searchHelper',search)



        return {
            headerLoaded,
            footerLoaded,
            contentLoaded,
            appearanceFor
        }
    }
}
</script>

<style >
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
.main-content{
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size: cover;
    width: 100vw;
    padding-bottom: 10px;
}
</style>
