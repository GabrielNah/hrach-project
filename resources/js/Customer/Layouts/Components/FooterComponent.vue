<template>
    <footer class="section-footer bg-secondary text-white">
        <div class="container">
            <section class="footer-top  padding-y-lg">
                <div class="d-flex w-100 justify-content-between">
                    <aside class="col-md-4 col-12">
                        <article class="mr-md-4">
                            <h5 class="title">Contact us</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer in feugiat lorem. </p>
                            <ul class="list-icon">
                                <li> <i class="icon fa fa-map-marker"> </i>542 Fake Street, Cityname 10021 Netheerlends </li>
                                <li> <i class="icon fa fa-envelope"> </i> info@example.com</li>
                                <li> <i class="icon fa fa-phone"> </i> (800) 060-0730, (800) 060-0730</li>
                                <li> <i class="icon fa fa-clock"> </i>Mon-Sat 10:00pm - 7:00pm</li>
                            </ul>
                        </article>
                    </aside>
                    <aside class="col-md-4 col-12">
                        <h5 class="title">Newsletter</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer in feugiat lorem. </p>

                        <form class="form-inline mb-3 d-flex w-100">
                            <input type="text" placeholder="Email" class="border-0 w-auto form-control" name="">
                            <button class="btn ml-2 btn-warning"> Subscribe</button>
                        </form>

                        <p class="text-white-50 mb-2">Follow us on social media</p>
                        <div>
                            <a href="#" class="btn btn-icon btn-outline-light"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-icon btn-outline-light"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-icon btn-outline-light"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-icon btn-outline-light"><i class="fab fa-youtube"></i></a>
                        </div>

                    </aside>
                </div> <!-- row.// -->
            </section>	<!-- footer-top.// -->

        </div><!-- //container -->
    </footer>
</template>

<script>
export default {
    name: "FooterComponent"
}
</script>

<style scoped>
footer{
    background: #12225B !important;
    box-shadow: 0px 0px 3px;
}
</style>
