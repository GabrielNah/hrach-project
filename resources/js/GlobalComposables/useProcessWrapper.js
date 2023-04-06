import {ref} from "vue";

export default  function (){
    const ongoingProcess = ref(false)
    const wrapWithinProcess = async (callback)=>{
        if (ongoingProcess.value){
            return;
        }
        ongoingProcess.value = true;
        await callback()
        ongoingProcess.value = false
    }
}
