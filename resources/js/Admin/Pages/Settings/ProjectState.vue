<template>
    <div class="w-100">
        <h4 class="text-center text-white"> Projects state </h4>
        <div class=" d-flex flex-wrap container p-2">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">Inquiries</div>
                <div class="card-body">
                    <div class="w-100 d-flex flex-column">
                        <span>
                            Count of inquiries
                        </span>
                        <div class="w-100 d-flex justify-content-between">
                            <span>All:</span>
                            <span>145</span>
                        </div>
                        <div class="w-100 d-flex justify-content-between">
                            <span>Unread:</span>
                            <span>146</span>
                        </div>
                    </div>
                    <router-link  :to="{name:ADMIN_INQUIRES}" class="card-link btn btn-primary">
                        View inquires
                    </router-link>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {ADMIN_INQUIRES} from "../../../router/Admin/adminRoutes";
import {useAdminStore} from "../../Store";
import {onMounted} from "vue";

export default {
    name: "ProjectState",
    components: {},

    setup(){
        const {actions}=useAdminStore()

        const setInquiryCount=(count)=>{
            actions.setInquiry(count)
        }

        onMounted(()=>setInquiryCount(16))

        return {
            ADMIN_INQUIRES
        }
    }
}
</script>

<style scoped>

</style>
