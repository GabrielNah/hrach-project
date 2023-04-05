<template>
    <div class="d-flex flex-column w-100">
        <div class="w-100 d-flex align-items-center justify-content-between">
            <h4 class="text-white bg-dark text-center ">Product Metadata </h4>

            <div class="d-flex gap-1">
                <button class="btn btn-success btn-sm "
                        @click="wrapWithinProcess(saveChanges)"
                        type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                    </svg>
                </button>
                <button @click="addInfo"  type="button"
                        class="btn btn-success d-flex justify-content-center align-items-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                </button>
            </div>

        </div>
        <template v-if="additionalExists">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">Key </th>
                    <th scope="col">Value </th>
                    <th scope="col">Remove</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(key,index) in additionalKeys" :key="index">
                    <td>
                        <input type="text" :value="key" @input="changeKey($event,index)">
                    </td>
                    <td>
                        <input type="text" :value="additionalValues[index]" @input="changeValue($event,index)">
                    </td>
                    <td>
                        <button
                            @click="removeKeyValuePair(index)"
                            class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </template>
        <template v-else>
            <h4 class="w-100 text-center text-info bg-dark fs-5">No additional info exists yet for this product</h4>
        </template>
    </div>
</template>

<script>
import processWrappes from "../../../../Mixins/processWrappes";

export default {
    name: "EditAdditionalInfo",
    mixins:[processWrappes]
}
</script>
<script setup>
import {useRoute} from "vue-router";
import {computed, onMounted, ref} from "vue";
import HTTP from "../../../Axios/axiosCongif";
import {errorNotification, successNotification} from "../../../../Services/NotificationService";
import {extractValidationErrors} from "../../../../Services/GlobalHelpers";

  const route = useRoute();
  const productId = computed(()=>route.params.id)
  const additionalKeys = ref([])
  const additionalValues = ref([])
  const getProductAdditional =()=>{
        HTTP.get('/product/additional/'+productId.value)
      .then(({data})=>{
          additionalKeys.value = Object.keys(data?.additional ?? {})
          additionalValues.value = Object.values(data?.additional ?? {})
      })
  }

  const changeValue= (e,index)=>{
      additionalValues.value[index]=e.target.value
  }
  const changeKey= (e,index)=>{
      additionalKeys.value[index]=e.target.value
  }

  const addInfo = ()=>{
      additionalKeys.value.push('')
  }
  const removeKeyValuePair = (index) =>{
      additionalKeys.value.splice(index,1)
      additionalValues.value.splice(index,1)
  }

  const saveChanges = ()=>{
      const keys = additionalKeys.value
      const values = additionalValues.value
      HTTP.post('/product/additional/'+productId.value,{keys,values})
      .then(({data})=>{
          additionalKeys.value = Object.keys(data?.metadata ?? {})
          additionalValues.value = Object.values(data?.metadata ?? {})
          successNotification('Metadata of product updated successfully')
      })
      .catch((e)=>errorNotification(extractValidationErrors(e)))
  }
  onMounted(getProductAdditional)

  const additionalExists = computed(()=>Object.keys(additionalKeys.value).length)

</script>

<style lang="css" scoped>
td>input{
    border: none;
    width: 100%;
    outline: none;
}
</style>
