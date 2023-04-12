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
                    <video class="w-100 " :src="'/'+product.general_file.path" autoplay muted loop>
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
            <textarea class="form-control bordered_bottom" placeholder="Write your message here"
                style="resize: none" v-model="inquiry.inquiry"
            ></textarea>
            <p v-if="errors.inquiry" class="text-danger m-0">
                {{ errors.inquiry }}
            </p>
        </div>
        <div class="hot_keys p-2 position-relative" :style="hotKeysIsShown ? {}: {'height':'65px'}">
            <div class="d-flex align-items-center">
                <svg width="15" height="15" xmlns="http://www.w3.org/2000/svg" data-spm-anchor-id="a2700.7803241.0.i6.1f383e5fxLYmeD"><defs><filter id="a"><feColorMatrix in="SourceGraphic" values="0 0 0 0 1.000000 0 0 0 0 0.415686 0 0 0 0 0.000000 0 0 0 1.000000 0"></feColorMatrix></filter></defs><g filter="url(#a)" fill="none" fill-rule="evenodd"><g fill="#000" fill-rule="nonzero"><path d="M4.941 14.167H9.06V15H4.94v-.833Zm6.88-12.55.581.588-1.164 1.18-.582-.59 1.164-1.178Zm-9.641 0 1.164 1.176-.583.59-1.165-1.179.584-.587Zm10.173 5.05H14V7.5h-1.647v-.833ZM0 6.667h1.647V7.5H0v-.833ZM6.588 0h.824v1.667h-.824V0ZM7 2.5c-2.47 0-4.53 2.083-4.53 4.583 0 1.75.824 3.334 2.471 4.084v2.166H9.06v-2.166c1.647-.75 2.47-2.334 2.47-4.084C11.53 4.583 9.471 2.5 7 2.5Zm1.647 7.917-.412.25V12.5h-2.47v-1.833l-.412-.25C4.035 9.75 3.294 8.5 3.294 7.083 3.294 5 4.941 3.333 7 3.333S10.706 5 10.706 7.083c0 1.417-.741 2.667-2.059 3.334Z"></path><path d="M5 7.833h1.6V12h.8V7.833H9V7H5z"></path></g></g></svg>
                <small class="shortcut_info d-flex align-items-center" >
                    Click to insert the questions in the box above.
                </small>
            </div>
            <span class=" shortcut-arrow " @click="toggleHotKeys"
                :style="hotKeysIsShown ?  {'transform':'rotate(180deg)'} : {}   "
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                </svg>
            </span>
            <div class="d-flex w-100 flex-wrap" >

                <span v-for="key in hotKeys" class="shortcut_text"
                    @click="addHotKeyToInquiry(key)"
                >
                    {{ key }}
                </span>
            </div>

        </div>
        <div class="form-group w-100 d-flex justify-content-center mt-2">
            <button type="submit" class="btn btn-success w-75">
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
import {onMounted, reactive, ref, watch} from "vue";
import {successNotification} from "../../../../Services/NotificationService";

 const props=defineProps({
     product:{
         type:Object,
         required:true
     }
 })
const hotKeys=ref([])

const hotKeysIsShown=ref(false)
const toggleHotKeys=()=>hotKeysIsShown.value=!hotKeysIsShown.value

const emit=defineEmits(['close']);

 const inquiry = reactive({
     product_id:props.product.id,
     count:1,
     username:'',
     inquiry:'',
     email:''
 })

const addHotKeyToInquiry=(key)=>inquiry.inquiry+=key
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

onMounted(()=>{
    window.axios.get('/inquiry/hot_keys')
    .then(({data})=>{
        hotKeys.value=data.hot_keys
    })
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
.bordered_bottom{
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}
.hot_keys{
    position: relative;
    background-color: #bbc0c8;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    overflow: hidden;
}
.shortcut_info{
    padding-left: 8px;
    font-family: SFProText-Regular;
    font-size: 12px;
    color: #333;
    line-height: 12px;
}
.shortcut_text{
    height: 28px;
    border-radius: 14px;
    background-color: #FFF;
    font-family: SFProText-Regular;
    font-size: 12px;
    color: #333;
    letter-spacing: 0;
    text-align: center;
    line-height: 12px;
    margin-right: 8px;
    margin-top: 6px;
    margin-bottom: 6px;
    display: flex;
    justify-content: center;
    border: 1px solid white;
    align-items: center;
    padding: 0 13px;
    transition: .3s;
}
.shortcut_text:hover{
    border: 1px solid royalblue;
    color: royalblue;
}
.shortcut-arrow {
    cursor: pointer;
    position: absolute;
    right: 11px;
    top: 30px;
    z-index: 1;
}
</style>
