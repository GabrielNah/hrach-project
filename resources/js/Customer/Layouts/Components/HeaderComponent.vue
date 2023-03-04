<template>
    <header class="section-header">
        <div class="container">
            <nav class="navbar navbar-main navbar-expand pl-0">
                <ul class="navbar-nav flex-wrap">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <hr>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"> Demo pages </a>
                        <div class="dropdown-menu dropdown-large">
                            <nav class="row">
                                <div class="col-6">
                                    <a href="page-index-1.html">Home page 1</a>
                                    <a href="page-index-2.html">Home page 2</a>
                                    <a href="page-category.html">All category</a>
                                    <a href="page-listing-large.html">Listing list</a>
                                    <a href="page-listing-grid.html">Listing grid</a>
                                    <a href="page-shopping-cart.html">Shopping cart</a>
                                    <a href="page-detail-product.html">Product detail</a>
                                    <a href="page-content.html">Page content</a>
                                    <a href="page-user-login.html">Page login</a>
                                    <a href="page-user-register.html">Page register</a>
                                </div>
                                <div class="col-6">
                                    <a href="page-profile-main.html">Profile main</a>
                                    <a href="page-profile-orders.html">Profile orders</a>
                                    <a href="page-profile-seller.html">Profile seller</a>
                                    <a href="page-profile-wishlist.html">Profile wishlist</a>
                                    <a href="page-profile-setting.html">Profile setting</a>
                                    <a href="page-profile-address.html">Profile address</a>
                                    <a href="page-components.html" target="_blank">More components</a>
                                </div>
                            </nav> <!--  row end .// -->
                        </div> <!--  dropdown-menu dropdown-large end.// -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Electronics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Fashion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Beauty</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Motors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Gardening</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Deals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Under $10</a>
                    </li>
                </ul>
            </nav> <!-- navbar-main  .// -->
            <section class="header-main border-bottom">
                <div class="row row-sm">
                    <div class="col-6 col-sm col-md col-lg  flex-grow-0">
                        <a href="http://bootstrap-ecommerce.com" class="brand-wrap">
                            <img class="logo" src="images/logo.svg?v=2.0">
                        </a> <!-- brand-wrap.// -->
                    </div>
                    <div class="col-6 col-sm col-md col-lg flex-md-grow-0">

                        <!-- mobile-only -->
                        <div class="d-md-none float-right">
                            <a href="#" class="btn btn-light"> <i class="fa fa-bell"></i> </a>
                            <a href="#" class="btn btn-light"> <i class="fa fa-user"></i> </a>
                            <a href="#" class="btn btn-light"> <i class="fa fa-shopping-cart"></i> 2 </a>
                        </div>
                        <!-- mobile-only //end  -->

                        <div class="category-wrap  dropdown ">
                            <button type="button" class="btn btn-light dropdown-toggle" id="dropdownShopByMenuButton" data-bs-toggle="dropdown" aria-expanded="false">   Shop by
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownShopByMenuButton">
                                <a class="dropdown-item" href="#">Machinery / Mechanical Parts / Tools </a>
                                <a class="dropdown-item" href="#">Consumer Electronics / Home Appliances </a>
                                <a class="dropdown-item" href="#">Auto / Transportation</a>
                                <a class="dropdown-item" href="#">Apparel / Textiles / Timepieces </a>
                                <a class="dropdown-item" href="#">Home & Garden / Construction / Lights </a>
                                <a class="dropdown-item" href="#">Beauty & Personal Care / Health </a>
                            </div>
                        </div>  <!-- category-wrap.// -->
                    </div> <!-- col.// -->
                    <div class="col-lg-6 col-xl col-md-5 col-sm-12 flex-grow-1">
                        <form action="#" class="search-header">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                        </form> <!-- search-wrap .end// -->
                    </div> <!-- col.// -->
                    <div class="col col-lg col-md flex-grow-0">
                        <button class="btn btn-block btn-primary" type="submit"> Search </button>
                    </div>
                </div> <!-- row.// -->
            </section> <!-- header-main .// -->




        </div> <!-- container.// -->
    </header>
</template>

<script>
export default {
    name: "HeaderComponent"
}
</script>

<style scoped>

</style>
