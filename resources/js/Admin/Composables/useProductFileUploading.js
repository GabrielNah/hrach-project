import {computed, onMounted, ref, watch} from "vue";
import {useModal} from "../../GlobalComposables/useLoader";
import HTTP from "../Axios/axiosCongif";

export default function () {
    const modal=useModal()
    const fileUploader=ref(null)

    const generalFile=ref(null)

    const setGeneralFile = (file) => {
      generalFile.value=file
    }


    const selectedFile=ref(null)
    const setSelectedFile=(file)=>{
        selectedFile.value=file
    }

    const files=ref([])
    const displayFiles = () => {
         files.value=Array.from(fileUploader.value.files)
    }
    const getFilesUrl=(file)=>{
        return URL.createObjectURL(file)
    }
    const getFilesType = (file) => {
      return file.type.substring(0,5)
    }

    const removeImage=(index)=>{
        files.value.splice(index,1)

        if (!files.value.length){
            modal.closeModal()
        }
    }

    const fileIsGeneral=(file)=>{
        return file === generalFile.value
    }


    return {
        ...modal,
        fileUploader,
        displayFiles,
        files,
        setGeneralFile,
        getFilesUrl,
        removeImage,
        getFilesType,
        selectedFile,
        generalFile,
        setSelectedFile,
        fileIsGeneral
    }

}

export function useMetaDataHandler() {
    const metadataCount=ref([{id:0}])

    const setInitialMetadata=(initVal)=>{
        metadataCount.value=initVal
    }
    const addMetadata = () => {
        metadataCount.value.push({id:Date.now()})
    }

    const removeMetaData = (value) => {
        let index=metadataCount.value.findIndex(mt=>mt.id===value.id)
        if (index===-1){
            return;
        }
        metadataCount.value.splice(index,1)
    }

    return {
        metadataCount,
        removeMetaData,
        addMetadata,
        setInitialMetadata
    }
}


export function useAddProductsInitialData() {
   const colors=ref([]);
   const sizes=ref([]);
   const categories=ref([]);
   const existingTags=ref([]);

   const setPageInitialValues=(data)=>{
       colors.value=data.colors
       sizes.value=data.sizes
       categories.value=data.categories
       existingTags.value=data.tag
    }


   const getInitialData=async ()=>{
       try {
           let {data}=await HTTP.get('/product')
           setPageInitialValues(data)
       }catch (e) {
           console.log(e)
       }
   }

   onMounted(getInitialData)
    return{
        colors,
        sizes,
        existingTags,
        categories
    }
}


export function usePriceAdder() {
    const priceCount=ref([{id:0}])
    const addPrice = () => {
        priceCount.value.push({id:Date.now()})
    }

    const removePrice = (value) => {
        let index=priceCount.value.findIndex(prc=>prc.id===value.id)
        if (index===-1){
            return;
        }
        priceCount.value.splice(index,1)
    }

    const switchPriceType=(value)=>{
        value.forMany=!value.forMany
    }

    return {
        priceCount,
        addPrice,
        removePrice,
        switchPriceType
    }
}

export function useProductSizeAndColorSetter() {
    const size=ref([]);
    const color=ref([]);
    const tags=ref([]);

    const setSize=(val)=>{
        size.value=val
    }
    const setColors=(val)=>{
        color.value=val
    }

    const setTags=(val)=>{
        tags.value=val
    }


    return {
        size,
        color,
        setColors,
        setSize,
        tags,
        setTags
    }
}

export function useIndividualColors(){
    const colorsCount=ref([{
        id:Date.now()+Math.round(Math.random())
    }])
    const addColor = ()=>colorsCount.value.push({
        id:Date.now()+Math.round(Math.random())
    })
    const handleFileUpload=(e,i)=>{
        const file=e.target.files[0]
        const reader = new FileReader()
        reader.onload=()=>{
            document.querySelector('#individual_size'+i).src=reader.result
        }
        reader.readAsDataURL(file)
    }

    const removeOne=(id)=>{
        let index= colorsCount.value.findIndex((sz)=>sz.id === id)
        if (index === -1){
            return;
        }
        colorsCount.value.splice(index,1)
    }


    return {
        colorsCount,
        addColor,
        handleFileUpload,
        removeOne
    }
}


export const useIndividualSizeHandler = ()=>{
    const sizesCount=ref([{
        id:Date.now()+Math.round(Math.random())
    }])
    const addSize = ()=>sizesCount.value.push({
        id:Date.now()+Math.round(Math.random())
    })


    const removeOne=(id)=>{
        let index= sizesCount.value.findIndex((sz)=>sz.id === id)
        if (index === -1){
            return;
        }
        sizesCount.value.splice(index,1)
    }


    return {
        sizesCount,
        addSize,
        removeOne
    }
}
