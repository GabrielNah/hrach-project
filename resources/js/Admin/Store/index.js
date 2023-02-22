import {computed, reactive, readonly, ref} from "vue";

const state=reactive({
    admin:null
})
const getters={
    admin:computed(()=>state.admin)
}
const actions={
    setAdmin:(admin)=>state.admin=admin
}

export const useAdminStore=()=>{
    return {
        state:readonly(state),
        getters,
        actions
    }
}
