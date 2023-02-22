
import { notify } from "@kyvg/vue3-notification";

export const errorNotification=(text,title=null)=>{
    console.log(text)
    notify({
        title,
        text,
        type:'error',
        ignoreDuplicates:true,
    })
}
