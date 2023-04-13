<template>
    <header class="section-header">
        <div class="container">
            <nav class="navbar navbar-main navbar-expand pl-0">
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

            <section class="header-main ">
                <div class="row row-sm">
                    <div class="col-6 col-sm col-md col-lg  flex-grow-0">
                        <a href="http://bootstrap-ecommerce.com" class="brand-wrap">
                            <img class="logo" src="images/logo.svg?v=2.0">
                        </a> <!-- brand-wrap.// -->
                    </div>
                    <div class="col-6 col-sm col-md col-lg flex-md-grow-0">
<!-- category-wrap.// -->
                    </div> <!-- col.// -->
                    <div class="col-lg-6 col-xl col-md-5 col-sm-12 flex-grow-1">
                        <form @submit.prevent="search.defaultSearch(searchVal)"
                              class="search-header" id="product_search_form"
                        >
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search"
                                       v-model="searchVal"
                                >
                            </div>
                        </form> <!-- search-wrap .end// -->
                    </div> <!-- col.// -->
                    <div class="col col-lg col-md flex-grow-0">
                        <button class="btn btn-block btn-primary"
                                form="product_search_form"
                                type="submit">
                            Search
                        </button>
                    </div>
                </div> <!-- row.// -->
            </section> <!-- header-main .// -->
        </div> <!-- container.// -->
    </header>
</template>

<script>
export default {
    name: "HeaderComponent"
}
</script>
<script setup>
import {inject, onMounted, ref, watch} from "vue";
import {USER_HOME_PAGE} from "../../../router/Customer/customerRoutes";
import {PRODUCT_LIST_PAGE} from "../../../router/Customer/customerRoutes";
import {Dropdown} from "bootstrap"
import {useRoute} from "vue-router";

    const categories=ref([])
    const searchVal=ref('')
    const search=inject('searchHelper');

    const route=useRoute()
    const emit=defineEmits(['loaded'])

    watch(()=>route.path,(val)=>{
        const dropdownEl = document.querySelector('.dropdown-menu.show')
        if (dropdownEl) {
            const bsDropdown = new Dropdown(dropdownEl)
            bsDropdown.hide()
        }
    })


    const getCategories=()=>{
        axios.get('/category/presentable')
        .then(({data})=>{
            categories.value=data.categories
        }).catch(e=>console.log(e))
        .finally(()=>emit('loaded'))
    }

    onMounted(getCategories)
</script>

<style scoped>
.header_link{
    white-space: nowrap;
}
header{
    background: #12225B;
    box-shadow: 0px 0px 3px;
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
.dropdown-item:hover{
    color: #050a1b;
}
.search-header{
    border: none;
}
</style>
