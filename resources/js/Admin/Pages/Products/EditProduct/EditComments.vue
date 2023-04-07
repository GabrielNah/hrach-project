<template>

    <div class="w-100 d-flex flex-column gap-1">
        <h3 class="bg-dark text-white text-center w-100">Products comments</h3>
        <div class="d-flex justify-content-between p-2 w-100">
            <div class="comment_slider  " style="background: #bbc0c8;width: 55%">
                <template v-if="comments.length">
                    <div class="d-flex flex-column w-100 justify-content-center align-items-center overflow-auto" style="height: 500px">
                        <div class="d-flex flex-column comment-container " v-for="(comment,index) in comments"
                             :key="comment.id"
                          style="width: 90%">
                            <div class="bg-white w-100">
                                <div class="flex-row d-flex w-100">
                                    <div class="d-flex flex-column justify-content-start ml-2 w-100">
                                        <div class="d-flex w-100 justify-content-between">
                                            <span class="d-block font-weight-bold name">
                                                {{ comment.writer }}
                                            </span>
                                            <div class="d-flex gap-2">
                                                        <button @click="actionsWithComments.setCommentUnderEdition(comment)"
                                                            class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button
                                                            @click="wrapWithinProcess(()=>actionsWithComments.DELETE(comment,index))"
                                                            class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                            </svg>
                                                        </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mt-2" >
                                    <svg v-for="i in 5" fill="none" height="15" viewBox="0 0 16 15" width="16"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path :fill="i <= comment.rating ?'#FF9017':'#D5CDC5'" clip-rule="evenodd" d="M8 12.0553L12.944 15L11.632 9.45L16 5.71579L10.248 5.23421L8 0L5.752 5.23421L0 5.71579L4.368 9.45L3.056 15L8 12.0553Z"
                                              fill-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="mt-3">
                                    <p class="comment-text">
                                        {{ comment.review }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <h3 class="text-center">
                        Product does not have comments yet
                    </h3>
                </template>
            </div>
            <div style="width: 40%" class="d-flex justify-content-center align-items-center">
                <form class="w-75"
                    @submit.prevent="wrapWithinProcess(actionsWithComments.UPDATE_OR_CREATE)"
                >
                    <div class="form-group">
                        <label> Username </label>
                        <input type="text" class="form-control"
                               v-model="commentUnderEdition.username"
                               placeholder="Product name"
                        >
                    </div>
                    <div class="form-group">
                        <label> Rating </label>
                        <div class="d-flex align-items-center" style="padding-left: 5px">
                            <svg v-for="i in 5" fill="none" height="15" viewBox="0 0 16 15" width="16"
                                 @click="setRating(i)"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path :fill="i <= commentUnderEdition.rating ?'#FF9017':'#D5CDC5'" clip-rule="evenodd" d="M8 12.0553L12.944 15L11.632 9.45L16 5.71579L10.248 5.23421L8 0L5.752 5.23421L0 5.71579L4.368 9.45L3.056 15L8 12.0553Z"
                                      fill-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="form-group">
                        <label >Description</label>
                        <textarea class="form-control"
                                  rows="7" style="resize: none"
                                  v-model="commentUnderEdition.comment"
                        >
                        </textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" v-model="commentUnderEdition.active" role="switch" id="flexSwitchCheckChecked" checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked">Is Active</label>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-1 gap-1">
                        <button class="btn btn-primary" type="submit">Save </button>
                        <button class="btn btn-secondary" type="button"
                                @click="actionsWithComments.dropFromData">
                            Drop
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>



</template>

<script>
import processWrappes from "../../../../Mixins/processWrappes";

export default {
    name: "EditComments",
    mixins:[processWrappes]
}
</script>
<script setup>
    import {useRoute} from "vue-router";
    import {computed, onMounted, reactive, ref} from "vue";
    import HTTP from "../../../Axios/axiosCongif";
    import {errorNotification, successNotification} from "../../../../Services/NotificationService";
    import {extractValidationErrors} from "../../../../Services/GlobalHelpers";

    const route = useRoute()
    const productId = computed(()=>route.params.id)
    const comments = ref([])

    const commentUnderEdition = reactive({
        id:0,
        rating:0,
        username:'',
        comment:'',
        active:false
    })
    const setRating = (rate)=>commentUnderEdition.rating = rate

    const actionsWithComments = {
        UPDATE_OR_CREATE:()=>{
          if (commentUnderEdition.id){
              actionsWithComments.UPDATE()
              return;
          }
          actionsWithComments.CREATE();
        },
        UPDATE:()=>{
            const data={
                active:commentUnderEdition.active,
                username:commentUnderEdition.username,
                comment:commentUnderEdition.comment,
                rate:commentUnderEdition.rating,
            }
            HTTP.put('/comment/'+commentUnderEdition.id,data)
                .then(({data})=>{
                    let commentsIndex =comments.value.findIndex(cm=>cm.id === commentUnderEdition.id)
                    actionsWithComments.dropFromData()
                    if (commentsIndex !== -1){
                        comments.value[commentsIndex] = data.comment
                    }
                    successNotification('Comment updated successfully')
                })
                .catch(e=>errorNotification(extractValidationErrors(e)))
        },
        dropFromData:()=>{
            commentUnderEdition.comment='';
            commentUnderEdition.username='';
            commentUnderEdition.id=0;
            commentUnderEdition.rating=0;
            commentUnderEdition.active=false;
        },
        CREATE:()=>{
            const data={
                active:commentUnderEdition.active,
                username:commentUnderEdition.username,
                comment:commentUnderEdition.comment,
                rate:commentUnderEdition.rating,
            }
            HTTP.post('/comment/'+productId.value,data)
            .then(({data})=>{
                comments.value.push(data.comment)
                actionsWithComments.dropFromData()
                successNotification('Product added successfully')
            })
            .catch(e=>errorNotification(extractValidationErrors(e)))
        },
        setCommentUnderEdition:(comment)=>{
            commentUnderEdition.id=comment.id
            commentUnderEdition.rating=comment.rating
            commentUnderEdition.comment=comment.review
            commentUnderEdition.username=comment.writer
            commentUnderEdition.active=comment.active
         },
        DELETE(comment,index){
            if (!comment.id){
                return;
            }
            HTTP.delete('/comment/'+comment.id)
            .then((res)=>{
                if (res.status === 204 ){
                    comments.value.splice(index,1)
                    successNotification('Comment removed successfully')
                }
            })
            .catch(e=>errorNotification(extractValidationErrors(e)))
        }
    }
    onMounted(()=>{
        HTTP.get('/comment/'+productId.value)
        .then(({data:{comments:cmts}})=>{
            comments.value = cmts
        })
    })

</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700');


body{
    margin: 0px;
    font-family: "Poppins", sans-serif !important;
    background: #FED18C !important;
}

.height-vh{
    height: 100vh;
}

.comment-container{
    padding: 40px !important;
    background: white;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
}

.date{
    font-size: 12px;
}

.comment-text{
    font-size: 14px;
    line-height: 1.2rem;
}

.fs-14{
    font-size: 14px;
}

.name{
    color: #FE654F;
}

.cursor{
    cursor: pointer;
}

.cursor:hover{
    color: blue;
}
</style>
