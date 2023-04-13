<template>
    <hr style="color: #6c757d">
    <div class="mt-2 w-100 d-flex flex-column pb-5">

        <div class="w-100 d-flex justify-content-between">
            <h5 class="text-white">Social media</h5>
            <button  @click="addSocialMedia" type="button" class="btn btn-success d-flex justify-content-center align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
            </button>
        </div>


        <div class="w-100">
            <template v-if="!socialMedias.length">
                <h6 class="text-white text-center w-100">
                    No social media added yet
                </h6>
            </template>
            <template v-else>
                <div class="w-100 d-flex flex-column gap-2 mt-2">
                    <form class="d-flex justify-content-between w-100" v-for="(social,index) in socialMedias"
                        :key="social.id"
                        @submit.prevent="saveChanges($event,social,index)"
                    >
                        <label class="position-relative btn btn-secondary btn-sm align-self-start text-white">
                            Upload image
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                            </svg>
                            <input type="file"
                                   @change="onChange($event,social)"
                                   class="position-absolute d-none"
                                   name="img"
                                   style="left: 0;right: 0;bottom: 0;top: 0"
                            >
                        </label>
                        <div class="form-group">
                            <label class="text-white mr-1">Attach link:</label>
                            <input type="text"
                                   v-model="social.link"
                                   name="link"
                                   placeholder="Lik of you social media account"
                            >
                        </div>
                        <a :href="social.link" class="btn btn-icon btn-outline-light"
                           target="_blank"
                            style="width: 30px;height: 30px;padding: 0;overflow: hidden"
                        >
                            <img class="w-100 h-100" :src="social.uploaded ? social.uploaded: '/'+ social.img" alt="">
                        </a>

                        <div class="d-flex gap-1">
                            <button class="btn btn-success btn-sm "
                                    type="submit" data-toggle="tooltip" data-placement="top" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                </svg>
                            </button>
                            <button
                                style="margin-left: 5px" class="btn btn-danger btn-sm rounded-0" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"
                                @click="removeSocial(social,index)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </button>
                            <button class="btn btn-secondary border-0"
                                    v-if="social?.uploaded"
                                    @click="dropData(social)"
                                    type="button">
                                Drop Image
                            </button>
                        </div>
                    </form>
                </div>

            </template>

        </div>
    </div>
</template>
<script setup>
import {ref} from "vue";
import HTTP from "../../Axios/axiosCongif";
import {errorNotification, successNotification} from "../../../Services/NotificationService";
import {extractValidationErrors} from "../../../Services/GlobalHelpers";

const socialMedias=ref([])

     const addSocialMedia=()=>{
         socialMedias.value.push({
             id:Date.now()+Math.random(),
             img:'',
             added:true,
             link:'',
         })
     }

     const dropData=(social)=>{
            social.uploaded=''
     }
     const getSocials=()=>{
        HTTP.get('/contactInfo/social')
         .then(({data})=>{
             socialMedias.value=data.social
         })
     }
     const getFileUrl= (file)=>{
         return new Promise((resolve)=>{
             const fileReader=new FileReader()
             fileReader.onload=()=>{
                 resolve(fileReader.result)
             }
             fileReader.readAsDataURL(file)
         })
     }
     const onChange=async(e,social)=>{
         social.uploaded=await getFileUrl(e.target.files[0])
     }

     const saveChanges=(e,social,index)=>{
        const data=new FormData(e.target)
        let method='post';
        let url='/contactInfo/social/store'
        let notification = 'Social media link info successfully';
        if (!social?.added){
            method='put'
            url=`/contactInfo/social/edit/${social.id}`
            notification='Social media info edited successfully '
        }

        HTTP[method](url,data)
         .then(({data})=>{
             if (data.success){
                 socialMedias.value[index]=data.social
                 successNotification(notification)
             }
         }).catch(e=>errorNotification(extractValidationErrors(e)))
     }
     const removeSocial=(social,index)=>{
            if (social.added){
                socialMedias.value.splice(index,1)
                return;
            }

            HTTP.delete('/contactInfo/social/'+social.id)
            .then((r)=>{
                if (r.status === 204){
                    socialMedias.value.splice(index,1)
                    successNotification('Social media info removed successfully')
                }
            }).catch(e=>errorNotification(extractValidationErrors(e)))
     }
     getSocials()




</script>
<script>
export default {
    name: "SocialMediaInfo"
}
</script>

<style scoped>

</style>
