<template>
    <div class="container d-flex flex-column">
        <h5 class="text-white text-center w-25">Site Appearance</h5>


        <div class="d-flex  w-100 justify-content-between mt-3">
            <span class="text-white w-25 ">Section name</span>
            <span class="text-white w-25 ">Decoration type</span>
            <span class="text-white w-25 ">Value</span>
        </div>
        <div class="d-flex" v-for="section in sections"
             :key="section.id"
        >
            <form class="d-flex  w-100 justify-content-between mt-3"
                  @submit.prevent="saveSiteAppearance($event,section)"
            >

            <input type="text" name="section" readonly
                v-model="section.section"
            >
            <div class="w-25">
               <select class="form-select w-100"
                       name="type"
                       v-model="section.type" aria-label="Default select example">
                   <option selected>Open this select menu</option>
                   <template v-for="type in TYPES">
                       <option :value="type">{{ type }}</option>
                   </template>
               </select>
           </div>
            <div class="w-25">
                <input type="color" name="value"
                       v-model="section.value"
                       v-if="section.type===TYPES.color">
                <label style="cursor: pointer" class="text-white position-relative"
                       v-else
                >
                    <input type="file"
                           name="value"
                           :id="'file_input'+section.id"
                           class="hidden" @change="uploadFile($event,section)">
                    <button class="btn btn-primary btn-sm rounded-0 "
                            type="button"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                        </svg>
                    </button>
                    {{ section?.uploaded ?'Uploaded' : 'Upload' }}
                </label>
            </div>
                <button class="btn btn-success btn-sm "
                        type="submit" data-toggle="tooltip" data-placement="top" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                    </svg>
                </button>
        </form>
        </div>
    </div>
    <teleport to="#app">
        <Modal v-if="modal.modalOpened.value"
            @close="modal.closeModal"
        >
            <img :src="selectedImage" alt="" class="w-100">
        </Modal>
    </teleport>
</template>

<script>
import {defineAsyncComponent, ref} from "vue";
import {useModal} from "../../GlobalComposables/useLoader";
import HTTP from "../Axios/axiosCongif";
import {errorNotification, successNotification} from "../../Services/NotificationService";
import {extractValidationErrors} from "../../Services/GlobalHelpers";

export default {
    name: "SiteAppearance",
    components: {
        Modal:defineAsyncComponent(()=>import("../../SharedComponents/ReusableComponents/Modal.vue"))
    },

    setup(){
        const TYPES={
            image:'image',
            color:'color',
        }

        const modal=useModal()

        const SECTIONS={
            header:'header',
            footer:'footer',
            main:'main',
        }
        let sectionsInitialValue = [];
        const sections=ref([
            {id:1,section:SECTIONS.header,type:TYPES.color,value:''},
            {id:2,section:SECTIONS.main,type:TYPES.color,value:''},
            {id:3,section:SECTIONS.footer,type:TYPES.color,value:''},
        ])

        const selectedImage=ref('')

        const setSelectedImage=(path)=>{
            selectedImage.value=path
            if (!path)return
            modal.openModal()
        }
        const uploadFile=async (e,section)=>{
            if (!e.target.files.length){
                setSelectedImage('')
                section.uploaded=null;
                return;
            }
            const path=await getUrl(e);
            setSelectedImage(path)
            section.uploaded=e.target.files[0]??null
        }
        const getUrl=(e)=>{
            return new Promise((resolve)=>{
                const reader=new FileReader()
                reader.onload=()=>{
                    resolve(reader.result)
                }
                reader.readAsDataURL(e.target.files[0])
            })
        }
        const getSiteAppearance=()=>{
            HTTP.get('/state/appearance')
                .then(({data})=>{
                    if (data?.sections?.length){
                        if(data.sections.length === 3){
                            sections.value=data.sections
                            return;
                        }
                        sections.value=sections.value.map((sctn,i)=>{
                            let sectionData=data.sections.find(sct=>sct.id === sctn.id)
                            if (sectionData){
                                return sectionData
                            }
                            return sctn
                        })

                    }
                })
        }

        const saveSiteAppearance=(e,section)=>{
            const data=new FormData(e.target)
            if (data.get('type')===TYPES.image){
                if (!document.getElementById('file_input'+section.id).value){
                    data.set('value',section.value)
                }
            }
            HTTP.post('/state/edit/appearance/'+section.id,data)
                .then(({data})=>{
                    if (data.success){
                        let sctn=sections.value.find(scn=>scn.id === section.id)
                        if (sctn){
                            sctn=data.section
                            successNotification('Site appearance modified successfully')
                        }
                    }
                }).catch(e=>errorNotification(extractValidationErrors(e)))
        }

        getSiteAppearance()

        return {
            TYPES,
            SECTIONS,
            sections,
            selectedImage,
            modal,
            uploadFile,
            saveSiteAppearance,
            setSelectedImage
        }
    }
}
</script>

<style scoped>
.hidden{
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0;
}
</style>
