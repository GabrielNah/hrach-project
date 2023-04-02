import HTTP from "../Admin/Axios/axiosCongif";

export default function () {
    const removeFile =(product_id,file_id)=>{
        HTTP.delete(`/product/${product_id}/${file_id}`)
            .then((r)=>console.log(e))
    }

    return {
        removeFile
    }
}
