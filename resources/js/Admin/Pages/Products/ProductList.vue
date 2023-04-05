<template>
    <div class="container-fluid">

        <!-- start page title -->
        <div class=" d-flex w-100 justify-content-between align-items-center">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <ol class="breadcrumb d-flex gap-2">
                       <li class="text-white fs-4 font-italic">Home</li>
                       <li class="text-white fs-4 font-italic">\</li>
                       <li class="text-white fs-4 font-italic">
                           <a @click.prevent="dropToInitial" style="text-decoration: underline">
                               Products
                           </a>
                       </li>
                    </ol>
                </div>
            </div>

            <router-link :to="{name:ADMIN_PRODUCT_ADD}" aria-expanded="false" aria-haspopup="true"
                    class="btn btn-primary">
                <i class="mdi mdi-settings mr-2"></i> Add Product
            </router-link>

        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div id="datatable_length" class="dataTables_length"><label>Show <select
                                            v-model="searchCount"
                                            aria-controls="datatable" class="custom-select custom-select-sm form-control form-control-sm"
                                            name="datatable_length">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> entries</label></div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <form action="" @submit.prevent="executeSearch">
                                            <div id="datatable_filter" class="dataTables_filter"><label>Search:
                                                <input aria-controls="datatable" class="form-control form-control-sm" placeholder=""
                                                       v-model="searchText"
                                                       type="search"></label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="datatable"
                                               aria-describedby="datatable_info"
                                               class="table table-striped table-centered dt-responsive nowrap table-vertical dataTable no-footer dtr-inline"
                                               role="grid" style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                                            <thead>
                                            <tr role="row">
                                                <th aria-controls="datatable" aria-label="Image: activate to sort column descending" aria-sort="ascending"
                                                    class="sorting_asc" colspan="1" rowspan="1" style="width: 73px;"
                                                    tabindex="0">Image
                                                </th>
                                                <th aria-controls="datatable" aria-label="Product Name: activate to sort column ascending" class="sorting" colspan="1"
                                                    rowspan="1" style="width: 356px;"
                                                    tabindex="0">Name Description
                                                </th>
                                                <th aria-controls="datatable" aria-label="Added Date: activate to sort column ascending" class="sorting" colspan="1"
                                                    rowspan="1" style="width: 120px;"
                                                    tabindex="0">Title
                                                </th>
                                                <th aria-controls="datatable" aria-label="Amount: activate to sort column ascending" class="sorting" colspan="1"
                                                    rowspan="1" style="width: 87px;"
                                                    tabindex="0">Category
                                                </th>
                                                <th aria-controls="datatable" aria-label="No. of Units: activate to sort column ascending" class="sorting" colspan="1"
                                                    rowspan="1" style="width: 122px;"
                                                    tabindex="0">Price
                                                </th>
                                                <th aria-controls="datatable" aria-label="Stock: activate to sort column ascending" class="sorting" colspan="1"
                                                    rowspan="1" style="width: 68px;"
                                                    tabindex="0">Created at
                                                </th>
                                                <th aria-controls="datatable" aria-label="Action: activate to sort column ascending" class="sorting" colspan="1"
                                                    rowspan="1" style="width: 75px;"
                                                    tabindex="0">Action
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                               <tr class="odd" role="row" v-for="product in products" :key="product.id">
                                                    <td class="product-list-img sorting_1" tabindex="0">
                                                       <template v-if="product.general_file">
                                                            <template v-if="product.general_file.type === 'image'">
                                                                <img alt="tbl"
                                                                     class="img-fluid avatar-sm rounded" :src="'/'+product.general_file.path">
                                                            </template>

                                                            <template v-if="product.general_file.type === 'video'">
                                                                <video controls autoplay muted
                                                                       class="img-fluid avatar-sm rounded" :src="'/'+product.general_file.path"></video>
                                                            </template>
                                                       </template>
                                                    </td>
                                                    <td>
                                                        <h6 class="mt-0 mb-1">{{  product.name }}</h6>
                                                        <p class="m-0 font-size-14">
                                                            {{ product.description }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        {{ product.title }}
                                                    </td>
                                                    <td>
                                                        {{ product.category.name }}
                                                    </td>
                                                    <td>
                                                        {{ product?.price_for_one?.price ?? '' }} USD
                                                    </td>
                                                    <td>
                                                        {{ new Date(product.created_at).toLocaleDateString()}}
                                                    </td>
                                                    <td>
                                                        <ul class="list-inline m-0">
                                                            <li class="list-inline-item">
                                                                <router-link :to="{
                                                                    name:ADMIN_PRODUCT_EDIT,
                                                                    params:{id:product.id}
                                                                    }"
                                                                             class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </router-link>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <button
                                                                     @click="setProductUnderRemoval(product)"
                                                                    class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                                    </svg>
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div id="datatable_info" aria-live="polite" class="dataTables_info"
                                             role="status">Showing from {{ from }} to  {{ to }}  of {{ total }} entries
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div id="datatable_paginate" class="dataTables_paginate paging_simple_numbers">
                                            <ul class="pagination">
                                                <li id="datatable_previous"
                                                    class="paginate_button page-item previous " :class="{'disabled':!prev_page_url}">
                                                    <a aria-controls="datatable" class="page-link"
                                                        v-bind="{'disabled':!prev_page_url}"
                                                       @click="getPagesData(prev_page_url)"
                                                    >
                                                        Previous
                                                    </a>
                                                </li>

                                                <li class="paginate_button page-item "
                                                    v-for="page in last_page" :class="{'active':page === current_page}"
                                                    :key="page"
                                                >
                                                    <a class="page-link"
                                                        @click="getPagesData(generateUrlFromPage(page))"
                                                    >
                                                        {{ page }}
                                                    </a>
                                                </li>
                                                <li id="datatable_next" class="paginate_button page-item next"
                                                    :class="{'disabled':!next_page_url}"

                                                >
                                                    <a  class="page-link"
                                                        @click="getPagesData(next_page_url)"
                                                        v-bind="{'disabled':!next_page_url}"
                                                    >
                                                        Next
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <teleport to="#app">
        <Modal v-if="productUnderRemoval" @close="setProductUnderRemoval(null)">
            <div class="container">
                <h1>Delete Product</h1>
                <p>Are you sure you want to delete your account?</p>

                <div class="clearfix w-50">
                    <button type="button" class="cancelbtn w-50" @click="setProductUnderRemoval(null)">Cancel</button>
                    <button type="button" class="deletebtn w-50" @click="removeProduct(productUnderRemoval)">
                        Delete
                    </button>
                </div>
            </div>
        </Modal>
    </teleport>
</template>

<script>
import {ADMIN_PRODUCT_ADD, ADMIN_PRODUCT_EDIT} from "../../../router/Admin/adminRoutes";
import {onMounted, reactive, ref, toRefs} from "vue";
import HTTP from "../../Axios/axiosCongif";
import Modal from "../../../SharedComponents/ReusableComponents/Modal.vue";
import {errorNotification, infoNotification, successNotification} from "../../../Services/NotificationService";
import {extractValidationErrors} from "../../../Services/GlobalHelpers";
export default {
    name: "ProductList",
    components: {Modal},

    setup(){
            const searchCount=ref(0)
            const searchText = ref('')
            const products = ref([]);
            const productUnderRemoval = ref(null)
            const paginator=reactive({
                prev_page_url:'',
                next_page_url:'',
                current_page:'',
                last_page:0,
                to:0,
                from:0,
                total:0
            })
            const setProductUnderRemoval = (product)=>{
                productUnderRemoval.value = product
            }

            const removeProduct = (product )=>{
                infoNotification('Deleting product ...','Please wait')
                HTTP.delete(`/product/${product.id}`)
                .then((response)=>{
                    if (response.status === 204){
                        let index = products.value.findIndex((pr)=>pr.id === product.id)
                        if (index !== -1){
                            products.value.splice(index,1)
                            paginator.total -=1;
                            paginator.to -=1;
                        }
                        successNotification('Product removed successfully')
                        setProductUnderRemoval(null)
                    }
                }).catch((e)=>errorNotification(extractValidationErrors(e)))
            }
            const setPagesData = (response)=>{
                paginator.current_page = response.current_page
                paginator.last_page = response.last_page
                paginator.next_page_url = response.next_page_url
                paginator.prev_page_url = response.prev_page_url
                paginator.to = response.to
                paginator.total = response.total
                paginator.from = response.from
                products.value = response.data
            }
            const executeSearch = ()=>{
                HTTP.get('/product/all?search='+searchText.value)
                    .then(({data:{response}})=>{
                            setPagesData(response)
                        })
            }
            const dropToInitial = ()=>{
                searchCount.value = 0;
                searchText.value = '';
                getPagesData(generateUrlFromPage(1))
            }




            const getPagesData = (page)=>{
                if (!page){
                    return;
                }
                let neededPage = page;
                if (searchText.value){
                    neededPage+=`&&search=${searchText.value}`
                }
                if (searchCount.value){
                    neededPage+=`&&count=${searchCount.value}`
                }
                HTTP.get( neededPage )
                    .then(({data:{response}})=>setPagesData(response))
            }

            const generateUrlFromPage = (page)=>{
                if (!page){
                    return '/product/all';
                }
                return `/product/all/?page=${page}`
            }


            const getProducts = ()=>{
                HTTP.get('/product/all')
                .then(({data:{response}})=>setPagesData(response))
            }

            onMounted(()=>{
                getProducts()
            })


            return{
                ADMIN_PRODUCT_ADD,
                searchCount,
                searchText,
                products,
                ...toRefs(paginator),
                getProducts,
                getPagesData,
                executeSearch,
                generateUrlFromPage,
                dropToInitial,
                ADMIN_PRODUCT_EDIT,
                productUnderRemoval,
                setProductUnderRemoval,
                removeProduct
            }
    }
}
</script>

<style scoped>
.cancelbtn {
    background-color: #ccc;
    color: black;
}

/* Add a color to the delete button */
.deletebtn {
    background-color: #f44336;
}

.container {
    padding: 16px;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
</style>
