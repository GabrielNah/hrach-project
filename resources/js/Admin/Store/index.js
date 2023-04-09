import {computed, reactive, readonly, ref} from "vue";

const state=reactive({
    admin:null,
    inquiries:0
})
const getters={
    admin:computed(()=>state.admin),
    inquiries:computed(()=>state.inquiries),
}
const actions={
    setAdmin:(admin)=>state.admin=admin,
    setInquiry:(inquiryCount)=>state.inquiries=inquiryCount
}

export const useAdminStore=()=>{
    return {
        state:readonly(state),
        getters,
        actions
    }
}
