<template>
    <div class="container d-flex flex-row justify-content-between flex-wrap " style="background: #adb5bd">
        <loader v-if="!loaded"/>
        <template v-else>
            <section class="border border-dark d-flex flex-column align-items-start p-2 mt-2 w-50">
                <h4 class="text-center w-100 text">Colors</h4>
                <div class="d-flex flex-column justify-content-center w-100 align-items-center">
                    <div class="w-100 d-flex flex-row flex-wrap gap-2 scrollable_table" v-if="colors.length">
                        <table class="table table-dark mt-3">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">value</th>
                                <th scope="col w-20">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-if="colors.length">

                                <tr v-for="(color,index) in colors" :key="color.id">
                                    <th scope="row">{{ index+1 }}</th>
                                    <td>{{ color.name }}</td>
                                    <td>
                                        <div :style="{backgroundColor:color.value}" class="color_display"></div>
                                    </td>
                                    <td class="w-20">
                                        <svg @click="setColorUnderEdition(color)" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class=" pointer bi bi-brush" viewBox="0 0 16 16">
                                            <path d="M15.825.12a.5.5 0 0 1 .132.584c-1.53 3.43-4.743 8.17-7.095 10.64a6.067 6.067 0 0 1-2.373 1.534c-.018.227-.06.538-.16.868-.201.659-.667 1.479-1.708 1.74a8.118 8.118 0 0 1-3.078.132 3.659 3.659 0 0 1-.562-.135 1.382 1.382 0 0 1-.466-.247.714.714 0 0 1-.204-.288.622.622 0 0 1 .004-.443c.095-.245.316-.38.461-.452.394-.197.625-.453.867-.826.095-.144.184-.297.287-.472l.117-.198c.151-.255.326-.54.546-.848.528-.739 1.201-.925 1.746-.896.126.007.243.025.348.048.062-.172.142-.38.238-.608.261-.619.658-1.419 1.187-2.069 2.176-2.67 6.18-6.206 9.117-8.104a.5.5 0 0 1 .596.04zM4.705 11.912a1.23 1.23 0 0 0-.419-.1c-.246-.013-.573.05-.879.479-.197.275-.355.532-.5.777l-.105.177c-.106.181-.213.362-.32.528a3.39 3.39 0 0 1-.76.861c.69.112 1.736.111 2.657-.12.559-.139.843-.569.993-1.06a3.122 3.122 0 0 0 .126-.75l-.793-.792zm1.44.026c.12-.04.277-.1.458-.183a5.068 5.068 0 0 0 1.535-1.1c1.9-1.996 4.412-5.57 6.052-8.631-2.59 1.927-5.566 4.66-7.302 6.792-.442.543-.795 1.243-1.042 1.826-.121.288-.214.54-.275.72v.001l.575.575zm-4.973 3.04.007-.005a.031.031 0 0 1-.007.004zm3.582-3.043.002.001h-.002z"/>
                                        </svg>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h5 class="w-100 text-center mt-2">{{ id ? 'Edit' :'Create' }} Color</h5>
                <form class="form-group d-flex flex-column align-items-start"
                      @submit="handleSubmit">
                    <label  class="form-label">Choose color
                        <input type="color" v-model="value" class="form-control form-control-color" title="Choose your color">
                    </label>
                    <label  class="form-label">Set name of color
                        <input type="text" class="form-control " v-model="name" placeholder="Colors name">
                    </label>
                    <div>
                        <button type="submit" class="btn btn-success">
                           {{ id ? 'Save Changes' : 'Save' }}
                        </button>
                        <template v-if="id">
                            <button @click="deleteColor"  style="margin-left: 10px" class="btn btn-danger " type="button"  title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </button>
                            <button class="btn btn-gray btn-secondary"
                                    @click="resetColorData"
                                    style="margin-left: 10px" type="button">Drop data</button>
                        </template>

                    </div>
                </form>
            </section>
            <section class="border border-dark d-flex flex-column align-items-start justify-content-center p-2 mt-2 w-50">
                    <h4 class="text-center w-100 text">Sizes</h4>
                <div class="w-100 d-flex flex-column align-items-center justify-content-between">
                    <div class="d-flex flex-column justify-content-center w-100 align-items-center">
                        <div class="w-100  scrollable_table" v-if="sizes.length">
                            <table class="table table-dark ">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col w-20">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(size,index) in sizes" :key="size.id">
                                        <th scope="row">{{ index+1 }}</th>
                                        <td>{{ size.size }}</td>
                                        <td class="w-20">
                                            <svg @click="setSizeUnderEdition(size)" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class=" pointer bi bi-brush" viewBox="0 0 16 16">
                                                <path d="M15.825.12a.5.5 0 0 1 .132.584c-1.53 3.43-4.743 8.17-7.095 10.64a6.067 6.067 0 0 1-2.373 1.534c-.018.227-.06.538-.16.868-.201.659-.667 1.479-1.708 1.74a8.118 8.118 0 0 1-3.078.132 3.659 3.659 0 0 1-.562-.135 1.382 1.382 0 0 1-.466-.247.714.714 0 0 1-.204-.288.622.622 0 0 1 .004-.443c.095-.245.316-.38.461-.452.394-.197.625-.453.867-.826.095-.144.184-.297.287-.472l.117-.198c.151-.255.326-.54.546-.848.528-.739 1.201-.925 1.746-.896.126.007.243.025.348.048.062-.172.142-.38.238-.608.261-.619.658-1.419 1.187-2.069 2.176-2.67 6.18-6.206 9.117-8.104a.5.5 0 0 1 .596.04zM4.705 11.912a1.23 1.23 0 0 0-.419-.1c-.246-.013-.573.05-.879.479-.197.275-.355.532-.5.777l-.105.177c-.106.181-.213.362-.32.528a3.39 3.39 0 0 1-.76.861c.69.112 1.736.111 2.657-.12.559-.139.843-.569.993-1.06a3.122 3.122 0 0 0 .126-.75l-.793-.792zm1.44.026c.12-.04.277-.1.458-.183a5.068 5.068 0 0 0 1.535-1.1c1.9-1.996 4.412-5.57 6.052-8.631-2.59 1.927-5.566 4.66-7.302 6.792-.442.543-.795 1.243-1.042 1.826-.121.288-.214.54-.275.72v.001l.575.575zm-4.973 3.04.007-.005a.031.031 0 0 1-.007.004zm3.582-3.043.002.001h-.002z"/>
                                            </svg>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <h5 class="w-100 text-center mt-2">{{ sizeUnderEdition ? 'Edit': 'Create' }} size</h5>
                    <form class="form-group d-flex flex-column align-items-start " @submit="handleSizeModification">
                        <label  class="form-label">Set size
                            <input type="text" class="form-control " v-model="sizeValue" placeholder="Sizes name">
                        </label>
                        <div>
                            <button type="submit" class="btn btn-success">
                                {{ sizeUnderEdition ?  'Save changes':'Save' }}
                            </button>
                            <template v-if="sizeUnderEdition">
                                <button @click="deleteSize" style="margin-left: 10px" class="btn btn-danger " type="button"  title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </button>
                                <button class="btn-secondary btn" style="margin-left: 20px" @click="dropSizeEdition" type="reset">
                                    Drop
                                </button>
                            </template>

                        </div>
                    </form>
                </div>
            </section>
            <section class="w-100 p-20 mt-4 border-secondary d-flex flex-column">
                <div class="w-100 d-flex justify-content-between">
                    <h6 class="text-monospace text-center bg-light p-2 w-75 d-inline-block">Tags</h6>
                    <button type="button" class="btn btn-success " @click="modal.openModal">Create Tag</button>
                </div>
                <table class="table table-dark mt-3">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col w-20">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-if="tag.tags.value.length">

                        <tr v-for="(singleTag,index) in tag.tags.value" :key="singleTag.id">
                            <th scope="row">{{ index+1 }}</th>
                            <td>{{ singleTag.name }}</td>
                            <td>{{ singleTag.description }}</td>
                            <td class="w-20">
                                <svg @click="tag.startEditionOfModal(singleTag,modal.openModal)" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class=" pointer bi bi-brush" viewBox="0 0 16 16">
                                    <path d="M15.825.12a.5.5 0 0 1 .132.584c-1.53 3.43-4.743 8.17-7.095 10.64a6.067 6.067 0 0 1-2.373 1.534c-.018.227-.06.538-.16.868-.201.659-.667 1.479-1.708 1.74a8.118 8.118 0 0 1-3.078.132 3.659 3.659 0 0 1-.562-.135 1.382 1.382 0 0 1-.466-.247.714.714 0 0 1-.204-.288.622.622 0 0 1 .004-.443c.095-.245.316-.38.461-.452.394-.197.625-.453.867-.826.095-.144.184-.297.287-.472l.117-.198c.151-.255.326-.54.546-.848.528-.739 1.201-.925 1.746-.896.126.007.243.025.348.048.062-.172.142-.38.238-.608.261-.619.658-1.419 1.187-2.069 2.176-2.67 6.18-6.206 9.117-8.104a.5.5 0 0 1 .596.04zM4.705 11.912a1.23 1.23 0 0 0-.419-.1c-.246-.013-.573.05-.879.479-.197.275-.355.532-.5.777l-.105.177c-.106.181-.213.362-.32.528a3.39 3.39 0 0 1-.76.861c.69.112 1.736.111 2.657-.12.559-.139.843-.569.993-1.06a3.122 3.122 0 0 0 .126-.75l-.793-.792zm1.44.026c.12-.04.277-.1.458-.183a5.068 5.068 0 0 0 1.535-1.1c1.9-1.996 4.412-5.57 6.052-8.631-2.59 1.927-5.566 4.66-7.302 6.792-.442.543-.795 1.243-1.042 1.826-.121.288-.214.54-.275.72v.001l.575.575zm-4.973 3.04.007-.005a.031.031 0 0 1-.007.004zm3.582-3.043.002.001h-.002z"/>
                                </svg>
                                <svg @click="tag.deleteTag(singleTag)" style="margin-left: 10px" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash pointer" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>

            </section>
        </template>
    </div>
    <teleport to="#app">
        <modal v-if="modal.modalOpened.value" @close="modal.closeModal">
            <form @submit.prevent="tag.tag.id ? tag.editTag(modal.closeModal)  :tag.createTag(modal.closeModal)" class="w-75">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" v-model="tag.tag.name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter tags name">
                    <small id="emailHelp" class="form-text text-muted">Name should be something like  abbreviation </small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Description</label>
                    <textarea v-model="tag.tag.description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="btn-group mt-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-secondary" style="margin-left: 10px" >Drop changes</button>
                </div>
            </form>
        </modal>
    </teleport>
</template>

<script>
import {onMounted, reactive, ref, toRefs} from "vue";
import HTTP from "../Axios/axiosCongif";
import useLoader, {useModal} from "../../GlobalComposables/useLoader";
import Loader from "../../SharedComponents/Loader.vue";
import {errorNotification, successNotification} from "../../Services/NotificationService";
import {extractValidationErrors} from "../../Services/GlobalHelpers";
import useTagsHandler from "../Composables/useTagsHandler";
import Modal from "../../SharedComponents/ReusableComponents/Modal.vue";
export default {
    name: "Settings",
    components: {Loader,Modal},
    setup(){
        const modal=useModal();
        const {loaded,setLoaded}=useLoader()
        const tag=useTagsHandler()
        const sizes=ref([]);
        const colors=ref([]);
        const sizeValue=ref('')
        const colorData=reactive({
            id:0,
            name:'',
            value:'#000000'
        })

        const sizeUnderEdition=ref(null)
        const setSizeUnderEdition = (size) => {
          sizeUnderEdition.value=size
          sizeValue.value=size.size
        }
        const dropSizeEdition = () => {
          sizeUnderEdition.value=null
          sizeValue.value=''
        }
        const setColorUnderEdition=(color)=>{
            colorData.id=color.id
            colorData.value=color.value
            colorData.name=color.name
        }
        const setSizes = (sizeValue) => {
          sizes.value=sizeValue
        }
        const addSize = (size) => {
          sizes.value.push(size)
        }
        const setColors = (colorsValue) => {
          colors.value=colorsValue
        }
        const resetColorData=()=>{
            colorData.id=0
            colorData.name='';
            colorData.value='#000000';
        }
        const addColor=(color)=>{
            colors.value.push({...color})
        }
        const deleteColor =async () => {
            try {
                let response=await HTTP.delete('/settings/color/'+colorData.id)
                if (response.status === 204){
                    let index=colors.value.findIndex(clr=>clr.id === colorData.id)
                    if (index=== -1){
                        return;
                    }
                    colors.value.splice(index,1)
                    resetColorData()
                    successNotification('Color removed successfully')
                }
            }catch (e) {
                console.log(e)
                errorNotification(extractValidationErrors(e))
            }
        }
        const saveColor=async ()=>{
            try {
                let {data}=await HTTP.post('/settings/color',colorData)
                if (data.success){
                    addColor(data.color);
                    resetColorData()
                    successNotification('Color added successfully')
                }
            }catch (e) {
                errorNotification(extractValidationErrors(e))
            }
        }

        const editColor=async ()=>{
            try {
                let {data}=await HTTP.put('/settings/color/'+colorData.id,colorData)
                if (data.success){
                    let selectedColor=colors.value.find((clr)=>clr.id === colorData.id)
                    selectedColor.value=colorData.value
                    selectedColor.name=colorData.name
                    resetColorData()
                    successNotification('Color updated successfully')
                }
            }catch (e) {
                console.log(e)
                errorNotification(extractValidationErrors(e))
            }
        }

        const getSettings=async ()=>{
            try {
                let {data:{colors,sizes,tags}}=await HTTP.get('/settings/all')
                setSizes(sizes)
                setColors(colors)
                tag.setTags(tags)
                setLoaded()
            }catch (e) {
                console.log(e)
            }
        }

        const handleSubmit = async (e) => {
            e.preventDefault()
            if (colorData?.id){
              await  editColor()
                return;
            }
            await saveColor()
        }


        const createSize = async () => {
            try {
                let {data}=await HTTP.post('/settings/size', {size:sizeValue.value})
                if (data.success){
                    dropSizeEdition()
                    addSize(data.size)
                    successNotification('Size added successfully')
                }
            }catch (e) {
                console.log(e)
                errorNotification(extractValidationErrors(e))
            }
        }

        const updateSize=async ()=>{
            try {
                let {data}=await HTTP.put('/settings/size/'+sizeUnderEdition.value.id, {size:sizeValue.value})
                if (data.success){
                    let size=sizes.value.find((sz)=>sz.id === sizeUnderEdition.value.id)
                    if (!size){
                        throw new Error('Something went wrong,refresh page and try again')
                    }
                    size.size=sizeValue.value
                    dropSizeEdition()
                    successNotification('Size updated successfully')
                }
            }catch (e) {
                console.log(e)
                errorNotification(extractValidationErrors(e))
            }
        }

        const deleteSize =async () => {
            try {
                let response=await HTTP.delete('/settings/size/'+sizeUnderEdition.value.id)
                if (response.status === 204){
                    let index=sizes.value.findIndex(clr=>clr.id === sizeUnderEdition.value.id)
                    if (index=== -1){
                        return;
                    }
                    sizes.value.splice(index,1)
                    dropSizeEdition()
                    successNotification('Size removed successfully')
                }
            }catch (e) {
                console.log(e)
                errorNotification(extractValidationErrors(e))
            }
        }

        const handleSizeModification=async (e)=>{
            e.preventDefault();
            if (sizeUnderEdition.value){
               await updateSize();
                return;
            }
            await createSize()
        }

        onMounted(()=>getSettings())

        return{
            sizes,
            colors,
            loaded,
            ...toRefs(colorData),
            setColorUnderEdition,
            resetColorData,
            handleSubmit,
            deleteColor,
            sizeValue,
            sizeUnderEdition,
            dropSizeEdition,
            handleSizeModification,
            setSizeUnderEdition,
            deleteSize,
            tag,
            modal
        }
    },
}
</script>

<style scoped>
.color_display{
    width: 50px;
    height: 50px;
}
.pointer {
    cursor: pointer;
}

.scrollable_table{
    height: 300px;
    overflow: hidden;
    overflow-y: auto;
}
.scrollable_table::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.scrollable_table {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}
</style>
