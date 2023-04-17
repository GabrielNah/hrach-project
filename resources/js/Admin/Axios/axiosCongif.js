import axios from "axios";
import {getCookie} from "../../Services/CookieService";

const HTTP=axios.create({
    baseURL:'/admin',
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

const onResponseError=(error) => {
    if (error.config && error.response &&
        (error.response.status === 401 || error.response.status===419) &&
        error.config.url !== '/sanctum/csrf-cookie') {
        return setCSRFToken().then(() => {
            return axios.request(error.config);
        });
    }

    return Promise.reject(error);
}


HTTP.interceptors.request.use(onRequest,(e)=>Promise.reject(e));
HTTP.interceptors.response.use(onRequest,onResponseError);
export default HTTP;
