<template>
    <div class="w-100 container pt-3">
        <div class="w-100 d-flex justify-content-between">
            <h4 class="text-white text-center flex-grow-1">Inquiries</h4>
            <button class="text-white p-2 btn btn-dark"
                @click="toggleEditHotKeysModal(true)"
            >
                Edit Hot Keys
            </button>
        </div>
        <div class="container mt-3 pb-3">
            <div class="row">
                <section class="discussions pt-2 overflow-auto gap-1  position-relative"
                    @scroll="handleScroll"
                >
                    <template v-if="inquiries.length">
                        <div class="discussion position-relative" v-for="inquiry in inquiries"
                             :key="inquiry.id"
                             :style="{backgroundColor:selectedInquiry?.id === inquiry.id ? '#87a3ec':'#FAFAFA'}"
                             @click="selectInquiry(inquiry)"
                        >
                            <div class="photo"
                                 :style="{backgroundImage: 'url(/'+inquiry?.product?.general_file?.path+')'}">
                            </div>
                            <div class="desc-contact">
                                <p class="name">{{ inquiry.username }}</p>
                                <p class="message">{{ inquiry.inquiry }}</p>
                            </div>
                            <div class="timer">
                                {{ new Date(inquiry.created_at).toLocaleString() }}
                            </div>
                            <div class="read_state" v-if="!inquiry.read"></div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center flex-grow-1 w-100"
                             v-if="ongoingLoad"
                        >
                            <mini-loader/>
                        </div>
                    </template>
                    <template v-else>
                        <span class="w-100 text-center text-white">You have no inquiry</span>
                    </template>


                </section>
                <section class="chat d-flex flex-column bg-gray" style="height: 700px">
                    <template v-if="!selectedInquiry">
                        <div class="w-100 flex-grow-1 d-flex justify-content-center align-items-center">
                            <span class="border-4 text-info p-3  "
                                  style="border-radius: 5px;background: gray">
                                Select Inquiry to view details
                            </span>
                        </div>
                    </template>
                    <template v-else>
                        <div class="header-chat w-100 d-flex flex-column align-items-start justify-content-center">
                            <p class="name text-dark">Username: {{ selectedInquiry.username }}</p>
                        </div>
                        <div class="messages-chat" style="flex: 1;overflow: auto">
                            <div class="d-flex flex-column">
                                <h6>Product:</h6>
                                <product-cart
                                    :horizontal="true"
                                    :product="inquiryDetails.product"
                                />
                            </div>
                            <div class="d-flex flex-column mt-2">
                                <h6>Inquiry details:</h6>
                                <div class="card" >
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            email:  &nbsp;{{ inquiryDetails.email }}
                                        </li>
                                        <li class="list-group-item">
                                            count:  &nbsp;{{ inquiryDetails.count}}
                                        </li>
<!--                                        <li class="list-group-item">Vestibulum at eros</li>-->
                                    </ul>
                                </div>
                            </div>
                            <div class="message mt-2 d-flex flex-column m-0 align-items-start">
                                <h6>Inquiry:</h6>
                                <p class="text m-0" style="margin: 0">
                                    {{ inquiryDetails.inquiry }}
                                </p>
                            </div>
                            <p class="time"> 15h09</p>
                        </div>
                    </template>
                </section>
            </div>
        </div>
    </div>

    <teleport to="#app">
        <Modal v-if="EditHotKeysOpened"
            @close="toggleEditHotKeysModal(false)"
        >
            <edit-hot-keys/>

        </Modal>
    </teleport>
</template>
<script setup>
import EditHotKeys from "./EditHotKeys.vue";
import Modal from "../../../SharedComponents/ReusableComponents/Modal.vue";
import {computed, ref, watch} from "vue";
import HTTP from "../../Axios/axiosCongif";
import MiniLoader from "../../../SharedComponents/MiniLoader.vue";
import ProductCart from "../../../Customer/Pages/Components/Product-cart.vue";
const EditHotKeysOpened=ref(false)
const toggleEditHotKeysModal=(state)=>EditHotKeysOpened.value=state


const sortedInquiries=ref([])
const nextPageUrl=ref('');
const inquiries=computed({
    get:()=>sortedInquiries.value,
    set(value){

        value.sort((a, b) => {
            if (a.read === b.read) {
                return a.id - b.id;
            } else if (a.read) {
                return 1;
            } else {
                return -1;
            }
        });

        sortedInquiries.value=value
    }
})
const ongoingLoad=ref(false)
const handleScroll=async (event) => {
    if (!nextPageUrl.value)return;
    if (event.target.scrollTop + event.target.clientHeight >= event.target.scrollHeight) {
        ongoingLoad.value=true
        await getInquiries(nextPageUrl.value)
        ongoingLoad.value=false
    }
}
const getInquiries=(url='/inquiry')=>{
    HTTP.get(url)
    .then(({data})=>{
        if (data.success){
            inquiries.value=[...data.inquiries,...inquiries.value]
            nextPageUrl.value=data.next_page_url
        }
    })
}

const selectedInquiry=ref(null)
const selectInquiry=(inquiry)=>{
    selectedInquiry.value=inquiry
}
const inquiryDetails=ref(null)
const getInquiryDetails=(val)=>{
    const Inquiry=inquiries.value.find((inq)=>inq.id === val.id)
    if (!Inquiry)return
    HTTP.put('/inquiry/'+val.id)
        .then(({data})=>{
            if (data.success){
                Inquiry.read=true;
                inquiryDetails.value=data.inquiry
            }
        })

}
watch(()=>selectedInquiry.value,getInquiryDetails)

getInquiries();
</script>


<style scoped>


    /* ===== MENU ===== */
    .menu {
        float: left;
        height: 700px;;
        width: 70px;
        background: #4768b5;
        background: -webkit-linear-gradient(#4768b5, #35488e);
        background: -o-linear-gradient(#4768b5, #35488e);
        background: -moz-linear-gradient(#4768b5, #35488e);
        background: linear-gradient(#4768b5, #35488e);
        box-shadow: 0 10px 20px rgba(0,0,0,0.19);
    }

    .menu .items {
        list-style:none;
        margin: auto;
        padding: 0;
    }

    .menu .items .item {
        height: 70px;
        border-bottom: 1px solid #6780cc;
        display:flex;
        justify-content: center;
        align-items: center;
        color: #9fb5ef;
        font-size: 17pt;
    }

    .menu .items .item-active {
        background-color:#5172c3;
        color: #FFF;
    }

    .menu .items .item:hover {
        cursor: pointer;
        background-color: #4f6ebd;
        color: #cfe5ff;
    }

    /* === CONVERSATIONS === */

    .discussions {
        width: 35%;
        height: 700px;
        box-shadow: 0px 8px 10px rgba(0,0,0,0.20);
        display: inline-block;
    }

    .discussions .discussion {
        width: 100%;
        height: 90px;
        margin-top: 5px;
        border-bottom: solid 1px #E0E0E0;
        display:flex;
        align-items: center;
        cursor: pointer;
    }

    .discussions .search {
        display:flex;
        align-items: center;
        justify-content: center;
        color: #E0E0E0;
    }

    .discussions .search .searchbar {
        height: 40px;
        background-color: #FFF;
        width: 70%;
        padding: 0 20px;
        border-radius: 50px;
        border: 1px solid #EEEEEE;
        display:flex;
        align-items: center;
        cursor: pointer;
    }

    .discussions .search .searchbar input {
        margin-left: 15px;
        height:38px;
        width:100%;
        border:none;
        font-family: 'Montserrat', sans-serif;;
    }

    .discussions .search .searchbar *::-webkit-input-placeholder {
        color: #E0E0E0;
    }
    .discussions .search .searchbar input *:-moz-placeholder {
        color: #E0E0E0;
    }
    .discussions .search .searchbar input *::-moz-placeholder {
        color: #E0E0E0;
    }
    .discussions .search .searchbar input *:-ms-input-placeholder {
        color: #E0E0E0;
    }

    .discussions .message-active {
        width: 98.5%;
        height: 90px;
        background-color: #FFF;
        border-bottom: solid 1px #E0E0E0;
    }

    .discussions .discussion .photo {
        margin-left:20px;
        display: block;
        width: 45px;
        height: 45px;
        background: #E6E7ED;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .online {
        position: relative;
        top: 30px;
        left: 35px;
        width: 13px;
        height: 13px;
        background-color: #8BC34A;
        border-radius: 13px;
        border: 3px solid #FAFAFA;
    }

    .desc-contact {
        height: 43px;
        width:50%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .discussions .discussion .name {
        margin: 0 0 0 20px;
        font-family:'Montserrat', sans-serif;
        font-size: 11pt;
        color:#515151;
    }

    .discussions .discussion .message {
        margin: 6px 0 0 20px;
        font-family:'Montserrat', sans-serif;
        font-size: 9pt;
        color:#515151;
    }
    .read_state{
        width: 10px;
        height: 10px;
        border-radius: 50%;
        position: absolute;
        background: #0A66C2;
        top: 5px;
        right: 5px;
        z-index: 6;
    }
    .timer {
        margin-left: 15%;
        font-family:'Open Sans', sans-serif;
        font-size: 11px;
        padding: 3px 8px;
        color: #0a0c0d;
        background-color: #FFF;
        border: 1px solid #E5E5E5;
        border-radius: 15px;
    }

    .chat {
        width: calc(65% - 85px);
        background: #E5E5E5;
    }

    .header-chat {
        background-color: #FFF;
        height: 50px;
        box-shadow: 0px 3px 2px rgba(0,0,0,0.100);
        display:flex;
        align-items: start;
    }

    .chat .header-chat .icon {
        margin-left: 30px;
        color:#515151;
        font-size: 14pt;
    }

    .chat .header-chat .name {
        margin: 0 0 0 20px;
        font-family:'Montserrat', sans-serif;
        font-size: 13pt;
        color:#515151;
    }

    .chat .header-chat .right {
        position: absolute;
        right: 40px;
    }

    .chat .messages-chat {
        padding: 25px 35px;
    }

    .chat .messages-chat .message {
        display:flex;
        align-items: center;
        margin-bottom: 8px;
    }

    .chat .messages-chat .message .photo {
        display: block;
        width: 45px;
        height: 45px;
        background: #E6E7ED;
        -moz-border-radius: 50px;
        -webkit-border-radius: 50px;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .chat .messages-chat .text {
        margin: 0 35px;
        background-color: #f6f6f6;
        padding: 15px;
        border-radius: 12px;
    }

    .text-only {
        margin-left: 45px;
    }

    .time {
        font-size: 10px;
        color:lightgrey;
        margin-bottom:10px;
        margin-left: 85px;
    }

    .response-time {
        float: right;
        margin-right: 40px !important;
    }

    .response {
        float: right;
        margin-right: 0px !important;
        margin-left:auto; /* flexbox alignment rule */
    }

    .response .text {
        background-color: #e3effd !important;
    }

    .footer-chat {
        width: calc(65% - 66px);
        height: 80px;
        display:flex;
        align-items: center;
        position:absolute;
        bottom: 0;
        background-color: transparent;
        border-top: 2px solid #EEE;

    }

    .chat .footer-chat .icon {
        margin-left: 30px;
        color:#C0C0C0;
        font-size: 14pt;
    }

    .chat .footer-chat .send {
        color:#fff;
        background-color: #4f6ebd;
        position: absolute;
        right: 50px;
        padding: 12px 12px 12px 12px;
        border-radius: 50px;
        font-size: 14pt;
    }

    .chat .footer-chat .name {
        margin: 0 0 0 20px;
        text-transform: uppercase;
        font-family:'Montserrat', sans-serif;
        font-size: 13pt;
        color:#515151;
    }

    .chat .footer-chat .right {
        position: absolute;
        right: 40px;
    }

    .write-message {
        border:none !important;
        width:60%;
        height: 50px;
        margin-left: 20px;
        padding: 10px;
    }

    .footer-chat *::-webkit-input-placeholder {
        color: #C0C0C0;
        font-size: 13pt;
    }
    .footer-chat input *:-moz-placeholder {
        color: #C0C0C0;
        font-size: 13pt;
    }
    .footer-chat input *::-moz-placeholder {
        color: #C0C0C0;
        font-size: 13pt;
        margin-left:5px;
    }
    .footer-chat input *:-ms-input-placeholder {
        color: #C0C0C0;
        font-size: 13pt;
    }

    .clickable {
        cursor: pointer;
    }
</style>
