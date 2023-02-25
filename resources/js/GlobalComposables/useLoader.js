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

export function useModal() {
    const modalOpened=ref(false)
    const openModal=()=>modalOpened.value=true
    const closeModal=()=>modalOpened.value=false

    return {
        modalOpened,
        openModal,
        closeModal
    }
}
