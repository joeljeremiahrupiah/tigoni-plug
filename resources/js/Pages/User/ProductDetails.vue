<template>
    <div class="page-wrapper">
        <user-header></user-header>
        <div class="container mt-4">
            <div class="page-content">
                <div class="container">
                    <div class="product-details-top">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-gallery product-gallery-vertical">
                                    <!-- <el-carousel :interval="4000" type="card" height="400px">
                                        <el-carousel-item v-for="product in productStore?.product?.images"
                                            :key="product.id">
                                            <h3 text="2xl" justify="center"></h3>
                                            <img :src="imageLink(product.image_path)" alt=""
                                                style="width: auto;max-width: 1000px;height: auto;max-height:1000px;object-fit: cover;">
                                        </el-carousel-item>
                                    </el-carousel> -->
                                    <Carousel>
                                        <Slide v-for="product in productStore?.product?.images" :key="product.id">
                                            <div class="carousel__item">
                                                <img :src="imageLink(product.image_path)" alt=""
                                                    style="width: auto;max-width: 500px;height: auto;max-height:500px;object-fit: cover;">
                                            </div>
                                        </Slide>

                                        <template #addons>
                                            <Navigation />
                                            <Pagination />
                                        </template>
                                    </Carousel>

                                </div><!-- End .product-gallery -->
                            </div><!-- End .col-md-6 -->

                            <div class="col-md-6">
                                <div class="product-details">
                                    <h1 class="product-title">{{ productStore?.product?.title }}</h1>
                                    <!-- End .product-title -->

                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                        </div><!-- End .ratings -->
                                        <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews
                                            )</a>
                                    </div><!-- End .rating-container -->

                                    <div class="product-price">
                                        ${{ productStore?.product?.price }}
                                    </div><!-- End .product-price -->

                                    <div class="product-content">
                                        <p v-html="productStore?.product?.smallDescription"> </p>
                                    </div><!-- End .product-content -->

                                    <div class="product-details-action d-flex justify-content-between">
                                        <a href="#" class="btn-product" @click.prevent="showContact"><span>Show
                                                Contact</span></a>
                                        <router-link :to="'/chat/' + productStore?.product?.id + '/' + store?.authuser?.id"
                                            class="btn-product"><span>Send a
                                                Message</span></router-link>

                                    </div>

                                    <div class="product-details-footer">
                                        <div class="product-cat">
                                            <span>Category:</span>
                                            <span v-for="(category, index) in productStore?.product?.categories"
                                                :key="category.id">
                                                <a href="#">{{ category.title }}</a>
                                                <span v-if="index < productStore?.product?.categories.length - 1">,</span>
                                            </span>
                                        </div><!-- End .product-cat -->

                                        <div class="social-icons social-icons-sm">
                                            <span class="social-label">Share:</span>
                                            <a :href="productStore?.product?.facebooklink"
                                                class="social-icon social-facebook" title="Facebook" target="_blank"><i
                                                    class="icon-facebook-f"></i></a>
                                            <a :href="productStore?.product?.twitterlink" class="social-icon social-twitter"
                                                title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                            <a :href="productStore?.product?.instagramlink"
                                                class="social-icon social-instagram" title="Instagram" target="_blank"><i
                                                    class="icon-instagram"></i></a>
                                            <a :href="productStore?.product?.youtubelink" class="social-icon social-youtube"
                                                title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                                        </div>
                                    </div><!-- End .product-details-footer -->
                                </div><!-- End .product-details -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-details-top -->

                    <div class="product-details-tab">
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                                    role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab"
                                    role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                                aria-labelledby="product-desc-link">
                                <div class="product-desc-content">
                                    <h3>Product Information</h3>
                                    <p v-html="productStore?.product?.description"></p>

                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->

                            <div class="tab-pane fade" id="product-review-tab" role="tabpanel"
                                aria-labelledby="product-review-link">
                                <div class="reviews">
                                    <h3>Reviews (2)</h3>
                                    <div class="review">
                                        <div class="row no-gutters">
                                            <div class="col-auto">
                                                <h4><a href="#">Samanta J.</a></h4>
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val" style="width: 80%;"></div>
                                                        <!-- End .ratings-val -->
                                                    </div><!-- End .ratings -->
                                                </div><!-- End .rating-container -->
                                                <span class="review-date">6 days ago</span>
                                            </div><!-- End .col -->
                                            <div class="col">
                                                <h4>Good, perfect size</h4>

                                                <div class="review-content">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus cum
                                                        dolores assumenda asperiores facilis porro reprehenderit animi culpa
                                                        atque blanditiis commodi perspiciatis doloremque, possimus,
                                                        explicabo,
                                                        autem fugit beatae quae voluptas!</p>
                                                </div><!-- End .review-content -->

                                                <div class="review-action">
                                                    <a href="#"><i class="icon-thumbs-up"></i>Helpful (2)</a>
                                                    <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                                </div><!-- End .review-action -->
                                            </div><!-- End .col-auto -->
                                        </div><!-- End .row -->
                                    </div><!-- End .review -->

                                    <div class="review">
                                        <div class="row no-gutters">
                                            <div class="col-auto">
                                                <h4><a href="#">John Doe</a></h4>
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val" style="width: 100%;"></div>
                                                        <!-- End .ratings-val -->
                                                    </div><!-- End .ratings -->
                                                </div><!-- End .rating-container -->
                                                <span class="review-date">5 days ago</span>
                                            </div><!-- End .col -->
                                            <div class="col">
                                                <h4>Very good</h4>

                                                <div class="review-content">
                                                    <p>Sed, molestias, tempore? Ex dolor esse iure hic veniam laborum
                                                        blanditiis
                                                        laudantium iste amet. Cum non voluptate eos enim, ab cumque nam,
                                                        modi,
                                                        quas iure illum repellendus, blanditiis perspiciatis beatae!</p>
                                                </div><!-- End .review-content -->

                                                <div class="review-action">
                                                    <a href="#"><i class="icon-thumbs-up"></i>Helpful (0)</a>
                                                    <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                                </div><!-- End .review-action -->
                                            </div><!-- End .col-auto -->
                                        </div><!-- End .row -->
                                    </div><!-- End .review -->
                                </div><!-- End .reviews -->
                            </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .product-details-tab -->

                    <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->

                    <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                        data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                },
                                "1200": {
                                    "items":4,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>

                        <div class="product product-7 text-center" v-for="relatedproduct in productStore.relatedproducts"
                            :key="relatedproduct.id">
                            <figure class="product-media">
                                <!-- <span class="product-label label-out">Out of Stock</span> -->
                                <a href="product.html">
                                    <img :src="imageLink(relatedproduct?.images[0].image_path)" alt="Product image"
                                        class="product-image">
                                </a>

                                <div class="product-action">
                                    <!-- <a href="#" class="btn-product"><span>View Details</span></a> -->
                                    <router-link :to="'/product-details/' + relatedproduct.id"
                                        class="btn-product btn-quickview" title="Quick view"><span>View
                                            Details</span></router-link>
                                </div>
                            </figure>

                            <div class="product-body">
                                <div class="product-cat">
                                    <!-- <a href="#">{{ relatedproduct?.category?.title }}</a> -->
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">{{ relatedproduct?.title }}</a></h3>
                                <!-- End .product-title -->
                                <div class="product-price">
                                    <span class="out-price">${{ relatedproduct?.price }}</span>
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 6 Reviews )</span>
                                </div><!-- End .rating-container -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->

                    </div><!-- End .owl-carousel -->
                </div><!-- End .container -->
            </div>
        </div>
        <user-footer></user-footer>
    </div>
</template>

<script setup>

import UserHeader from '../inc/Header.vue';
import UserFooter from '../inc/Footer.vue';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user.js'
import { useCategoryStore } from '@/stores/category.js'
import { useProductStore } from '@/stores/product.js'

import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel'

import 'vue3-carousel/dist/carousel.css'

const router = useRouter()
const store = useUserStore()
const categoryStore = useCategoryStore()
const productStore = useProductStore()

let route = useRoute()

let currentSlide = ref(0)

let id = route.params.id

let product = ref({})

const imageLink = (name) => {
    return "/storage/" + name
}

const slideTo = (val) => {
    currentSlide.value = val
}

let getProduct = async () => {
    let response = await axios.get(`/get-product/${id}`)
    if (response.status == 200) {
        // product.value = response.data.product
        productStore.product = response.data.product
        productStore.relatedproducts = response.data.relatedproducts
    }
}

let showContact = () => {
    console.log(store?.authuser)
}

onMounted(() => {
    getProduct()
})

</script>