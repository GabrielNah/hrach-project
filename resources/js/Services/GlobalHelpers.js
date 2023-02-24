import router from "../router";
export function extractValidationErrors(e) {
    try {
        return  Object.values(e.response.data.errors)[0][0]?Object.values(e.response.data.errors)[0][0]:'Something went wrong'
    }catch (e) {
        return 'Something went wrong';
    }

}
export function redirectToRouteByName(name){
    router.push({name}).catch(e=>console.log(e))
}
