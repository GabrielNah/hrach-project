<template>
    <header class="section-header"
        :style="properAppearance(appearance)"
    >
        <div class="container">
            <section class="header-main w-100">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <div class="list-trigger justify-content-center align-items-center">
                        <svg @click="sideBareOpened=true"
                             xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </div>
                    <div class="flex-grow-0 d-flex align-items-center justify-content-center " style="width: 15%">
                        <a href="http://bootstrap-ecommerce.com" class="brand-wrap">
                            <img class="logo" src="images/logo.svg?v=2.0">
                        </a> <!-- brand-wrap.// -->
                    </div>
                    <div class=" flex-grow-1 d-flex align-items-center justify-content-between position-relative">
                        <form @submit.prevent="search.defaultSearch(searchVal)"
                              class="search-header flex-grow-1 " id="product_search_form"
                        >
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search"
                                       v-model="searchVal"
                                >
                            </div>
                        </form>
                        <button class="btn btn-block btn-primary button-34"
                                form="product_search_form"
                                type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                        </button>
                    </div>
                </div> <!-- row.// -->
            </section>
            <nav class="navbar navbar-main navbar-expand pl-0 w-100 routes"
            :style="properAppearance(appearance)"
                 :class="sideBareOpened?'routes_shown':''"
            >
                <div class="close_sidebar">
                    <svg @click="sideBareOpened=false"
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                </div>
                <ul class="navbar-nav flex-wrap">
                    <li class="nav-item">
                        <router-link class="nav-link header-link" :to="{name:USER_HOME_PAGE}">
                            Home
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <hr>
                    </li>
                    <li class="nav-item" v-if="$route.name!==PRODUCT_LIST_PAGE">
                        <router-link class="nav-link header-link" :to="{name:PRODUCT_LIST_PAGE,params:{category:'all'}}">
                            View all categories
                        </router-link>
                    </li>

                    <template v-for="category in categories" :key="category.id">
                        <li class="nav-item"
                            :class="{'dropdown':category?.sub_categories?.length}"
                        >
                            <router-link class="nav-link  header-link"
                                         :class="{'dropdown-toggle':category?.sub_categories?.length}"
                                         :data-bs-toggle="category?.sub_categories?.length ? 'dropdown' : ''"
                                         :to="{name: PRODUCT_LIST_PAGE, params: {category: category.name}}"
                            >
                                {{ category.name }}
                            </router-link>
                            <ul class="dropdown-menu "
                                 v-if="category.sub_categories?.length">
                                <li>
                                    <router-link
                                        class=" dropdown-item"
                                        :to="{name:PRODUCT_LIST_PAGE,params:{category:category.name}}">
                                        {{ category.name }}
                                    </router-link>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <template v-for="subCategory in category.sub_categories"
                                          :key="subCategory.id"
                                >
                                    <li>
                                        <router-link
                                            class=" dropdown-item"
                                            :to="{name:PRODUCT_LIST_PAGE,params:{category:subCategory.name}}">
                                            {{ subCategory.name }}
                                        </router-link>
                                    </li>
                                </template>
                            </ul>
                        </li>
                    </template>

                </ul>
            </nav>


        </div> <!-- container.// -->
    </header>
</template>

<script>
import HandleAppearance from "../../../Mixins/handleAppearance";

export default {
    name: "HeaderComponent",
    props:{
        appearance:{
            type:Object,
            required:false,
            default:()=>null
        }
    },mixins:[HandleAppearance],
}
</script>
<script setup>
import {inject, ref, watch} from "vue";
import {USER_HOME_PAGE} from "../../../router/Customer/customerRoutes";
import {PRODUCT_LIST_PAGE} from "../../../router/Customer/customerRoutes";
import {Dropdown} from "bootstrap"
import {useRoute} from "vue-router";

    const categories=ref([])
    const searchVal=ref('')
    const search=inject('searchHelper');
    const sideBareOpened=ref(false)


    const route=useRoute()
    const emit=defineEmits(['loaded'])

    watch(()=>route.path,(val)=>{
        const dropdownEl = document.querySelector('.dropdown-menu.show')
        if (dropdownEl) {
            const bsDropdown = new Dropdown(dropdownEl)
            bsDropdown.hide()
        }
        if (sideBareOpened.value){
            sideBareOpened.value=false
        }
    },{deep:true})


    const getCategories=()=>{
        axios.get('/category/presentable')
        .then(({data})=>{
            categories.value=data.categories
        }).catch(e=>console.log(e))
        .finally(()=>emit('loaded'))
    }

    getCategories()
</script>

<style scoped>
.header_link{
    white-space: nowrap;
}
header{
    background: #12225B;
    box-shadow: 0px 0px 3px;
}
.list-trigger{
    display: none;
}
.nav-item a,.dropdown-item a{
    font-family: 'Inter';
    font-style: normal;
    font-weight: 400;
    font-size: 15px;
    line-height: 22px;

    color: #FFFFFF;
}
.dropdown-menu{
    background: #12225B;
    box-shadow: 0px 0px 3px;
}
.close_sidebar{
    display: none;
}
.dropdown-item:hover{
    color: #050a1b;
}
.search-header{
    border: none;
}
.button-34 {
    background: #5E5DF0;
    box-shadow: #5E5DF0 0 10px 20px -10px;
    box-sizing: border-box;
    color: #FFFFFF;
    cursor: pointer;
    font-family: Inter,Helvetica,"Apple Color Emoji","Segoe UI Emoji",NotoColorEmoji,"Noto Color Emoji","Segoe UI Symbol","Android Emoji",EmojiSymbols,-apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue","Noto Sans",sans-serif;
    font-size: 16px;
    font-weight: 700;
    line-height: 24px;
    opacity: 1;
    outline: 0 solid transparent;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    width: fit-content;
    word-break: break-word;
    border: 0;
}
@media (max-width:770px ) {
    .list-trigger{
        display: flex;
    }

   .button-34{
       position: absolute;
       right: 0;
   }

    .routes{
        position: fixed;
        top: 0;
        left: -100%;
        width: 100vw;
        height: 100vh;
        background-color: #fff;
        transition: transform 0.3s ease-out;
        z-index: 100;
    }
    .routes ul{
        flex-direction: column;
        margin-left: 10px;
    }

    .routes_shown{
        transform: translateX(100%);
        z-index: 100;
    }
    .routes_shown ul {
        flex-direction: column;
        margin-left: 10px;
    }
    .routes_shown .close_sidebar{
        display: block;
        position: absolute;
        top: 0;
    }
    .close_sidebar svg{
        width: 25px;
        height: 25px;
        position: absolute;
        top: 10px;
        left: 10px;
    }
    .header-main{
        padding: 5px 0;
    }
}
</style>
