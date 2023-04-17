import {computed, reactive, readonly, ref} from "vue";

const state=reactive({
    admin:null,
    inquiryExists:false
})
const getters={
    admin:computed(()=>state.admin),
    inquiryExist:computed(()=>state.inquiryExists),
}
const actions={
    setAdmin:(admin)=>state.admin=admin,
    setInquiry:(exists)=>state.inquiryExists=exists
}

export const useAdminStore=()=>{
    return {
        state:readonly(state),
        getters,
        actions
    }
}
