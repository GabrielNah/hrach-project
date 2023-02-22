<template>
    <section class="padding-bottom">
        <div class="d-flex flex-row justify-content-around align-items-center flex-wrap w-100 ">
            <div class="col-5 mb-3" v-for="i in 3">
                <div class="card card-banner-lg bg-dark">
                    <img src="images/banners/slide3.webp" class="card-img opacity">
                    <div class="card-img-overlay text-white">
                        <h2 class="card-title">Big Deal on Clothes</h2>
                        <p class="card-text" style="max-width: 80%">This is a wider card with text below and Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo ab quae nihil praesentium impedit libero possimus id vero</p>
                        <a href="#" class="btn btn-light">Discover</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "BannersComponent"
}
</script>

<style scoped>
.product-item{
    background: #FFFFFF;
    border: 1px solid #EBECF0;
    box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.25);
    border-radius: 15px;
}
</style>
