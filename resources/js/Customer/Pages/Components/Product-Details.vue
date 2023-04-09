<template>
    <product-details ref="product">
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
        <template v-slot:product_yo_may_like>
            <section class="prods_you_may_like">

                <h6>Products you may like</h6>

                <div class="prods">
                    <div v-for="i in 15" class="single_prod">
                        <img alt="" src="/images/posts/2.webp">
                        <div class="d-flex flex-column justify-content-evenly">
                            <span class="single_prod_text">Name</span>
                            <span class="single_prod_price">$145.05</span>
                        </div>

                    </div>
                </div>
            </section>
        </template>
        <template v-slot:related_product>
            <div class="related_products">
                <h6>Related products</h6>
                <div class="d-flex w-100 related_products_wrapper">
                    <div v-for="i in 8" class="one_related_product">
                        <img alt="" src="/images/posts/1.webp">
                        <span class="related_product_text">Product name</span>
                        <span class="related_product_price">$32.00-$40.00</span>
                    </div>
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
        </Modal>
    </teleport>
</template>

<script>
import Modal from "../../../SharedComponents/ReusableComponents/Modal.vue";
import ProductDetails from "../../../SharedComponents/Product/ProductDetails.vue";
import LeaveComment from "./Popups/LeaveComment.vue";
export default {
    name: "Product-Details",
    components: {ProductDetails,LeaveComment,Modal}
}
</script>
<script setup>
import {reactive, ref} from "vue";
    const product=ref(null)
    const ACTION_LEAVE_COMMENT='leave.comment';
    const ACTION_SEND_INQUIRY='send.inquiry';

    const chosenAction = ref('')
    const chooseAction = (action) => chosenAction.value=action

    const registerNewComment=(comment)=>{
        let productComments=product.value.product.comments;
        if (productComments && Array.isArray(productComments)){
            productComments.push(comment);
            chooseAction('')
            return;
        }
        productComments=[comment]
        chooseAction('')
    }


</script>

<style scoped>
.pointer{
    cursor: pointer;
}
</style>
