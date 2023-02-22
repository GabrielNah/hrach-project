import AdminLogin from "../../Admin/Auth/AdminLogin.vue";
import AdminDashboard from "../../Admin/Pages/AdminDashboard.vue";
import DashboardLayout from "../../Admin/Layouts/DashboardLayout.vue";
import Categories from "../../Admin/Pages/Categories.vue";

export const ADMIN_LOGIN_ROUTE='admin.login'
export const ADMIN_DASHBOARD_ROUTE='admin.dashboard'
export const ADMIN_CATEGORIES_ROUTE='admin.categories'

export default ()=>([
    {
        path:'',
        name:ADMIN_LOGIN_ROUTE,
        component:AdminLogin
    },
    {
        path:'dashboard',
        component:DashboardLayout,
        children:[
            {
                path:'',
                name:ADMIN_DASHBOARD_ROUTE,
                component:AdminDashboard
            },
            {
                path:'categories',
                name:ADMIN_CATEGORIES_ROUTE,
                component:Categories
            }
        ]
    }
])
