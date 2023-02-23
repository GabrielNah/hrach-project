
import { notify } from "@kyvg/vue3-notification";

export const errorNotification=(text,title=null)=>{
    notify({
        title,
        text,
        type:'error',
        ignoreDuplicates:true,
    })
}

export const successNotification=(text,title=null)=>{
    notify({
        title,
        text,
        type:'success',
        ignoreDuplicates:true,
    })
}
