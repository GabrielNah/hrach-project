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
   const currencies=ref([]);
   const categories=ref([]);
   const existingTags=ref([]);

   const setPageInitialValues=(data)=>{
       colors.value=data.colors
       sizes.value=data.sizes
       currencies.value=data.currencies
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
        currencies,
        categories
    }
}


export function usePriceAdder() {
    const priceCount=ref([{id:0,forMany:false}])
    const addPrice = () => {
        priceCount.value.push({id:Date.now(),forMany:false})
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
