<template>
    <div class="w-100 container">
        <h4 class="text-center text-white"> Projects state </h4>
        <div class=" d-flex flex-wrap container p-2 justify-content-between">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">Inquiries</div>
                <div class="card-body">
                    <div class="w-100 d-flex flex-column gap-1">
                        <span>
                            Count of inquiries
                        </span>
                        <div class="w-100 d-flex justify-content-between">
                            <span>All:</span>
                            <span>{{ inquiry?.total ?? 0 }}</span>
                        </div>
                        <div class="w-100 d-flex justify-content-between">
                            <span>Unread:</span>
                            <span>{{ inquiry?.unread_count ?? 0 }}</span>
                        </div>
                    </div>
                    <router-link  :to="{name:ADMIN_INQUIRES}" class="card-link btn btn-primary">
                        View inquires
                    </router-link>
                </div>
            </div>
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">Products</div>
                <div class="card-body">
                    <div class="w-100 d-flex flex-column gap-1">
                        <span>
                            Count of products
                        </span>
                        <div class="w-100 d-flex justify-content-between">
                            <span>All:</span>
                            <span>{{ products?.total }}</span>
                        </div>
                        <div class="w-100 d-flex justify-content-between">
                            <span>In stock:</span>
                            <span>{{ products?.in_stock }}</span>
                        </div>
                    </div>
                    <router-link  :to="{name:ADMIN_PRODUCT_LIST}" class="card-link btn btn-primary">
                        View Products
                    </router-link>
                </div>
            </div>
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">Subscribers</div>
                <div class="card-body">
                    <div class="w-100 d-flex flex-column gap-1">
                        <span>
                            Count of Subscribers
                        </span>
                        <div class="w-100 d-flex justify-content-between">
                            <span>All:</span>
                            <span>{{ subscribers }}</span>
                        </div>
                    </div>
                    <router-link  :to="{name:ADMIN_SUBSCRIBERS}" class="card-link btn btn-primary">
                        View subscribers
                    </router-link>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {ADMIN_INQUIRES,ADMIN_PRODUCT_LIST,ADMIN_SUBSCRIBERS} from "../../../router/Admin/adminRoutes";
import { reactive, toRefs} from "vue";
import HTTP from "../../Axios/axiosCongif";

export default {
    name: "ProjectState",
    components: {},
    setup(){

        const state=reactive({
            inquiry:{},
            products:{},
            subscribers:0,
        })
        const getState=()=>{
            HTTP.get('/state/all')
            .then(({data})=>{
                state.inquiry=data.inquiry;
                state.products=data.product;
                state.subscribers=data.subscriber;
            })
        }

        getState()
        return {
            ADMIN_INQUIRES,
            ADMIN_PRODUCT_LIST,
            ADMIN_SUBSCRIBERS,
            ...toRefs(state)
        }
    }
}
</script>

<style scoped>

</style>
