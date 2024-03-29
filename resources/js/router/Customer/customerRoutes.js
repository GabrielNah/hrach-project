import HomePage from "../../Customer/Pages/HomePage.vue";
import ProductDetails from "../../Customer/Pages/Components/Product-Details.vue";
import SearchedProducts from "../../Customer/Pages/SearchedProducts.vue";

export const USER_HOME_PAGE='user.home';
export const PRODUCT_DETAIL_PAGE='product.detail';
export const PRODUCT_LIST_PAGE='product.list';
export default ()=>([
    {
        path:'',
        name:USER_HOME_PAGE,
        component:HomePage,
        meta:{title:'Home'}
    },
    {
      path:'products/list/:category?',
      name: PRODUCT_LIST_PAGE,
      component:SearchedProducts,
      meta: {title:'Products'}
    },
    {
        path: 'product/:id',
        name: PRODUCT_DETAIL_PAGE,
        component: ProductDetails,
        meta: {title:'Product details'}
    },
])
