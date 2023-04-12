<template>
    <div class="w-100">
        <div class="d-flex w-100 flex-column">
            <div class="w-100 d-flex justify-content-between mb-3">
                <h5>Hot keys</h5>
                <button
                    @click="addHotKey"
                    type="button" class="btn btn-success d-flex justify-content-center align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                </button>
            </div>
            <template v-if="hotKeys.length">
                <div class="overflow-auto " style="max-height: 65vh">
                    <div class="input-group mb-3" v-for="(hot_key,index) in hotKeys"
                         :key="hot_key.id">
                        <input type="text" class="form-control"
                               v-model="hot_key.key"
                               placeholder="Hot key" aria-label="Recipient's username"
                               aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <div class="input-group-text" id="basic-addon2">
                                <button class="btn btn-success btn-sm "
                                        @click="wrapWithinProcess(()=>saveHotKey(hot_key,index))"
                                        type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                    </svg>
                                </button>
                                <button
                                    @click="removeHotKey(hot_key,index)"
                                    style="margin-left: 5px" class="btn btn-danger btn-sm rounded-0" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>

            </template>
            <template v-else>
                <h6 class="w-100  text-center">
                    No hot key added yet
                </h6>
            </template>

        </div>

    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
    import HTTP from "../../Axios/axiosCongif";
    import {errorNotification, successNotification} from "../../../Services/NotificationService";
    import {extractValidationErrors} from "../../../Services/GlobalHelpers";

    const hotKeys=ref([])
    const addHotKey=()=>{
        hotKeys.value.push({
            id:Date.now()+Math.random(),
            added:true,
            key:''
        })
    }
    const saveHotKey=(key,index)=>{
        let url;
        let method;
        let notification;
        if (key.added){
            method='post';
            url=`/hot_keys/store`
            notification='Hot key added successfully'
        }
        if (!key.added){
            method='put';
            url=`/hot_keys/edit/${key.id}`
            notification='Hot key edited successfully'
        }

        HTTP[method](url,{key:key.key})
        .then(({data})=>{
            hotKeys.value[index]=data.hot_key;
            successNotification(notification)
        })
        .catch(e=>errorNotification(extractValidationErrors(e)))

    }
    const removeHotKey=(key,index)=>{
        if (key.added){
            hotKeys.value.splice(index,1);
            return;
        }
        HTTP.delete(`/hot_keys/${key.id}`)
        .then((res)=>{
            if (res.status === 204){
                hotKeys.value.splice(index,1);
                successNotification('Hot key removed successfully')
            }
        }).catch(e=>errorNotification(extractValidationErrors(e)))
    }

    const getHotKeys=()=>{
        HTTP.get('/hot_keys')
        .then(({data})=>{
            hotKeys.value=data.hotKeys
        })
    }

    onMounted(getHotKeys)
</script>
<script>
import processWrappes from "../../../Mixins/processWrappes";

export default {
    name: "EditHotKeys",
    mixins:[processWrappes]
}
</script>

<style scoped>

</style>
