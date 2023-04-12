import { reactive} from "vue";
import {PRODUCT_LIST_PAGE} from "../../router/Customer/customerRoutes";
import {redirectToRouteByName} from "../../Services/GlobalHelpers";

export const SEARCH_TYPE_BY_IDS='ids'
export const SEARCH_TYPE_DEFAULT='default'
export const SEARCH_TYPE_FILTER='filter'
export const SEARCH_TYPE_CATEGORY='category'

    const search=reactive({
        type:SEARCH_TYPE_DEFAULT,
        value:''
    })

    const redirectIfNecessary=()=>{
            redirectToRouteByName(PRODUCT_LIST_PAGE)
    }
    const setSearchType = (type)=>{
        search.type=type
    }
    const setSearchValue = (value)=>{
        search.value=value
    }


    const searchByIds=(searchVal)=>{
        if (!searchVal){
            return;
        }
        setSearchType(SEARCH_TYPE_BY_IDS)
        setSearchValue(searchVal)
        redirectIfNecessary()
    }

    const defaultSearch=(searchVal)=>{
        if (!searchVal){
            return;
        }
        setSearchType(SEARCH_TYPE_DEFAULT)
        setSearchValue(searchVal)
        redirectIfNecessary()
    }
    const searchByCategories=(searchVal)=>{
        if (!searchVal){
            return;
        }
        setSearchType(SEARCH_TYPE_CATEGORY)
        setSearchValue(searchVal)
    }


    export default {
        searchByIds,
        defaultSearch,
        searchByCategories,
        search
    }


