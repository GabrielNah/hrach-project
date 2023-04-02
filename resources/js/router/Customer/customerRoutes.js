import HomePage from "../../Customer/Pages/HomePage.vue";
import ProductDetails from "../../Customer/Pages/Components/Product-Details.vue";
// import ProductDetails from "../../SharedComponents/Product/ProductDetails.vue";

export const USER_LOGIN='user.login'
export const USER_HOME_PAGE='user.home'
export const PRODUCT_DETAIL_PAGE='product.detail'
export default ()=>([
    {
        path:'',
        name:USER_HOME_PAGE,
        component:HomePage
    },
    {
        path:'product/:id',
        name:PRODUCT_DETAIL_PAGE,
        component:ProductDetails
    },
])
