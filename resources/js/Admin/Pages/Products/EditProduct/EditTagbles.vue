<template>
    <div class="d-flex flex-column w-100 gap-1 overflow-auto" @scroll.stop="" style="max-height: 70vh">
        <h5 class="text-white text-center bg-dark w-100"> Colors , sizes and tags of the product </h5>
        <div class="bordered d-flex flex-column p-1">
            <div class="w-100 d-flex justify-content-between">
                <h6>Tags</h6>
                <button
                    @click="wrapWithinProcess(saveTags)"
                    class="btn btn-success btn-sm rounded-0 " type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                    </svg>
                </button>
            </div>
            <multiselect :values="tags" :showable-key="'name'" :unique-key="'id'"
                         :initial-values="product.tags"
                         @selected="setProductsTags"
            />
        </div>
        <div class="bordered d-flex flex-column p-1">
            <h6>Sizes</h6>
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between">
                    <span class="fw-semibold">
                        General sizes
                    </span>
                    <button
                        @click="wrapWithinProcess(saveGeneralSizes)"
                        class="btn btn-success btn-sm rounded-0 " type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                        </svg>
                    </button>
                </div>
                <multiselect :values="sizes" :showable-key="'size'" :unique-key="'id'"
                             :initial-values="product.sizes.global"
                             @selected="setProductGlobalSizes"
                />

            </div>
                <hr>
            <div class="d-flex flex-column">
                <div class="d-flex flex-row w-100 justify-content-between align-items-center pt-1">
                    <span class="fw-semibold">
                        Individual sizes
                    </span>
                    <button  @click="addIndividualSize" type="button" class="btn btn-success d-flex justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                    </button>
                </div>
                <template v-if="!product.sizes.individual.length">
                    <span class="text-monospace text-info"> Product does not have individual sizes  </span>
                </template>
                <template v-else>
                    <div class="form-group" v-for="(individualSize,index) in product.sizes.individual"
                        :key="individualSize.id"
                    >
                         <label >Size :</label>
                        <div class="d-flex flex-row ">
                            <input type="text" class="form-control flex-grow-1"  v-model="individualSize.size">
                            <button
                                @click="wrapWithinProcess(()=>saveIndividualSize(individualSize,index))"
                                class="btn btn-success btn-sm rounded-0 " type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                </svg>
                            </button>
                            <button
                                @click="wrapWithinProcess(()=>removeIndividualSize(individualSize,index))"
                                style="margin-left: 5px" class="btn btn-danger btn-sm rounded-0" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </button>
                        </div>

                    </div>
                </template>
            </div>

        </div>
        <div class="bordered d-flex flex-column p-1">
            <h6>Colors</h6>
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between">
                    <span class="fw-semibold">
                        General colors
                    </span>
                    <button
                        @click="wrapWithinProcess(actionsWithColors.saveGlobalColors)"
                        class="btn btn-success btn-sm rounded-0 " type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                        </svg>
                    </button>
                </div>
                <multiselect :values="colors" :showable-key="'name'" :unique-key="'id'"
                             :initial-values="product.colors.global"
                             @selected="actionsWithColors.setGlobalColors"
                />

            </div>
            <hr>
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between w-100">
                    <h6>Individual colors</h6>

                    <button @click="actionsWithColors.addIndividualColor" type="button" class="btn btn-success d-flex justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                    </button>
                </div>
                <template  v-if="product.colors.individual.length">
                    <div class="w-100 d-flex align-items-center mt-2 position-relative border-top"
                         v-for="(color,index) in product.colors.individual"
                         :key="color.id"
                    >
                        <input type="text" class="d-inline-block"
                               style="height:30px;width: 250px;align-self: start "
                               v-model="color.name" placeholder="name"
                        />

                        <label class="position-relative btn btn-secondary btn-sm align-self-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                            </svg>
                            <input type="file"
                                   class="position-absolute d-none"
                                   style="left: 0;right: 0;bottom: 0;top: 0"
                                   @change="actionsWithColors.handleFileUpload($event,color)"
                            >
                        </label>
                        <div class="flex-grow-1 d-flex justify-content-between align-items-center p-1" >
                            <img class="product_color_image " style="width: 45%;" v-if="color.value"
                                 :id="'individual_color_'+color.id" :src="'/'+color.value"
                            />
                            <div class="position-relative  align-self-start h-100 " style="width: 45%;"
                                 v-if="color.uploaded"
                            >
                                <img class="product_color_image w-100"
                                     :id="'individual_color_uploaded_'+color.id" :src="color.uploaded"
                                />
                                <button class="btn btn-close btn-danger position-absolute bg-danger" style="top: 0;right: 0"
                                    @click="actionsWithColors.removeUploadedFile(color)"
                                >

                                </button>
                            </div>

                        </div>
                        <button
                            @click="wrapWithinProcess(()=>actionsWithColors.saveColorChanges(color,index))"
                            class="btn btn-success btn-sm rounded-0 align-self-start" type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                        </button>
                        <button
                            @click="actionsWithColors.removeColor(color,index)"
                            style="margin-left: 5px" class="btn btn-danger btn-sm rounded-0 align-self-start" type="button"
                            data-toggle="tooltip" data-placement="top" title="Delete"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                        </button>
                    </div>
                </template>
                <template v-else>
                    <h6 class="text-center text-info">
                        Product does not have individual colors
                    </h6>
                </template>

            </div>

        </div>
    </div>
</template>

<script>
import processWrappes from "../../../../Mixins/processWrappes";
import Multiselect from "../../../../SharedComponents/ReusableComponents/Multiselect.vue";
export default {
    name: "EditTagbles",
    mixins:[processWrappes],
    components:{
        Multiselect,
    }
}
</script>
<script setup>
    import {useRoute} from "vue-router";
    import {computed, onMounted, reactive, ref} from "vue";
    import HTTP from "../../../Axios/axiosCongif";
    import {errorNotification, successNotification} from "../../../../Services/NotificationService";
    import {extractValidationErrors} from "../../../../Services/GlobalHelpers";


    const route = useRoute()
    const productId = computed(()=>route.params.id);

    const sizes = ref([]);
    const colors = ref([]);
    const tags = ref([]);
    const product = reactive({
        tags:[],
        colors: {
            individual:[],
            global:[],
        },
        sizes:{
            individual:[],
            global:[],
        },
    })
    const saveTags = ()=>{
        const tags = product.tags.map(tg=>tg.id)
        HTTP.post('/product/tagables/tags/'+productId.value,{tags})
        .then(({data})=>{
            if (data.success){
                successNotification('Product tags edited successfully')
            }
        })
        .catch((e)=>errorNotification(extractValidationErrors(e)))
    }
    const saveGeneralSizes = ()=>{
        const sizes = product.sizes.global.map(tg=>tg.id)
        HTTP.post('/product/tagables/sizes/general/'+productId.value,{sizes})
            .then(({data})=>{
                if (data.success){
                    successNotification('Product`s global sizes edited successfully')
                }
            })
            .catch((e)=>errorNotification(extractValidationErrors(e)))
    }
    const setProductsTags = (tags)=>{
        product.tags = tags
    }
    const addIndividualSize = ()=>{
        product.sizes.individual.push({
            id:Date.now() + Math.round(Math.random() * 45),
            added:true,
            size:''
        })
    }

    const removeIndividualSize = (size,index)=>{
        if (size?.added){
            product.sizes.individual.splice(index,1)
            return;
        }
        HTTP.delete(`/product/tagables/sizes/individual/${productId.value}/${size.id}`)
        .then((response)=>{
            if (response.status === 204){
                product.sizes.individual.splice(index,1)
                successNotification('Products individual size removed successfully')
            }
        })
        .catch(e=>errorNotification(extractValidationErrors(e)))

    }

    const saveIndividualSize = (size,index) =>{
        if (size?.added){
            HTTP.post(`/product/tagables/sizes/individual/${productId.value}`,{size:size.size})
            .then(({data})=>{
                if (data.success){
                    product.sizes.individual[index]=data.size
                    successNotification('Product`s individual size created successfully')
                }
            })
            .catch(e=>errorNotification(extractValidationErrors(e)))
            return;
        }

        if (!size?.added){
            HTTP.post(`/product/tagables/sizes/individual/${productId.value}/${size.id}`,{size:size.size})
                .then(({data})=>{
                    if (data.success){
                        product.sizes.individual[index]=data.size
                        successNotification('Product`s individual size updated successfully')
                    }
                })
                .catch(e=>errorNotification(extractValidationErrors(e)))
        }
    }
    const setProductGlobalSizes = (sizes)=>{
        product.sizes.global = sizes
    }
    const seperateIndividuals = (values)=>{
        const Inidividuals = values.filter((vl)=>vl.type === 'individual')
        const Global = values.filter((vl)=>vl.type === 'global')
        return [Inidividuals,Global];
    }

    const seperateDatasAndSet=(key,value)=>{
        const [inidivudal,global]=seperateIndividuals(value)
        product[key].individual = inidivudal
        product[key].global = global
    }

    const actionsWithColors ={
        setGlobalColors:(colors)=>{
            product.colors.global = colors
        },
        saveGlobalColors:()=>{
            const colors = product.colors.global.map(tg=>tg.id)
            HTTP.post('/product/tagables/colors/general/'+productId.value,{colors})
                .then(({data})=>{
                    if (data.success){
                        successNotification('Product`s global colors edited successfully')
                    }
                })
                .catch((e)=>errorNotification(extractValidationErrors(e)))
        },
        addIndividualColor:()=>{
            product.colors.individual.push({
                id:Date.now() + Math.round(Math.random() * 2456),
                name:'',
                value:'',
                added:true
            })
        },
        getFileUrl(file,FileReader){
            return new Promise((resolve => {
                FileReader.onload= ()=>{
                    resolve(FileReader.result)
                }
                FileReader.readAsDataURL(file)
            }))
        },
        handleFileUpload(e,color){
            const file = e.target.files[0]
            color.uploadedFile = file
            this.getFileUrl(file,new FileReader())
                .then((url)=>{
                color.uploaded = url
            })
        },
        removeUploadedFile(color){
            color.uploaded = null;
            color.uploadedFile = null;
        },
        removeColor(color,index){
            if (color.added){
                product.colors.individual.splice(index,1);
                successNotification('Colored removed successfully');
                return;
            }
            HTTP.delete(`/product/tagables/colors/individual/${productId.value}/${color.id}`)
            .then((response)=>{
                if (response.status === 204){
                    product.colors.individual.splice(index,1);
                    successNotification('Products individual color removed successfully')
                }
            }).catch(e=>errorNotification(extractValidationErrors(e)))
        },
        saveColorChanges(color,index){
            let url=`/product/tagables/colors/individual/${productId.value}`
            if (!color?.added){
                url+='/'+color.id
            }
           let data = new FormData
            data.append('name',color.name)
            if (color?.uploadedFile){
                data.append('value',color.uploadedFile )
            }
            HTTP.post(url,data).then(({data})=>{
                if (data.success){
                    product.colors.individual[index]=data.color
                    successNotification('Individual Color modified successfully')
                }
            }).catch((e)=>errorNotification(extractValidationErrors(e)))
        }
    }

    const getTagables = () =>{
        HTTP.get('/product/tagables/'+productId.value)
        .then(({data})=>{
            sizes.value = data.sizes
            colors.value = data.colors
            tags.value = data.tags
            product.tags = data.product.tags
            seperateDatasAndSet('colors',data.product.colors)
            seperateDatasAndSet('sizes',data.product.sizes)
        })
    }

    onMounted(getTagables)

</script>

<style scoped>
.bordered{
    border: 2px solid #1a202c;
}
.product_color_image{
    width: 250px;
}

</style>
