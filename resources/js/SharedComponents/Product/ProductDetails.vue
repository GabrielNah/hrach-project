<template>
    <main class="main_content" v-if="product">
        <div class="container">
            <nav class="navbar">
                <span class="navbar_text">Home</span>
                <span class="navbar_text arrow"> \ </span>
                <span class="navbar_text"> All categories </span>
                <template v-if="product.category.parentCategory">
                    <span class="navbar_text arrow"> \ </span>
                    <span class="navbar_text"> {{ product.category.parentCategory.name }}</span>
                </template>
                <span class="navbar_text arrow"> \ </span>
                <span class="navbar_text"> {{  product.category.name  }} </span>
            </nav>
            <section class="products_main_info">
                <div class="files_wrapper">
                    <div class="main_image" v-if="files.selected">
                        <template v-if="files.selected.type==='video'">
                            <video :src="'/'+files.selected.path"  controls autoplay muted></video>
                        </template>
                        <template v-if="files.selected.type==='image'">
                            <img :src="'/'+files.selected.path" />
                        </template>
                    </div>
                    <div class="images" v-if="files.all.length">
                        <template v-for="file in files.all">
                            <template v-if="file.type==='video'">
                                <video @click="setSelectedFile(file)" class="single_image"  controls muted autoplay :src="'/'+file.path" ></video>
                            </template>
                            <template v-if="file.type==='image'">
                                <img @click="setSelectedFile(file)" class="single_image" :src="'/'+file.path" />
                            </template>
                        </template>

                    </div>
                </div>
                <div class="product_info">
                    <h3 class="product_name"> {{ product.name }}</h3>
                    <p class="product_data_text">{{ product.title }}</p>
                    <div class="product_rating">
                        <div class="rating d-flex flex-row">
                            <svg v-for="i in 5" fill="none" height="15" viewBox="0 0 16 15" width="16"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path :fill="i <= product.rating ?'#FF9017':'#D5CDC5'" clip-rule="evenodd" d="M8 12.0553L12.944 15L11.632 9.45L16 5.71579L10.248 5.23421L8 0L5.752 5.23421L0 5.71579L4.368 9.45L3.056 15L8 12.0553Z"
                                      fill-rule="evenodd"/>
                            </svg>
                        </div>
                        <!--                        <span class="product_data_text" style="font-size: 12px">-->
                        <!--                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">-->
                        <!--                                    <path d="M2.33317 2.33329H15.6665V12.3333H3.30817L2.33317 13.3083V2.33329ZM2.33317 0.666626C1.4165 0.666626 0.674837 1.41663 0.674837 2.33329L0.666504 17.3333L3.99984 14H15.6665C16.5832 14 17.3332 13.25 17.3332 12.3333V2.33329C17.3332 1.41663 16.5832 0.666626 15.6665 0.666626H2.33317ZM3.99984 8.99996H13.9998V10.6666H3.99984V8.99996ZM3.99984 6.49996H13.9998V8.16663H3.99984V6.49996ZM3.99984 3.99996H13.9998V5.66663H3.99984V3.99996Z" fill="#8B96A5"/>-->
                        <!--                            </svg>-->
                        <!--                            45 inquires-->
                        <!--                        </span>-->
                        <!--                        <span class="product_data_text" style="font-size: 12px">-->
                        <!--                            <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">-->
                        <!--                                    <path d="M18.3335 5.90834H14.3418L10.6918 0.441675C10.5335 0.208342 10.2668 0.0916748 10.0002 0.0916748C9.7335 0.0916748 9.46683 0.208342 9.3085 0.450008L5.6585 5.90834H1.66683C1.2085 5.90834 0.833496 6.28334 0.833496 6.74167C0.833496 6.81667 0.841829 6.89167 0.866829 6.96667L2.9835 14.6917C3.17516 15.3917 3.81683 15.9083 4.5835 15.9083H15.4168C16.1835 15.9083 16.8252 15.3917 17.0252 14.6917L19.1418 6.96667L19.1668 6.74167C19.1668 6.28334 18.7918 5.90834 18.3335 5.90834ZM10.0002 2.40834L12.3335 5.90834H7.66683L10.0002 2.40834ZM15.4168 14.2417L4.59183 14.25L2.7585 7.57501H17.2502L15.4168 14.2417ZM10.0002 9.24167C9.0835 9.24167 8.3335 9.99167 8.3335 10.9083C8.3335 11.825 9.0835 12.575 10.0002 12.575C10.9168 12.575 11.6668 11.825 11.6668 10.9083C11.6668 9.99167 10.9168 9.24167 10.0002 9.24167Z" fill="#8B96A5"/>-->
                        <!--                            </svg>-->
                        <!--                            145 sold-->
                        <!--                        </span>-->
                    </div>
                    <div class="prices mt-1">
                        <nav>
                            <div class="nav nav-tabs" id="prices-tab" role="tablist">
                                <button v-for="(prices,currency) in product.prices"
                                        @click="setSelectedCurrency(currency)"
                                        :class="{'active':selectedCurrency === currency}"
                                        class="nav-link ">{{ currency }}
                                </button>
                            </div>
                        </nav>
                        <div class="tab-content" id="prices-tabContent">
                            <div class="tab-pane fade show "  v-for="(prices,currency) in product.prices"
                                 :class="{'active':selectedCurrency === currency}"
                                 v-show="selectedCurrency === currency"
                                 role="tabpanel"  :key="currency">
                                <div class="product-price">
                                    <div class="price-item" v-for="price in prices">
                                        <div class="quality">
                                          {{renderTextForPrices(price)}}
                                        </div>
                                        <div class="price"><span class="">  {{ price.price }}  {{price.currency}} </span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="colors border-top" v-if="product.colors.length">
                        <span class="product_data_text ">Colors </span>
                        <div class="d-flex align-items-center gap-1 mt-1 ">
                            <span v-for="color in product.colors" class="color"
                                  :style="{backgroundColor:color.value}"></span>
                        </div>
                    </div>
                    <div class="sizes border-top" v-if="product.sizes.length">
                        <span class="product_data_text">Sizes </span>
                        <div class="d-flex align-items-center gap-1 mt-1">
                            <span v-for="size in product.sizes" class="size text-center product_data_text">
                                {{ size.size }}
                            </span>
                        </div>
                    </div>
                </div>
                 <slot name="inquiry"/>
            </section>
            <div class="d-flex w-100 justify-content-between">
                <section class="description">
                    <div class="description_tab">
                        <nav>
                            <div id="nav-tab" class="nav nav-tabs" role="tablist">
                                <button id="nav-descripton-tab" aria-controls="nav-home" aria-selected="true"
                                        class="nav-link active" data-bs-target="#nav-description" data-bs-toggle="tab"
                                        role="tab" type="button">Description
                                </button>
                                <button id="nav-comments-tab" aria-controls="nav-profile" aria-selected="false"
                                        class="nav-link" data-bs-target="#nav-comments" data-bs-toggle="tab"
                                        role="tab" type="button">Comments
                                </button>
                                <button  v-if="product.tags.length" id="nav-tags-tab" aria-controls="nav-profile" aria-selected="false"
                                        class="nav-link" data-bs-target="#nav-tags" data-bs-toggle="tab" role="tab"
                                        type="button">Tags
                                </button>
                            </div>
                        </nav>
                        <div id="nav-tabContent" class="tab-content">
                            <div id="nav-description" aria-labelledby="nav-descripton-tab" class="tab-pane fade show active "
                                 role="tabpanel">
                                {{
                                    product.description
                                }}
                            </div>
                            <div id="nav-comments" aria-labelledby="nav-comments-tab" class="tab-pane fade "
                                 role="tabpanel">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda delectus enim esse
                                fugit in maxime officia perspiciatis porro sequi. Culpa cum eius labore laboriosam
                                maiores officiis perspiciatis quas quis sapiente.
                            </div>
                            <div v-if="product.tags.length" id="nav-tags" aria-labelledby="nav-tags-tab" class="tab-pane fade " role="tabpanel">
                                       <div class="card mt-1 p-2" v-for="tag in product.tags" :key="tag.id">

                                           <div class="card-header product_data_text font-weight-bold">
                                               {{ tag.name }}
                                           </div>
                                           <div class="card-body">
                                               <span class="card-text product_data_text font-italic">
                                                   {{ tag.description }}
                                               </span>
                                           </div>

                                       </div>

                            </div>
                        </div>
                    </div>

                    <div class="meta_data">
                        <table>
                            <tr v-for="(value,key) in product.additional">
                                <td class="names">{{ key }}</td>
                                <td class="values">{{ value }}</td>
                            </tr>
                        </table>
                    </div>
                </section>

                <slot name="product_yo_may_like"/>


            </div>

            <slot name="related_product"/>
        </div>
    </main>
</template>

<script>
import ProductCart from "../../Customer/Pages/Components/Product-cart.vue";
import {useRoute} from "vue-router";
import {onMounted, reactive, ref} from "vue";
import useProductModifier from "../../GlobalComposables/useProductModifier";

export default {
    name: "ProductDetails",
    components: {ProductCart},
    setup(props,ctx){
        const route=useRoute();
        const product=ref(null)
        const selectedCurrency=ref('')
        const setSelectedCurrency=(currency)=>{
            selectedCurrency.value=currency
        }

        const files=reactive({
            selected:null,
            all:[]
        })

        const setSelectedFile=(file)=>{
            files.selected=file
        }
        const renderTextForPrices=(price)=>{
            if (price.min_count === price.max_count && price.max_count === 1){
                return 'Min. Order : 1'
            }
            if (!price.max_count){
                return  ' > '+ price.min_count+ 'sets'
            }
            return price.min_count +'-'+ price.max_count + 'sets'
        }
        const productModifier=useProductModifier()
        ctx.expose({product,productModifier})

        onMounted(async ()=>{
            try {
                let {data:{product:neededProduct}}  =  await axios.get('/api/product/'+route.params.id);
                product.value = neededProduct
                setSelectedCurrency(Object.keys(neededProduct.prices)[0])
                setSelectedFile(neededProduct.general_file)
                files.all=[neededProduct.general_file,...neededProduct.non_general_files]
            }catch (e) {

            }

        })


        return {
            product,
            files,
            setSelectedFile,
            selectedCurrency,
            setSelectedCurrency,
            renderTextForPrices
        }
    }
}
</script>

<style lang="scss" >
.main_content {
    background-color: #F8F9FA;
}

.navbar {
    display: flex;
    flex-direction: row;
    gap: 5px;
    align-items: center;
    justify-content: left;
    padding: 20px 0;
}

.navbar_text {

    font-family: 'Inter';
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 24px;
    /* identical to box height, or 150% */

    letter-spacing: -0.2px;

    /* gray-500 */

    color: #8B96A5;
    margin-left: 5px;
}

.send_inquiry {
    width: 25%;
    border: 1px solid #DEE2E7;
    border-radius: 6px;
    padding: 20px 16px;
    border: 1px solid #DEE2E7;
    box-shadow: 0px 1px 2px rgba(56, 56, 56, 0.08);
    border-radius: 6px;
    height: fit-content;

    .send_inquiry_button {
        /* Auto layout */

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 10px 16px;
        gap: 10px;
        width: 100%;
        font-family: 'Inter';
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 19px;
        text-align: center;

        color: #FFFFFF;

        background: linear-gradient(180deg, #127FFF 0%, #0067FF 100%);
        border-radius: 6px;
    }
}

.products_main_info {
    display: flex;
    flex-direction: row;
    background: #FFFFFF;
    padding: 20px 20px;

}

.files_wrapper {
    background: #FFFFFF;
    border: 1px solid #DEE2E7;
    border-radius: 6px;
    padding: 17px 16px;
    display: flex;
    flex-direction: column;
    width: 35%;
}

.main_image {
    width: 335px;
    height: 335px;
    border: 1px solid #DEE2E7;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.main_image img {
    width: 100%;
    max-height: 100%;
}

.main_image video {
    width: 100%;
    max-height: 100%;
}

.images {
    width: 100%;
    overflow: hidden;
    overflow-x: scroll;
    display: flex;
    height: 64px;
    margin-top: 15px;
}

.images::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.images {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}

.images .single_image {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 4px 4px;
    width: 56px;
    height: 56px;
    background: #FFFFFF;
    border: 1px solid #DEE2E7;
    border-radius: 4px;
    margin-left: 8px;
    cursor: pointer;
}

.product_info {
    width: 40%;
    display: flex;
    flex-direction: column;
    padding: 20px 20px;
}

.product_info .product_name {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 600;
    font-size: 20px;
    line-height: 28px;
    /* or 140% */

    letter-spacing: -0.2px;

    color: #1C1C1C;

}

.product_data_text {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 19px;

    /* gray-600 */

    color: #505050;
}

.product_rating {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
    padding: 5px 5px;
}

.prices {
    width: 100%;
    //background: #FFF0DF;
    //display: flex;
    //align-items: center;
    //justify-content: center;
    padding: 0 10px;
    .product-price {
        display: flex;
        //border-top: 1px solid #e6e7eb;
        //border-bottom: 1px solid #e6e7eb;
        padding: 20px 0;
        margin: 10px 0;
        justify-content: space-between;
        width: 100%;

         .price-item {
            width: 25%;
             .quality {
                 font-size: 14px;
                 color: #666;
                 line-height: 20px;
                 overflow: hidden;
                 //text-overflow: ellipsis;
                 white-space: nowrap;
                 text-align: center;
             }
             .price {
                 font-weight: 700;
                 font-size: 18px;
                 color: #333;
                 line-height: 26px;
                 overflow: hidden;
                 //text-overflow: ellipsis;
                 white-space: nowrap;
                 display: flex;
                 flex-direction: column;
                 text-align: center;
             }
        }
    }

    .stolb {
        width: 2px;
        background: #BDC1C8;
        height: 80%;
    }

    .single_price {
        padding: 15px 15px;

        .price {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 600;
            font-size: 18px;
            line-height: 22px;
            /* identical to box height */


            color: #FA3434;
        }

        .sets {
            margin-bottom: 0;
            /* Text-small */

            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            font-size: 13px;
            line-height: 16px;
            /* identical to box height */


            /* base-color/gray-800 */

            color: #606060;
        }
    }
}

.colors {
    width: 100%;
    padding: 15px 15px;
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;

    .color {
        border: 1px solid #DEE2E7;
        width: 40px;
        height: 40px;
        background: red;
    }
}

.sizes {
    width: 100%;
    padding: 15px 15px;
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;

    div .size {
        border: 1px solid #DEE2E7;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
}

.prods_you_may_like {
    background: #FFFFFF;
    padding: 16px 20px;
    /* gray-300

    Borders, dividers
    */
    border: 1px solid #DEE2E7;
    /* shadow/x1 */

    box-shadow: 0px 1px 3px rgba(56, 56, 56, 0.1);
    border-radius: 6px;
    width: 25%;
    margin-top: 20px;
    display: flex;
    flex-direction: column;

    h6 {
        font-family: 'Inter';
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 19px;

        /* base-color/dark */

        color: #1C1C1C;


    }

    .prods {
        margin-top: 10px;
        max-height: 450px;
        overflow: auto;

        .single_prod {
            display: flex;
            flex-direction: row;
            margin-bottom: 10px;

            img {
                width: 70px;
                height: 70px;
                border: 1px solid #E0E0E0;
                border-radius: 6px;
                margin-right: 10px;
            }

            .single_prod_text {
                font-family: 'Inter';
                font-style: normal;
                font-weight: 400;
                font-size: 16px;
                line-height: 24px;
                /* or 150% */

                letter-spacing: -0.2px;

                /* dark */

                color: #1C1C1C;
            }

            .single_prod_price {
                font-family: 'Inter';
                font-style: normal;
                font-weight: 400;
                font-size: 16px;
                line-height: 24px;
                /* identical to box height, or 150% */

                letter-spacing: -0.2px;

                /* gray-500 */

                color: #8B96A5;

            }
        }
    }

    .prods::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .prods {
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
    }
}

.description {
    margin-top: 20px;
    background: #FFFFFF;
    padding: 16px 20px;
    /* gray-300

    Borders, dividers
    */
    border: 1px solid #DEE2E7;
    /* shadow/x1 */

    box-shadow: 0px 1px 3px rgba(56, 56, 56, 0.1);
    border-radius: 6px;
    width: 70%;

    .nav-tabs, .active {
        color: #505050;;
    }

    .tab-content {
        padding: 20px 20px;


        div {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            /* or 150% */

            letter-spacing: -0.2px;

            /* gray-600 */

            color: #505050;
        }
    }

    .meta_data {
        padding: 20px 20px;

        table {
            max-width: 100%;

            .names {

                min-width: 204px;
                background: #EFF2F4;
                font-family: 'Inter';
                font-style: normal;
                font-weight: 400;
                font-size: 16px;
                line-height: 19px;

                /* gray-600 */

                color: #505050;
            }

            .values {
                min-width: 300px;
                font-family: 'Inter';
                font-style: normal;
                font-weight: 400;
                font-size: 16px;
                line-height: 24px;
                /* identical to box height, or 150% */

                letter-spacing: -0.2px;

                /* gray-600 */

                color: #505050;
            }

            td {
                padding: 10px 10px;
                border: 1px solid #E0E7E9;;
            }
        }
    }
}

.related_products {
    margin-bottom: 20px;
    width: 100%;
    margin-top: 20px;
    background: #FFFFFF;
    padding: 16px 20px;
    /* gray-300

    Borders, dividers
    */
    border: 1px solid #DEE2E7;
    /* shadow/x1 */

    box-shadow: 0px 1px 3px rgba(56, 56, 56, 0.1);
    border-radius: 6px;

    h6 {
        font-family: 'Inter';
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 28px;
        /* identical to box height, or 140% */

        letter-spacing: -0.2px;

        /* dark */

        color: #1C1C1C;
    }

    .related_products_wrapper {
        overflow: hidden;
        overflow-x: scroll;
        gap: 15px;

        .one_related_product {
            width: 172px;
            height: 254px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;

            img {
                width: 172px;
                height: 172px;
                border-radius: 4px;
            }

            .related_product_price {
                font-family: 'Inter';
                font-style: normal;
                font-weight: 400;
                font-size: 16px;
                line-height: 19px;

                /* gray-500 */

                color: #8B96A5;
            }

            .related_product_text {
                font-family: 'Inter';
                font-style: normal;
                font-weight: 400;
                font-size: 16px;
                line-height: 19px;

                /* gray-600 */

                color: #505050;
            }
        }
    }

    .related_products_wrapper::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .related_products_wrapper {
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
    }
}
</style>
