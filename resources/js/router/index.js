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
            beforeEnter(){
                addScriptsAndStyles();
                return true;
            },
            children:customerRoutes()
        },
        {
            path:'/admin',
            component:AdminLayout,
            children:adminRoutes()
        }
    ]
})
const addScriptsAndStyles = () => {
  document.head.innerHTML+='<link href="/css/responsive.css" rel="stylesheet" type="text/css" />'
  document.head.innerHTML+='<link href="/css/ui.css" rel="stylesheet" type="text/css"/>'

}
export default router
