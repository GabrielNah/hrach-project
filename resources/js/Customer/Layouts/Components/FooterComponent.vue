<template>
    <footer class="section-footer  text-white"
        :style="properAppearance(appearance)"
    >
        <div class="container">
            <section class="footer-top  padding-y-lg">
                <div class="d-flex w-100 justify-content-between flex-wrap ftr">
                    <aside class="col-md-4 col-12">
                        <article class="mr-md-4">
                            <h5 class="title">Contact us</h5>
                            <p v-if="contactInfo?.introduction">
                                {{ contactInfo.introduction}}
                             </p>
                            <ul class="list-icon">
                                <li v-if="contactInfo?.address">
                                    <i class="icon fa fa-map-marker"> </i>
                                        {{ contactInfo.address }}
                                </li>
                                <li v-if="contactInfo?.email">
                                    <i class="icon fa fa-envelope"> </i> {{ contactInfo.email }}
                                </li>
                                <li v-if="contactInfo?.phone">
                                    <i class="icon fa fa-phone"> </i> {{ contactInfo.phone }}
                                </li>
                                <li v-if="contactInfo?.working_hours">
                                    <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock icon" viewBox="0 0 16 16">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                    </svg>
                                    {{  contactInfo.working_hours }}
                                </li>
                            </ul>
                        </article>
                    </aside>
                    <aside class="col-md-4 col-12">
                        <h5 class="title">Newsletter</h5>
                        <p>
                            {{ contactInfo.new_settler_info }}
                        </p>

                        <form class="form-inline mb-3 d-flex w-100"
                            @submit.prevent="subscribe"
                        >
                            <div  class="position-relative">
                                <input type="text"
                                       placeholder="Email"
                                       v-model="subscriber"
                                       class="border-0 w-auto form-control" name="">
                                <small class="text-danger position-absolute "  v-if="subscriberError">
                                    {{ subscriberError }}
                                </small>
                                <small class="text-success position-absolute "  v-if="successFullySubscribed">
                                    You have subscribed to us
                                </small>
                            </div>

                            <button class="btn ml-2 btn-warning" type="submit"> Subscribe</button>
                        </form>
                       <template v-if="socialMedia.length">
                           <p class="text-white-50 mb-2">Follow us on social media</p>
                           <template v-for="social in socialMedia" :key="social.id">
                               <a

                                   :href="social.link" class="btn btn-icon btn-outline-light"
                                  target="_blank"
                                  style="width: 30px;height: 30px;padding: 0;overflow: hidden;margin-inline: 5px"
                               >
                                   <img class="w-100 h-100" :src="'/'+social.img" alt="">
                               </a>
                           </template>
                       </template>


                    </aside>
                </div> <!-- row.// -->
            </section>	<!-- footer-top.// -->

        </div><!-- //container -->
    </footer>
</template>
<script setup>
import {nextTick, onMounted, ref} from "vue";

const socialMedia=ref([])
const contactInfo=ref({})
const emit=defineEmits(['loaded'])
const getContactInfo=()=>{
    window.axios.get('/contact')
    .then(({data})=>{
        if (data?.socialMedia){
            socialMedia.value=data.socialMedia
        }
        if (data?.contactInfo){
            contactInfo.value=data.contactInfo
        }
    })
}
getContactInfo()
const subscriber=ref('')
const subscriberError=ref('')
const successFullySubscribed=ref(false)
const subscribe=()=>{
    window.axios.post('/subscribe',{
        subscriber:subscriber.value
    }).then(({data})=>{
        if(data.success){
            subscriberError.value=''
            successFullySubscribed.value=true
        }
    }).catch(e=>{
        if (e?.response?.data?.errors){
            successFullySubscribed.value=false
            subscriberError.value=e?.response?.data?.errors?.['subscriber'][0]
        }
    })
}
onMounted(()=>{
    nextTick(()=>emit('loaded'))
})

</script>
<script>
import handleAppearance from "../../../Mixins/handleAppearance";

export default {
    name: "FooterComponent",
    props:{
        appearance:{
            type:Object,
            required:false,
            default:()=>null
        }
    },mixins:[handleAppearance]

}
</script>

<style scoped>
footer{
    background: #12225B ;
    box-shadow: 0px 0px 3px;
}
@media (max-width: 770px) {
    .ftr{
        padding-left: 10px;
    }
}
@media (max-width: 874px ) and (min-width: 770px){
    .form-inline{
        flex-direction: column;
    }
    .form-inline input{
        width: 100% !important;
    }
    .form-inline button{
        width: 50%;
        align-self: center;
    }
}
</style>
