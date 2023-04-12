<template>
    <div class="container d-flex justify-content-center align-items-center flex-column gap-2">
        <form class="w-75" @submit.prevent="wrapWithinProcess(leaveComment)"
        >
            <div class="form-group">
                <label> Firstname surname </label>
                <input type="text" class="form-control"
                       placeholder="Product name"
                       v-model="comment.username"
                >
                <small class="w-100 text-center text-danger" v-if="errors.username">
                    {{ errors.username }}
                </small>
            </div>
            <div class="form-group">
                <label> Rating </label>
                <div class="d-flex align-items-center" style="padding-left: 5px">
                    <svg v-for="i in 5" fill="none" height="15" viewBox="0 0 16 15" width="16"
                         @click="comment.rating = i"
                         xmlns="http://www.w3.org/2000/svg">
                        <path :fill="i <= comment.rating ?'#FF9017':'#D5CDC5'" clip-rule="evenodd" d="M8 12.0553L12.944 15L11.632 9.45L16 5.71579L10.248 5.23421L8 0L5.752 5.23421L0 5.71579L4.368 9.45L3.056 15L8 12.0553Z"
                              fill-rule="evenodd"/>
                    </svg>
                </div>
                <small class="w-100 text-center text-danger" v-if="errors.rating">
                    {{ errors.rating }}
                </small>
            </div>
            <div class="form-group">
                <label >Comment</label>
                <textarea class="form-control"
                          rows="7" style="resize: none"
                          v-model="comment.comment"
                >
                        </textarea>
                <small class="w-100 text-center text-danger" v-if="errors.comment">
                    {{ errors.comment }}
                </small>
            </div>
            <div class="d-flex justify-content-center align-items-center mt-1 gap-1">
                <button class="btn btn-primary" type="submit">Save </button>
            </div>
        </form>
    </div>
</template>

<script>
import processWrappes from "../../../../Mixins/processWrappes";

export default {
    name: "LeaveComment",
    mixins:[processWrappes]
}
</script>
<script setup>
import {computed, reactive, watch} from "vue";
import {useRoute} from "vue-router";
const emit=defineEmits(['close'])
const errors = reactive({
    rating:'',
    username:'',
    comment:''
})

const comment = reactive({
    rating:0,
    username:'',
    comment:''
})
const  {params:{id}}=useRoute()
const productId=computed(()=>id)

watch(()=>comment.rating,()=>{
    if (errors.rating){
        errors.rating=''
    }
})
watch(()=>comment.comment,()=>{
    if (errors.comment){
        errors.comment=''
    }
})
watch(()=>comment.username,()=>{
    if (errors.username){
        errors.username=''
    }
})

const leaveComment = ()=>{
   axios.post(`/comment/${productId.value}`,{...comment})
    .then(({data})=>{
        emit('close',data.comment)
    })
    .catch(e=>{
        if (e?.response?.status === 422){
            const errorsMsgs =e.response.data.errors;
            for (const key in errorsMsgs) {
                errors[key]=errorsMsgs[key][0]
            }
        }
    })
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Anuphan:wght@200&display=swap');
*{
    font-family: Anuphan,serif;
    font-size: 16px;
    font-weight: 600;
}
label{
    font-weight: 700;
}
small{
    font-size: 15px;
    font-weight: 800;
}
</style>
