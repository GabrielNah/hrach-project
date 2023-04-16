<template>
    <div class="area"></div>
    <nav class="main-menu position-fixed d-flex align-items-center">
        <ul class="mt-lg-5 d-flex flex-column justify-content-center align-content-center gap-1">
            <li >
                <router-link :to="{name:ADMIN_DASHBOARD_ROUTE}"
                             :class="{'active':$route.name === ADMIN_DASHBOARD_ROUTE}"
                >
                    <i class="fa fa-home fa-2x"></i>
                    <span class="nav-text">
                            Home
                    </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{name:ADMIN_CATEGORIES_ROUTE}" active-class="active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="36" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                    <span  class="nav-text " >
                           Categories
                    </span>
                </router-link>

            </li>
            <li class="has-subnav">
                <router-link :to="{name:ADMIN_PRODUCT_LIST}" active-class="active">
                    <i class="fa fa-globe fa-2x"></i>
                    <span class="nav-text">
                        Products
                    </span>
                </router-link>

            </li>
            <li>
                <router-link :to="{name:ADMIN_SLIDER_EDIT}" active-class="active">
                    <i class="fa fa-camera-retro fa-2x"></i>
                        <span class="nav-text">
                            Slider
                        </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{name:ADMIN_BANNERS_EDIT}" active-class="active">

                <i class="fa fa-film fa-2x"></i>
                    <span class="nav-text">
                          Banners
                        </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{name:ADMIN_INQUIRES}" active-class="active">
                    <span v-if="InquiryExists" class="inquiry_count">
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                    </svg>
                    <span class="nav-text">
                           Inquiries
                    </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{name:ADMIN_SETTING_ROUTE}" active-class="active">
                    <i class="fa fa-cogs fa-2x"></i>
                    <span class="nav-text">
                            Settings
                    </span>
                </router-link>
            </li>
            <li class="has-subnav">
                <router-link :to="{name:ADMIN_HOME_PAGE_SETTINGS}" active-class="active">
                    <i class="fa fa-cogs fa-2x"></i>
                    <span class="nav-text">
                        Home page settings
                    </span>
                </router-link>

            </li>
            <li>
                <router-link :to="{name:ADMIN_SUBSCRIBERS}" active-class="active">
                    <i class="fa fa-book fa-2x"></i>
                    <span class="nav-text">
                           Subscribers
                    </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{name:ADMIN_CONTACT_INFO}" active-class="active">
                    <i class="fa fa-map-marker fa-2x"></i>
                    <span class="nav-text">
                           Contact information
                    </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{name:ADMIN_PRIVACY}" active-class="active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                    </svg>
                    <span class="nav-text">
                           Privacy
                    </span>
                </router-link>
            </li>
        </ul>
    </nav>
    <div class="w-100 d-flex justify-content-center" style="background-color: #2d3748;min-height: calc(100vh - 56px)">
        <div class="container" >
            <router-view v-if="loaded"/>
            <div v-else class="w-100 d-flex justify-content-center align-items-center " style="margin-top: 25%">
                <loader/>
            </div>
        </div>
    </div>

</template>

<script>


import {computed, inject, onBeforeMount, onMounted, ref} from "vue";
import {
    ADMIN_LOGIN_ROUTE,
    ADMIN_CATEGORIES_ROUTE,
    ADMIN_PRODUCT_LIST,
    ADMIN_SETTING_ROUTE,
    ADMIN_SLIDER_EDIT,
    ADMIN_BANNERS_EDIT,
    ADMIN_DASHBOARD_ROUTE,
    ADMIN_INQUIRES,
    ADMIN_HOME_PAGE_SETTINGS,
    ADMIN_CONTACT_INFO, ADMIN_SUBSCRIBERS, ADMIN_PRIVACY
} from "../../router/Admin/adminRoutes";
import {redirectToRouteByName} from "../../Services/GlobalHelpers";
import Loader from "../../SharedComponents/Loader.vue";
import HTTP from "../Axios/axiosCongif";

export default {
    name: "DashboardLayout",
    components: {Loader},
    setup() {
        const store = inject('store')
        const loaded = ref(false)
        const setLoaded = () => {
            loaded.value = true
        }

        const InquiryExists=computed(()=>store.getters.inquiryExist.value)
        const checkInquiryExists=()=>{
            HTTP.get('/state/inquiry')
            .then(({data})=>{
                if (data?.unreadInquiryExists){
                    store.actions.setInquiry(true)
                }
            })
        }
        checkInquiryExists()
        onBeforeMount(() => {
            if (!store.getters.admin?.value) {
                store.actions.setAdmin(null)
                redirectToRouteByName(ADMIN_LOGIN_ROUTE);
                return;
            }
            setLoaded()
        })
        return {
            loaded,
            ADMIN_CATEGORIES_ROUTE,
            ADMIN_PRODUCT_LIST,
            ADMIN_SETTING_ROUTE,
            ADMIN_SLIDER_EDIT,
            ADMIN_BANNERS_EDIT,
            ADMIN_DASHBOARD_ROUTE,
            ADMIN_INQUIRES,
            ADMIN_HOME_PAGE_SETTINGS,
            ADMIN_CONTACT_INFO,
            ADMIN_SUBSCRIBERS,
            ADMIN_PRIVACY,
            InquiryExists,

        }
    }
}
</script>

<style scoped>

@import url(//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css);
@import url(https://fonts.googleapis.com/css?family=Titillium+Web:300);

svg{
    width: 60px;
    display: block;
    height: 26px;
}
.active{
    background-color: #2d3748;
}
.inquiry_count{
    position: absolute;
    border-radius: 50%;
    background-color: #00b517;
    color: #050a1b;
    padding: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    left: 12px;
    top: 0;
}
.active span {
    font-weight: bold;
}
.fa-2x {
    font-size: 2em;
}

.fa {
    position: relative;
    display: table-cell;
    width: 60px;
    height: 36px;
    text-align: center;
    vertical-align: middle;
    font-size: 20px;
}


.main-menu:hover, nav.main-menu.expanded {
    width: 250px;
    overflow: visible;
}

.main-menu {
    background: #212121;
    border-right: 1px solid #e5e5e5;
    position: absolute;
    top: 0;
    bottom: 0;
    height: 100%;
    left: 0;
    width: 60px;
    overflow: hidden;
    -webkit-transition: width .05s linear;
    transition: width .05s linear;
    -webkit-transform: translateZ(0) scale(1, 1);
    z-index: 1000;
}

.main-menu > ul {
    margin: 7px 0;
}

.main-menu li {
    position: relative;
    display: block;
    width: 250px;
}

.main-menu li > a {
    position: relative;
    display: table;
    border-collapse: collapse;
    border-spacing: 0;
    color: #999;
    font-family: arial;
    font-size: 14px;
    text-decoration: none;
    -webkit-transform: translateZ(0) scale(1, 1);
    -webkit-transition: all .1s linear;
    transition: all .1s linear;

}

.main-menu .nav-icon {
    position: relative;
    display: table-cell;
    width: 60px;
    height: 36px;
    text-align: center;
    vertical-align: middle;
    font-size: 18px;
}

.main-menu .nav-text {
    position: relative;
    display: table-cell;
    vertical-align: middle;
    width: 190px;
    font-family: 'Titillium Web', sans-serif;
}

.main-menu > ul.logout {
    position: absolute;
    left: 0;
    bottom: 0;
}

.no-touch .scrollable.hover {
    overflow-y: hidden;
}

.no-touch .scrollable.hover:hover {
    overflow-y: auto;
    overflow: visible;
}

a:hover, a:focus {
    text-decoration: none;
}

nav {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
}

nav ul, nav li {
    outline: 0;
    margin: 0;
    padding: 0;
}

.main-menu li:hover > a, nav.main-menu li.active > a, .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus, .no-touch .dashboard-page nav.dashboard-menu ul li:hover a, .dashboard-page nav.dashboard-menu ul li.active a {
    color: #fff;
    background-color: #000000;
}

.area {
    float: left;
    background: #e2e2e2;
    width: 100%;
    height: 100%;
}

@font-face {
    font-family: 'Titillium Web';
    font-style: normal;
    font-weight: 300;
    src: local('Titillium WebLight'), local('TitilliumWeb-Light'), url(http://themes.googleusercontent.com/static/fonts/titilliumweb/v2/anMUvcNT0H1YN4FII8wpr24bNCNEoFTpS2BTjF6FB5E.woff) format('woff');
}
</style>
