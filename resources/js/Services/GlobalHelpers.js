import router from "../router";
export function extractValidationErrors(e) {
    try {
       if (e?.response?.status === 422){

        return  Object.values(e.response.data.errors)[0][0]?Object.values(e.response.data.errors)[0][0]:'Something went wrong'
       }
       if (e?.response?.data?.ERROR){
           return e?.response?.data?.ERROR
       }
       return e?.message ?? 'Something went wrong'
    }catch (e) {
        return 'Something went wrong';
    }

}
export function redirectToRouteByName(name,params={}){
    const namesAreSame=router.currentRoute.value.name === name;
    if (namesAreSame && _.isEqual(params,router.currentRoute.value.params)){
        return;
    }
    router.push({name,params}).catch(e=>console.log(e))
}
