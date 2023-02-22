import axios from "axios";
import {getCookie} from "../../Services/CookieService";

const HTTP=axios.create({
    headers:{
        'X-Request-With':'XMLHttpRequest'
    },
    withCredentials:true
});


const onRequest = (config) => {
    if (config.method!=='get' && config.method!=='options' && !getCsrfCookie()) {
        return setCSRFToken()
            .then(response => config);
    }
    return config;
}
const getCsrfCookie=()=>{
    return getCookie('XSRF-TOKEN')
}

const setCSRFToken = () => {
    return axios.get('/sanctum/csrf-cookie');
}
HTTP.interceptors.request.use(onRequest,(e)=>Promise.reject(e));
export default HTTP;
