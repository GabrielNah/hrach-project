<template>
    <div class="d-flex flex-column w-100 gap-1">
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
                            <button class="btn btn-success btn-sm rounded-0 " type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                </svg>
                            </button>
                            <button
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
        <div class="bordered d-flex flex-column">

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
    const productId = computed(()=>route.params.id);

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
</style>
