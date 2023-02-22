import HomePage from "../../Customer/Pages/HomePage.vue";

export const USER_LOGIN='user.login'
export const USER_HOME_PAGE='user.home'
export default ()=>([
    {
        path:'',
        name:USER_HOME_PAGE,
        component:HomePage
    }
])
