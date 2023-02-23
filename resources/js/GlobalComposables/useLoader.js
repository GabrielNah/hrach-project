import {ref} from "vue";

export default function () {
    const loaded=ref(false)
    const setLoaded = () => {
        console.log('kanchvav')
        loaded.value=true
    }
    return {
        loaded,setLoaded
    }
}
