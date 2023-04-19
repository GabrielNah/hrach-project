import AdminLogin from "../../Admin/Auth/AdminLogin.vue";
import AdminDashboard from "../../Admin/Pages/AdminDashboard.vue";
import DashboardLayout from "../../Admin/Layouts/DashboardLayout.vue";
import Categories from "../../Admin/Pages/Categories.vue";
import ProductList from "../../Admin/Pages/Products/ProductList.vue";
import AddProduct from "../../Admin/Pages/Products/AddProduct.vue";
import Settings from "../../Admin/Pages/Settings.vue";
import EditProduct from "../../Admin/Pages/Products/EditProduct.vue";
import SliderMaker from "../../Admin/Pages/Slider/SliderMaker.vue";
import Banners from "../../Admin/Pages/Banners.vue";
import Inquiries from "../../Admin/Pages/Inquiry/Inquiries.vue";
import HomePageSettings from "../../Admin/Pages/HomePageSettings.vue";
import ContactInfo from "../../Admin/Pages/ContactInfo/ContactInfo.vue";
import Subscribers from "../../Admin/Pages/Subscribers.vue";
import PrivacySettings from "@/Admin/Pages/PrivacySettings.vue";

export const ADMIN_LOGIN_ROUTE='admin.login';
export const ADMIN_DASHBOARD_ROUTE='admin.dashboard';
export const ADMIN_CATEGORIES_ROUTE='admin.categories';
export const ADMIN_PRODUCT_LIST='admin.product.list';
export const ADMIN_PRODUCT_ADD='admin.product.add';
export const ADMIN_SETTING_ROUTE='admin.settings';
export const ADMIN_PRODUCT_EDIT='admin.products.edit';
export const ADMIN_SLIDER_EDIT = 'admin.slider.edit';
export const ADMIN_BANNERS_EDIT = 'admin.banners.edit';
export const ADMIN_INQUIRES = 'admin.inquiries';
export const ADMIN_HOME_PAGE_SETTINGS = 'admin.home.page.settings';
export const ADMIN_CONTACT_INFO = 'admin.contact.info';
export const ADMIN_SUBSCRIBERS = 'admin.subscribers';
export const ADMIN_PRIVACY = 'admin.privacy';

export default ()=>([
    {
        path:'',
        name:ADMIN_LOGIN_ROUTE,
        component:AdminLogin,
        meta:{title:'Login'}
    },
    {
        path:'dashboard',
        component:DashboardLayout,
        children:[
            {
                path:'',
                name:ADMIN_DASHBOARD_ROUTE,
                component:AdminDashboard,
                meta:{title:'Admin dashboard'}
            },
            {
                path:'categories',
                name:ADMIN_CATEGORIES_ROUTE,
                component:Categories,
                meta:{title:'Categories'}
            },
            {
                path:'products',
                name:ADMIN_PRODUCT_LIST,
                component:ProductList,
                meta:{title:'List of products'}
            },
            {
                path:'products/add',
                name:ADMIN_PRODUCT_ADD,
                component:AddProduct,
                meta:{title:'Add product'}

            },
            {
                path: 'product/:id/edit',
                name: ADMIN_PRODUCT_EDIT,
                component:EditProduct ,
                meta:{title:'Product details'}
            },
            {
                path:'settings',
                name:ADMIN_SETTING_ROUTE,
                component:Settings,
                meta:{title:'Settings'}
            },
            {
                path:'slider',
                name:ADMIN_SLIDER_EDIT,
                component: SliderMaker,
                meta:{title:'Sliders'}
            },
            {
                path:'banners',
                name:ADMIN_BANNERS_EDIT,
                component: Banners,
                meta:{title:'Banners'}
            },
            {
                path:'inquiries',
                name:ADMIN_INQUIRES,
                component: Inquiries,
                meta:{title:'Inquiries'}
            },
            {
                path:'home_settings',
                name:ADMIN_HOME_PAGE_SETTINGS,
                component: HomePageSettings,
                meta:{title:'Home page settings'}
            },
            {
                path:'contact',
                name:ADMIN_CONTACT_INFO,
                component: ContactInfo,
                meta:{title:'Contact info'}
            },
            {
                path:'subscribers',
                name:ADMIN_SUBSCRIBERS,
                component: Subscribers,
                meta:{title:'Subscribers'}
            },
            {
                path:'privacy',
                name:ADMIN_PRIVACY,
                component: PrivacySettings,
                meta:{title:'Privacy'}
            }
        ]
    }
])
