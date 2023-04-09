import {ref} from "vue";

export default function (){
    const key = ref(0)
    const reloadComponent = ()=>key.value++
    return {
        key,
        reloadComponent
    }
}
