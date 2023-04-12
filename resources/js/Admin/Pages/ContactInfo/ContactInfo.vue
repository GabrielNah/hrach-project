<template>
  <div class="container">
      <div class="w-100 p-2 d-flex flex-column">
          <h5 class="text-white">Contact info </h5>
          <div>
              <form @submit.prevent="saveContactInfo">
                  <div class="form-group">
                      <label class="text-muted">Email address</label>
                      <input type="email" class="form-control"
                             aria-describedby="emailHelp"
                             v-model="contactInfo.email"
                             placeholder="Enter email">
                  </div>
                  <div class="form-group mt-1">
                      <label class="text-muted" >Address</label>
                      <input type="text" class="form-control"  aria-describedby="emailHelp"
                             v-model="contactInfo.address"
                             placeholder="Enter address">
                  </div>
                  <div class="form-group mt-1">
                      <label class="text-muted">Phone number</label>
                      <input type="text" class="form-control"  aria-describedby="emailHelp"
                             v-model="contactInfo.phone"
                             placeholder="Enter phone number">
                  </div>
                  <div class="form-group mt-1">
                      <label class="text-muted">Working hours</label>
                      <input type="text" class="form-control"
                             aria-describedby="emailHelp"
                             v-model="contactInfo.working_hours"
                             placeholder="Mon-Sat 10:00pm - 7:00pm">
                  </div>
                  <div class="form-group mt-1">
                      <label class="text-muted"> Contact info block introduction </label>
                      <input type="text" class="form-control"  aria-describedby="emailHelp"
                             v-model="contactInfo.introduction"
                             placeholder="Enter block introduction">
                  </div>
                  <div class="form-group mt-1">
                      <label class="text-muted"> Newsletters block introduction </label>
                      <input type="text" class="form-control"
                             aria-describedby="emailHelp"
                             v-model="contactInfo.new_settler_info"
                             placeholder="Enter newsletters block introduction">
                  </div>
                  <button type="submit" class="btn btn-primary mt-3">Submit</button>
              </form>
          </div>
      </div>
      <social-media-info/>
  </div>
</template>
<script setup>
import {onMounted, reactive} from "vue";
import HTTP from "../../Axios/axiosCongif";
import {errorNotification, successNotification} from "../../../Services/NotificationService";
import {extractValidationErrors} from "../../../Services/GlobalHelpers";


const contactInfo=reactive({
    email:'',
    address:'',
    working_hours:'',
    introduction:'',
    phone:'',
    new_settler_info:'',
})
const saveContactInfo=()=>{
    HTTP.post('/contactInfo/store',{...contactInfo})
    .then(({data})=>{
        if (data.success){
            successNotification('Contact info modified successfully')
        }
    })
    .catch(e=>errorNotification(extractValidationErrors(e)))
}
onMounted(()=>{
    HTTP.get('/contactInfo')
    .then(({data})=>{
        if (!data?.contactInfo) return
        let {email,address,working_hours,introduction,phone,new_settler_info}=data.contactInfo
        contactInfo.email=email;
        contactInfo.address=address;
        contactInfo.working_hours=working_hours;
        contactInfo.introduction=introduction;
        contactInfo.phone=phone;
        contactInfo.new_settler_info=new_settler_info;
    })
})
</script>
<script>
import SocialMediaInfo from "./SocialMediaInfo.vue";
export default {
    name: "ContactInfo",
    components:{SocialMediaInfo}
}
</script>

<style scoped>

</style>
