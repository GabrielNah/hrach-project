import {createRouter, createWebHistory} from "vue-router/dist/vue-router";
import adminRoutes from "./Admin/adminRoutes";
import customerRoutes from "./Customer/customerRoutes";
import AdminLayout from "../Admin/Layouts/AdminLayout.vue";
import MainLayout from "../Customer/Layouts/MainLayout.vue";
const router= createRouter({
    history:createWebHistory(),
    routes:[
        {
            path:'',
            component:MainLayout,
            children:customerRoutes()
        },
        {
            path:'/admin',
            component:AdminLayout,
            children:adminRoutes()
        }
    ]
})

export default router
