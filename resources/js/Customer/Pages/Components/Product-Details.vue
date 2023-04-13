<template>
    <product-details ref="productPage" :key="key">
        <template v-slot:inquiry>
            <div class="d-flex flex-column gap-1 flex-grow-1 align-items-center">
                <div class="send_inquiry " style="width: 80%">
                    <div class="send_inquiry_button pointer"
                         @click.stop="chooseAction(ACTION_SEND_INQUIRY)"
                    >
                        Send inquiry
                    </div>
                </div>
                <div class="send_inquiry " style="width: 80%">
                    <div class="send_inquiry_button pointer"
                        @click.stop="chooseAction(ACTION_LEAVE_COMMENT)"
                    >
                        Leave comment
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:product_yo_may_like="{likables}">
            <section class="prods_you_may_like">

                <h6>Products you may like</h6>

                <div class="prods">
                    <template v-for="likableProd in likables" :key="likableProd.id">
                        <router-link :to="{name: PRODUCT_DETAIL_PAGE,params: {id:likableProd.id}}"
                            class="single_prod"
                        >
                            <template v-if="likableProd.general_file.type === 'image'">
                                <img :src="'/'+likableProd.general_file.path" alt="">
                            </template>
                            <template v-if="likableProd.general_file.type === 'video'">
                                <video :src="'/'+likableProd.general_file.path" autoplay ></video>
                            </template>
                            <div class="d-flex flex-column justify-content-evenly">
                                <span class="single_prod_text">{{ likableProd.name }}</span>
                                <span class="single_prod_price">${{ likableProd.price_for_one.price }}</span>
                            </div>
                        </router-link>
                    </template>
                </div>
            </section>
        </template>
        <template v-slot:related_product="{relatedProducts}">
            <div class="related_products">
                <h6>Related products</h6>
                <div class="d-flex w-100 related_products_wrapper">
                    <template v-for="prod in relatedProducts" :key="prod.id">
                        <router-link :to="{name:PRODUCT_DETAIL_PAGE,params:{id:prod.id}}"
                                     class="one_related_product"

                        >
                            <template v-if="prod.general_file.type === 'image'">
                                <img :src="'/'+prod.general_file.path" alt="">
                            </template>
                            <template v-if="prod.general_file.type === 'video'">
                                <video :src="'/'+prod.general_file.path" autoplay ></video>
                            </template>
                            <span class="related_product_text">{{ prod.name }}</span>
                            <span class="related_product_price">$ {{ prod.price_for_one.price }}</span>
                        </router-link>
                    </template>

                </div>
            </div>
        </template>
    </product-details>

    <teleport to="#app">
        <Modal v-if="chosenAction" @close="chosenAction=''">
            <leave-comment
                v-if="chosenAction===ACTION_LEAVE_COMMENT"
                @close="registerNewComment"
            />
            <send-inquiry
                :product="product"
                v-if="chosenAction===ACTION_SEND_INQUIRY"
                @close="chooseAction('')"
            />
        </Modal>
    </teleport>
</template>

<script>
import Modal from "../../../SharedComponents/ReusableComponents/Modal.vue";
import ProductDetails from "../../../SharedComponents/Product/ProductDetails.vue";
import LeaveComment from "./Popups/LeaveComment.vue";
import SendInquiry from "./Popups/SendInquiry.vue";
export default {
    name: "Product-Details",
    components: {ProductDetails,LeaveComment,Modal,SendInquiry}
}
</script>
<script setup>
import {computed, nextTick, onMounted, ref, watch} from "vue";
import {PRODUCT_DETAIL_PAGE} from "../../../router/Customer/customerRoutes";
import useComponentReloader from "../../../Admin/Composables/useComponentReloader";
import {useRoute} from "vue-router";
    const {key,reloadComponent}=useComponentReloader()
    const productPage=ref(null)
    const emit=defineEmits(['loaded'])
    const ACTION_LEAVE_COMMENT='leave.comment';
    const ACTION_SEND_INQUIRY='send.inquiry';
    const product = computed(()=>productPage.value.product)
    const chosenAction = ref('')
    const chooseAction = (action) => chosenAction.value=action

    const registerNewComment=(comment)=>{
        let productComments=productPage.value.product.comments;
        if (productComments && Array.isArray(productComments)){
            productComments.push(comment);
            chooseAction('')
            return;
        }
        productComments=[comment]
        chooseAction('')
    }
    const route=useRoute()
    const ProductId=computed(()=>route.params.id)
    watch(()=>ProductId.value,reloadComponent)
    onMounted(()=>{
        nextTick(()=>emit('loaded'))
    })




</script>

<style scoped>
.pointer{
    cursor: pointer;
}
</style>
