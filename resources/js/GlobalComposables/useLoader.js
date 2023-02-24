import {ref} from "vue";

export default function () {
    const loaded=ref(false)
    const setLoaded = (value=true) => {
        loaded.value=value
    }
    return {
        loaded,setLoaded
    }
}
