<template>
    <form class="form-horizontal col-sm-12 p-2"
        @submit.prevent="wrapWithinProcess(sendInquiry)"
    >
        <div class="w-100 d-flex gap-2">
            <div class="product_image" style="width: 150px;">
                <template v-if="product.general_file.type === 'image'">
                    <img class="w-100 " :src="'/'+product.general_file.path" alt="">
                </template>
                <template v-if="product.general_file.type === 'video'">
                    <video class="w-100 " :src="'/'+product.general_file.path" autoplay controls>
                    </video>
                </template>
            </div>
            <div class="d-flex flex-column justify-content-evenly flex-grow-1">
                <div class="d-flex align-items-center" style="padding-left: 5px">
                    <svg v-for="i in 5" fill="none" height="15" viewBox="0 0 16 15" width="16"
                         xmlns="http://www.w3.org/2000/svg">
                        <path :fill="i <= product.rating ?'#FF9017':'#D5CDC5'" clip-rule="evenodd" d="M8 12.0553L12.944 15L11.632 9.45L16 5.71579L10.248 5.23421L8 0L5.752 5.23421L0 5.71579L4.368 9.45L3.056 15L8 12.0553Z"
                              fill-rule="evenodd"/>
                    </svg>
                </div>
                <span>
                    {{ product.name }}
                </span>
                <span>
                    {{ product.title }}
                </span>
            </div>
            <div class="d-flex flex-column h-100 w-25 align-items-center justify-content-center align-self-center"
            >
                <label>Count</label>
                <div class="d-flex" style="height: 25px">
                    <div class="count_handler" @click="decrCount"
                    >-
                    </div>
                    <input type="text"
                           v-model="inquiry.count"
                           class="count_input" >
                    <div  class="count_handler" @click="addCount"
                    >
                        +
                    </div>
                </div>
                <p v-if="errors.count" class="text-danger m-0">
                    {{ errors.count }}
                </p>
            </div>
        </div>
        <div class="form-group ">
            <label>Name</label>
            <input class="form-control required"
                   v-model="inquiry.username" placeholder="Firstname Surname">
            <p v-if="errors.username" class="text-danger m-0">
                {{ errors.username }}
            </p>
        </div>
        <div class="form-group">
            <label>E-Mail</label>
            <input class="form-control email" placeholder="Write you email here, so we can contact you"
                v-model="inquiry.email"
            >
            <p v-if="errors.email" class="text-danger m-0">
                {{ errors.email }}
            </p>
        </div>

        <div class="form-group">
            <label>Message</label>
            <textarea class="form-control" placeholder="Write your message here"
                style="resize: none" v-model="inquiry.inquiry"
            ></textarea>
            <p v-if="errors.inquiry" class="text-danger m-0">
                {{ errors.inquiry }}
            </p>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success pull-right">
                Send It!
            </button>
        </div>
    </form>
</template>

<script>
import processWrappes from "../../../../Mixins/processWrappes";

export default {
    name: "SendInquiry",
    mixins:[processWrappes]
}
</script>
<script setup>
import {reactive, watch} from "vue";
import {successNotification} from "../../../../Services/NotificationService";

 const props=defineProps({
     product:{
         type:Object,
         required:true
     }
 })
const emit=defineEmits(['close']);

 const inquiry = reactive({
     product_id:props.product.id,
     count:1,
     username:'',
     inquiry:'',
     email:''
 })
const errors=reactive({
    count:'',
    username:'',
    inquiry:'',
    email:''
})

 const addCount=()=>{
     inquiry.count++
 }
 const decrCount=()=>{
     if (inquiry.count <=1)return;
     inquiry.count--
 }
const sendInquiry=()=>{
     axios.post(`/inquiry/${props.product.id}`,{...inquiry})
    .then(({data})=>{
        if (data.success){
            successNotification('Inquiry sent, we will contact you ASAP');
            emit('close');
        }
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
watch(()=>inquiry.inquiry,()=>{
    if (errors.inquiry){
        errors.inquiry=''
    }
})
watch(()=>inquiry.username,()=>{
    if (errors.username){
        errors.username=''
    }
})
watch(()=>inquiry.email,()=>{
    if (errors.email){
        errors.email=''
    }
})
 watch(()=>inquiry.count,(val)=>{
     if (!/^\d+$/.test(val)){
         inquiry.count=1;
     }
     if (val <=1){
         inquiry.count=1;
     }
     if (errors.count){
         errors.count=''
     }
 })
</script>

<style scoped>
.count_handler{
    border-radius: 5px;
    outline: none;
    background-color: #adb5bd;
    padding: 5px 6px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}
.count_input{
    width: 50px;
    border: none;
    outline: none;
    border-radius: 3px;
}
.product_image{
    border-radius: 5px;
    overflow: hidden;
}
</style>
