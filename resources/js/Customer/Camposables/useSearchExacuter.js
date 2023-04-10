import {
    SEARCH_TYPE_BY_IDS,
    SEARCH_TYPE_CATEGORY,
    SEARCH_TYPE_DEFAULT,
    SEARCH_TYPE_FILTER
} from "./useProductSeachHelper";

export async  function  executeSearch({type,value},path='/api/product/search') {
    const data = {
        type
    }
    if (type === SEARCH_TYPE_FILTER){
        for (const key in value) {
            data[key]=value
        }
    }
    if (type === SEARCH_TYPE_BY_IDS){
        data.ids=value
    }
    if (type === SEARCH_TYPE_DEFAULT){
        data.value=value
    }
    if (type === SEARCH_TYPE_CATEGORY){
        data.category=value
    }
    return await axios.post(path,data)

}
