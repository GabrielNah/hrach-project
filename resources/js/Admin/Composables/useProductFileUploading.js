import {computed, ref, watch} from "vue";
import {useModal} from "../../GlobalComposables/useLoader";

export default function () {
    const modal=useModal()
    const fileUploader=ref(null)

    const generalFile=ref(null)
    const setGeneralFile = (file) => {
      generalFile.value=file
    }
    
    const removeGeneralFromFiles=()=>{
        const index=files.value.findIndex((fl)=>JSON.stringify(fl)===JSON.stringify(generalFile.value))
        if (index===-1){
            return;
        }
        files.value.splice(index,1)
    }

    const selectedFile=ref(null)
    const setSelectedFile=(file)=>{
        selectedFile.value=file
    }

    const files=ref([])
    const displayFiles = () => {
         files.value=Array.from(fileUploader.value.files)
    }
    const getFilesUrl=(file)=>{
        return URL.createObjectURL(file)
    }
    const getFilesType = (file) => {
      return file.type.substring(0,5)
    }

    const removeImage=(index)=>{
        files.value.splice(index,1)

        if (!files.value.length){
            modal.closeModal()
        }
    }


    return {
        ...modal,
        fileUploader,
        displayFiles,
        files,
        setGeneralFile,
        getFilesUrl,
        removeImage,
        getFilesType,
        selectedFile,
        setSelectedFile
    }

}
