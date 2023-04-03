<template>
    <div class="d-flex flex-column w-100">
        <h3 class="text-center text-danger" v-if="hasNoGeneral">The product does not have general file</h3>
        <div class="w-100 d-flex">
            <h3 class="text-monospace d-block text-center flex-grow-1">Products files</h3>
            <label class="position-relative btn btn-secondary">
                    Add files
                 <input type="file" ref="uploadedFiles" @change="getUploadedFiles" class="invisible_input" multiple>
            </label>
            <button class="btn btn-success" v-if="needsToSaveChanges"
                @click="saveChanges"
            >
                Save changes
            </button>

        </div>

        <section class="d-flex justify-content-between w-100" v-if="selectedFile">
            <div class="border-gray product_file p-2 d-flex justify-content-center align-items-center w-75">
                <template v-if="selectedFile.type === 'video'">
                    <video style="width: 95%" :src="(selectedFile.uploaded ? '':'/')+selectedFile.path" autoplay controls></video>
                </template>
                <template v-if="selectedFile.type === 'image'">
                    <img style="width: 95%" class="product_select_file" :src="(selectedFile.uploaded ? '':'/')+selectedFile.path" />
                </template>
            </div>
            <div class="d-flex flex-column flex-grow-1 pt-2">
                <label style="cursor: pointer" v-if="!(selectedFile.general || selectedFile.uploaded)"
                    @click="markAsGeneral"
                >
                    <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                        </svg>
                    </button>
                    Mark as general
                </label>
                <label  class="mt-2" style="cursor: pointer" @click="removeFile(selectedFile)">
                    <button class="btn btn-danger btn-sm rounded-0"
                            type="button"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </button>
                    Remove file
                </label>
                <label style="cursor: pointer" class="mt-2" v-if="selectedFile.uploaded"
                    @click="uploadOneFile"
                >
                    <button class="btn btn-primary btn-sm rounded-0"
                            type="button"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                        </svg>
                    </button>
                    Upload
                </label>

            </div>

        </section>


        <div class="p-2 d-flex product_file_wrapper">
            <div v-for="file in files"
                 :key="file.id"
                 :class="{
                     'general':file.general,
                     'active': selectedFile && (selectedFile.id === file.id)
                 }"
                 @click="selectFile(file)"
            >
                <template v-if="file.type === 'video'">
                    <video class="product_file" :src="(file.uploaded ? '':'/')+file.path" autoplay controls></video>
                </template>
                <template v-if="file.type === 'image'">
                    <img class="product_file" :src="(file.uploaded ? '':'/')+file.path" />
                </template>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditFiles"
}
</script>
<script setup>
import {computed, onMounted, ref, watch, watchEffect,defineEmits} from "vue";
  import HTTP from "../../../Axios/axiosCongif";
  import {useRoute} from "vue-router";
 const emit = defineEmits(['close'])
  const files = ref([]);
  const uploadedFiles=ref(null)
  const selectedFile=ref(null)
  const needsToSaveChanges=ref(false)

  const hasNoGeneral = computed(()=>{
      if (!files.value.length){
          return false;
      }
      return files.value.every((file) => file.general === false)
  })


  const selectFile=(file)=>{
      selectedFile.value = file
  }
  const addFile=(file)=>files.value.push(file)

  const id = computed(()=>{
    const route = useRoute()
    return route.params.id ?? 0
  })
  const getUploadedFiles=async (e)=>{
      needsToSaveChanges.value=true
      const getUrl= async (reader,file)=>{
        return new Promise((resolve)=>{
            reader.onload=(()=>{
                resolve(reader.result)
            })
            reader.readAsDataURL(file)
        })
      }
      for (const [index, file] of Object.entries(e.target.files)) {
          const reader = new FileReader();
          const path = await getUrl(reader, file);
          const type = file.type.includes('image') ? 'image' : 'video';
          const id = Date.now() + Math.random();
          addFile({
              path,
              type,
              id,
              index,
              general: false,
              uploaded: true,
          });
      }
  }
  const uploadOneFile=async ()=>{
      const data= new FormData();
      const file= [...uploadedFiles.value.files].at(selectedFile.value.index)
      if (!file){
          return;
      }
      data.append('uploaded_file',file)
      data.append('_method','PUT')
      HTTP.post(`/product/files/${id.value}/upload`, data)
      .then(({data})=>{
          if (data.success){
              let  fileIndex = files.value.findIndex(fn=>fn.id === selectedFile.value.id)
              if (fileIndex === -1 ){
                  return;
              }
              selectedFile.value = data.file
              selectedFile.value.uploaded = false
              files.value[fileIndex]=selectedFile.value
          }
      })

  }
  const removeFile=()=>{
      let index = files.value.findIndex(fl=>fl.id === selectedFile.value.id)
      if (index === -1){
          return;
      }
      if (selectedFile.value?.uploaded){
          files.value.splice(index,1)
          selectedFile.value=files.value.at(0)
          return;
      }
      HTTP.delete(`/product/files/${id.value}/${selectedFile.value.id}`)
      .then(res=>{
          if (res.status === 204){
              files.value.splice(index,1)
              selectedFile.value=files.value.at(0)
          }

      })
  }
  const getFiles =(id)=>{
      HTTP.get('/product/files/'+id)
          .then(({data})=>{
              files.value=data.files
          })
  }

  const saveChanges= ()=>{
      const nonUploadeds = files.value.filter((fl)=>fl.uploaded)
      if (!nonUploadeds.length){
          needsToSaveChanges.value = false;
          return;
      }
      let data = new FormData;
      data.append('_method','PATCH')
      nonUploadeds.forEach((fl)=>{
          const file= [...uploadedFiles.value.files].at(fl.index)
          data.append('files[]',file)
      })
      HTTP.post(`/product/files/${id.value}/multiupload`, data)
      .then(({data})=>{
            if (data.success){
                emit('close')
            }
      }).catch(e=>console.warn(e))

  }

  const markAsGeneral=()=>{
        HTTP.post(`/product/files/general/${id.value}/${selectedFile.value.id}`)
        .then(({data})=>{
            if (data.success){
                selectedFile.value.general = true;
               let indexOfGeneral =  files.value.findIndex((fl)=>fl.id === selectedFile.value.id)
                if (indexOfGeneral === -1){
                    return;
                }
               files.value.forEach(fl => fl.general = false)
               files.value[indexOfGeneral].general = true;
            }
        })
    }

  onMounted(()=>{
      if (id.value){
        getFiles(id.value)
      }
  })


</script>

<style scoped lang="scss">
.invisible_input{
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}
.product_file_wrapper{
    flex-direction: row;
    height: 150px;
    overflow: auto;
    gap: 10px;
    position: relative;

.product_file{
    max-height: 90%;
}
.general{
    border: #00b517 solid 4px;
}
    .active {
        border: orange solid 5px;
    }
div{
    cursor: pointer;
}
}


</style>
