<template>
    <div class=" w-100">
        <button class="btn btn-light  border-top  border-left border-right text-dark w-100" type="button" @click="toggleManu">
            {{ selectButtonText }}
        </button>
        <ul v-if="menuOpened" class=" w-100 list" >
            <li v-for="(value,index) in values"
                @click="selectValue(value)"
                style="margin-top: 2px"
                class="d-flex flex-row justify-content-between p-1  pointer"
                :class="{active:itemIsSelected(value)}"
                :key="uniqueKey ? uniqueKey : index">
                <span  class="dropdown-item" >
                    {{ showableKey ? value[showableKey] : value }}
                </span>
                <button v-if="selectedValues.includes(value)" type="button" class="btn-close" aria-label="Close"></button>
            </li>
        </ul>
    </div>
</template>

<script>
import {computed,  ref, watch, watchEffect} from "vue";

export default {
    name: "Multiselect",
    props:{
        values:Array,
        showableKey:String,
        uniqueKey:String,
        initialValues:Array
    },
    setup(props,ctx){
        const selectedValues=ref([]);
        const menuOpened=ref(false)
        const toggleManu=()=>menuOpened.value=!menuOpened.value
        const initialValuesReceived = ref(false)
        const itemIsSelected = (item) =>{
            if (props.uniqueKey){
                return selectedValues.value.some((it)=>it[props.uniqueKey] === item[props.uniqueKey])
            }
            return selectedValues.value.includes(item)
        }
        const selectValue = (value) => {
          if (itemIsSelected(value)){
              let index=selectedValues.value.findIndex((vl)=>{
                  if (props.uniqueKey){
                      return  vl[props.uniqueKey] === value[props.uniqueKey]
                  }
                  return JSON.stringify(vl) === JSON.stringify(value)
              })
              if (index === -1){
                  return;
              }
              selectedValues.value.splice(index,1)
              return;
          }
          selectedValues.value.push(value)
        }
        const selectButtonText=computed(()=>{
            if (!selectedValues.value.length){
               return  "Pick some"
            }
            return selectedValues.value.map((value,index)=>{
                if (index === selectedValues.value.length-1){
                    if (props.showableKey){
                        return value[props.showableKey] ;
                    }
                    return value;
                }
                if (props.showableKey){
                    return value[props.showableKey] + ', '
                }
                return value + ', ';
            }).join('')
        })
        watch(()=>[...selectedValues.value],(value)=>{
            ctx.emit('selected',value)
        })
        watchEffect(()=>{
            if (props.initialValues.length && !initialValuesReceived.value){
                initialValuesReceived.value = true
                selectedValues.value = props.initialValues
            }
        })

        return {
            selectValue,
            selectedValues,
            selectButtonText,
            menuOpened,
            toggleManu,
            itemIsSelected
        }
    }
}
</script>

<style scoped>
.pointer{
    cursor: pointer;
}
.list{
    background-color: #c6c7c8;
    border: 1px solid black;
    border-radius: 0 0 12px 12px;
    border-top: none;
    padding-left: 0;
    overflow: hidden;
}
.list li {
    padding-left: 10px !important;
}

.active{
    background-color: #00b517;
}

</style>
