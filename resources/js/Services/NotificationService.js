
import { notify } from "@kyvg/vue3-notification";

export const errorNotification=(text,title='Error')=>{
    notify({
        title,
        text,
        type:'error',
        ignoreDuplicates:true,
    })
}

export const successNotification=(text,title='Success')=>{
    notify({
        title,
        text,
        type:'success',
        ignoreDuplicates:true,
    })
}

export const infoNotification = (text,title='Info')=>{
    notify({
        title,
        text,
        type:'info',
        ignoreDuplicates:true,
        duration:1500,
    })
}
