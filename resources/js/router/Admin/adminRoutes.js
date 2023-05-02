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
        component:()=>import("../../Admin/Auth/AdminLogin.vue"),
        meta:{title:'Login'}
    },
    {
        path:'dashboard',
        component:()=>import("../../Admin/Layouts/DashboardLayout.vue"),
        children:[
            {
                path:'',
                name:ADMIN_DASHBOARD_ROUTE,
                component:()=>import("../../Admin/Pages/AdminDashboard.vue"),
                meta:{title:'Admin dashboard'}
            },
            {
                path:'categories',
                name:ADMIN_CATEGORIES_ROUTE,
                component:()=>import("../../Admin/Pages/Categories.vue"),
                meta:{title:'Categories'}
            },
            {
                path:'products',
                name:ADMIN_PRODUCT_LIST,
                component:()=>import("../../Admin/Pages/Products/ProductList.vue"),
                meta:{title:'List of products'}
            },
            {
                path:'products/add',
                name:ADMIN_PRODUCT_ADD,
                component:()=>import("../../Admin/Pages/Products/AddProduct.vue"),
                meta:{title:'Add product'}

            },
            {
                path: 'product/:id/edit',
                name: ADMIN_PRODUCT_EDIT,
                component: ()=>import("../../Admin/Pages/Products/EditProduct.vue"),
                meta:{title:'Product details'}
            },
            {
                path:'settings',
                name:ADMIN_SETTING_ROUTE,
                component:()=>import("../../Admin/Pages/Settings.vue"),
                meta:{title:'Settings'}
            },
            {
                path:'slider',
                name:ADMIN_SLIDER_EDIT,
                component: ()=>import("../../Admin/Pages/Slider/SliderMaker.vue"),
                meta:{title:'Sliders'}
            },
            {
                path:'banners',
                name:ADMIN_BANNERS_EDIT,
                component: ()=>import("../../Admin/Pages/Banners.vue"),
                meta:{title:'Banners'}
            },
            {
                path:'inquiries',
                name:ADMIN_INQUIRES,
                component: ()=>import("../../Admin/Pages/Inquiry/Inquiries.vue"),
                meta:{title:'Inquiries'}
            },
            {
                path:'home_settings',
                name:ADMIN_HOME_PAGE_SETTINGS,
                component: ()=>import("../../Admin/Pages/HomePageSettings.vue"),
                meta:{title:'Home page settings'}
            },
            {
                path:'contact',
                name:ADMIN_CONTACT_INFO,
                component: ()=>import("../../Admin/Pages/ContactInfo/ContactInfo.vue"),
                meta:{title:'Contact info'}
            },
            {
                path:'subscribers',
                name:ADMIN_SUBSCRIBERS,
                component: ()=>import("../../Admin/Pages/Subscribers.vue"),
                meta:{title:'Subscribers'}
            },
            {
                path:'privacy',
                name:ADMIN_PRIVACY,
                component: ()=>import("@/Admin/Pages/PrivacySettings.vue"),
                meta:{title:'Privacy'}
            }
        ]
    }
])
