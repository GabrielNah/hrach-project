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
                addCustomersScriptsAndStyles();
                return true;
            },
            children:customerRoutes()
        },
        {
            path:'/admin',
            component:AdminLayout,
            children:adminRoutes(),
            beforeEnter(){
                addAdminsScriptAndStyles();
                return true;
            },
        }
    ]
})
const addCustomersScriptsAndStyles = () => {
  document.head.innerHTML+='<link href="/css/responsive.css" rel="stylesheet" type="text/css" />'
  document.head.innerHTML+='<link href="/css/ui.css" rel="stylesheet" type="text/css"/>'

}
const addAdminsScriptAndStyles=()=>{
    document.head.innerHTML+='<link href="/css/Admin/app.min.css" rel="stylesheet" type="text/css" />'
    document.head.innerHTML+='<link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css" />'
}
export default router
