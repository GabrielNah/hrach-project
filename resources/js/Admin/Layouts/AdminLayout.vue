<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-gradient bordered">
        <div class="container">
            <span class="navbar-brand" v-if="adminName">
                {{ adminName }}
            </span>
            <span class="navbar-brand" v-else>
                Our Logo Here
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item active" @click="logout">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <router-view v-if="Mounted"/>
    <div v-else class="d-flex justify-content-center align-items-center" style="width: 100vw; height: 100vh">
        <loader />
    </div>
</template>

<script>
import HTTP from "../Axios/axiosCongif";
import {ADMIN_DASHBOARD_ROUTE, ADMIN_LOGIN_ROUTE} from "../../router/Admin/adminRoutes";
import {redirectToRouteByName} from "../../Services/GlobalHelpers";
import { useAdminStore} from "../Store";
import {computed,  provide, ref, watchEffect} from "vue";
import {useRoute} from "vue-router";
import Loader from "../../SharedComponents/Loader.vue";
import useProductSeachHelper from "../../Customer/Camposables/useProductSeachHelper";

export default {
    name: "AdminLayout",
    components: {Loader},
    setup(){
        const store=useAdminStore()
        provide('store',store)
        const search=useProductSeachHelper
        provide('searchHelper',search)
        const route=useRoute();
        const routeName = computed(()=>route.name)
        const Mounted=ref(false)

        const adminName = computed(() => store.getters.admin.value?.name)
        const setMounted=()=>Mounted.value=true
        const getAdmin =async () => {
            try {
                let {data:{admin}}=await HTTP.get('/me')
                store.actions.setAdmin(admin)
            }catch (e) {
                store.actions.setAdmin(null)
            }
            setMounted(true)
        }

        const logout = async () => {
            try {
                let {data:{success}}=await HTTP.post('/logout')
                if (success){
                    store.actions.setAdmin(null)
                    redirectToRouteByName(ADMIN_LOGIN_ROUTE)
                }
            }catch (e) {
                store.actions.setAdmin(null)
                redirectToRouteByName(ADMIN_LOGIN_ROUTE)
            }
        }
        watchEffect(async ()=>{
            if (routeName.value){
                await getAdmin()
            }
            if (routeName.value===ADMIN_LOGIN_ROUTE){
                if (store.getters.admin.value){
                    redirectToRouteByName(ADMIN_DASHBOARD_ROUTE)
                }
            }
        })

        return {
            logout,
            Mounted,
            adminName
        }

    }
}
</script>

<style scoped>
.bordered{
    border: 1px solid #1a202c;
}
</style>
