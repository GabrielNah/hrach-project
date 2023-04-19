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
        },
        {
            path:'/:pathMatch(.*)*',
            name:'not-found',
            component:()=>import('../SharedComponents/NotFound.vue')
        }
    ]
})
const addCustomersScriptsAndStyles = () => {
  document.head.innerHTML+='<link href="/css/responsive.css" rel="stylesheet" type="text/css" />'
  document.head.innerHTML+='<link href="/css/ui.css" rel="stylesheet" type="text/css"/>'

}

const changeTitle=(to)=>{

    document.title=import.meta.env.VITE_APP_NAME + ' | ' +to.meta.title
}
const addAdminsScriptAndStyles=()=>{
    document.head.innerHTML+='<link href="/css/Admin/app.min.css" rel="stylesheet" type="text/css" />'
    document.head.innerHTML+='<link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css" />'
}

router.beforeEach((to,from,next)=>{
    changeTitle(to)
    next()
})
export default router
