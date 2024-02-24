<template>
    <footer class="footer">
        <div class="cta cta-horizontal cta-horizontal-box bg-dark bg-image"
            style="background-image: url('/public/frontend/assets/images/demos/demo-14/bg-1.jpg');">

            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-xl-8 offset-xl-2">
                        <div class="row align-items-center">
                            <div class="col-lg-5 cta-txt">
                                <h3 class="cta-title text-primary">Join Our Newsletter</h3><!-- End .cta-title -->
                                <p class="cta-desc text-light">Subcribe to get information about services
                                </p><!-- End .cta-desc -->
                            </div><!-- End .col-lg-5 -->

                            <div class="col-lg-7">
                                <form action="#">
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="Enter your Email Address"
                                            aria-label="Email Adress" required>
                                        <div class="input-group-append">
                                            <button class="btn" type="submit">Subscribe</button>
                                        </div><!-- .End .input-group-append -->
                                    </div><!-- .End .input-group -->
                                </form>
                            </div><!-- End .col-lg-7 -->
                        </div><!-- End .row -->
                    </div><!-- End .col-xl-8 offset-2 -->
                </div><!-- End .row -->
            </div><!-- End .container-fluid -->
        </div><!-- End .cta -->
        <div class="footer-middle border-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="widget widget-about">
                            <!-- <img src="/public/frontend/assets/images/demos/demo-14/logo-footer.png" class="footer-logo"
                                alt="Footer Logo" width="105" height="25"> -->
                            <img src="/public/frontend/assets/images/tigoni-plug.png" alt="Molla Logo"
                                style="width:auto;height:auto;max-width:150px;">
                            <p>Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, eu vulputate magna
                                eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor,
                                facilisis luctus, metus. </p>

                            <div class="widget-about-info">
                                <div class="row">
                                    <div class="col-sm-6 col-md-8">
                                        <span class="widget-about-title">Payment Methods</span>
                                        <figure class="footer-payments">
                                            <img src="/public/frontend/assets/images/payments.png" alt="Payment methods"
                                                width="272" height="20">
                                        </figure><!-- End .footer-payments -->
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .widget-about-info -->
                        </div><!-- End .widget about-widget -->
                    </div><!-- End .col-sm-12 col-lg-4 -->

                    <div class="col-md-4 text-center">
                        <div class="widget">
                            <h4 class="widget-title">Useful Links</h4><!-- End .widget-title -->

                            <ul class="widget-list">
                                <li><a href="#">About The Tigoni Plug</a></li>
                                <li><a href="#">How to shop on The Tigoni Plug</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Contact us</a></li>
                            </ul><!-- End .widget-list -->
                        </div><!-- End .widget -->
                    </div><!-- End .col-sm-4 col-lg-2 -->

                    <div class="col-md-4 text-center">
                        <div class="widget">
                            <h4 class="widget-title">Customer Service</h4><!-- End .widget-title -->

                            <ul class="widget-list">
                                <li><a href="#">Payment Methods</a></li>
                                <li><a href="#">Returns</a></li>
                                <li><a href="#">Shipping</a></li>
                                <li><a href="#">Terms and conditions</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                            </ul><!-- End .widget-list -->
                        </div><!-- End .widget -->
                    </div><!-- End .col-sm-4 col-lg-2 -->

                </div><!-- End .row -->
            </div><!-- End .container-fluid -->
        </div><!-- End .footer-middle -->

        <div class="footer-bottom">
            <div class="container-fluid">
                <p class="footer-copyright">Copyright © {{ currentYear }} The Tigoni Plug. All Rights Reserved.</p>
                <!-- End .footer-copyright -->
                <div class="social-icons social-icons-color">
                    <span class="social-label">Social Media</span>
                    <a :href="store?.admindetails?.facebooklink" class="social-icon social-facebook" title="Facebook"
                        target="_blank"><i class="icon-facebook-f"></i></a>
                    <a :href="store?.admindetails?.twitterlink" class="social-icon social-twitter" title="Twitter"
                        target="_blank"><i class="icon-twitter"></i></a>
                    <a :href="store?.admindetails?.instagramlink" class="social-icon social-instagram" title="Instagram"
                        target="_blank"><i class="icon-instagram"></i></a>
                    <a :href="store?.admindetails?.youtubelink" class="social-icon social-youtube" title="Youtube"
                        target="_blank"><i class="icon-youtube"></i></a>
                </div><!-- End .soial-icons -->
            </div><!-- End .container-fluid -->
        </div><!-- End .footer-bottom -->
    </footer><!-- End .footer -->
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user.js'
import { useCategoryStore } from '@/stores/category.js'
import { useProductStore } from '@/stores/product.js'

const router = useRouter()
const store = useUserStore()
const categoryStore = useCategoryStore()
const productStore = useProductStore()

const currentYear = new Date().getFullYear();



</script>
