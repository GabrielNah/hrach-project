import {reactive, ref} from "vue";
import HTTP from "../Axios/axiosCongif";
import useLoader from "../../GlobalComposables/useLoader";
import {errorNotification, successNotification} from "../../Services/NotificationService";
import {extractValidationErrors} from "../../Services/GlobalHelpers";

export default function () {
    const loader=useLoader()
    const tags=ref([]);
    const setTags=(tagsData)=>{
        tags.value=tagsData
    }

    const addTag=(tag)=>{
        tags.value.push(tag)
    }

    const removeTag=(tag)=>{
        const index=tags.value.findIndex((tg)=>tg.id===tag.id)
        if (index===-1){
            return;
        }

        tags.value.splice(index,1)
    }

    const tag=reactive({
        id:0,
        name:'',
        description:''
    })

    const setTag=(tagData)=>{
        tag.name=tagData.name
        tag.id=tagData.id
        tag.description=tagData.description
    }


    const createTag=async (after=()=>void(0))=>{
        try {
            loader.setLoaded(false)
            let {data}=await HTTP.post('/settings/tag',tag)
            if (data.success){
                addTag(data.tag)
                loader.setLoaded(true)
                resetModalData()
            }
            successNotification('Tag created successfully')
            after()
        }catch (e) {
            errorNotification(extractValidationErrors(e))
        }
    }
    const resetModalData=()=>{
        tag.name=''
        tag.id=0
        tag.description=''
    }

    const deleteTag=async (tag)=>{
        try {
            const response=await HTTP.delete('/settings/tag/'+tag.id)
            if (response.status === 204){
                removeTag(tag)
                resetModalData()
                successNotification('Tag removed successfully')
            }
        }catch (e) {
            errorNotification(extractValidationErrors(e))
        }
    }

    const startEditionOfModal=(tagData,then)=>{
        tag.id=tagData.id
        tag.name=tagData.name
        tag.description=tagData.description
        then()
    }

    const editTag=async (then)=>{
        try {
            const {data}=await HTTP.put('/settings/tag/'+tag.id,tag)
            if (data.success){
                let updatedTag=tags.value.findIndex(tg=>tg?.id===tag.id)
                resetModalData()
                if (updatedTag===-1){
                    return
                }
                tags.value[updatedTag]=data.tag
                successNotification('Tag updated successfully')
                then()
            }
        }catch (e) {
            errorNotification(extractValidationErrors(e))
        }
    }



    return {
        tag,
        setTag,
        setTags,
        createTag,
        tags,
        removeTag,
        addTag,
        startEditionOfModal,
        editTag,
        deleteTag
    }
}
