<template>
    <div class="page-wrapper">
        <user-header></user-header>
        <main class="main pl-5 pr-5 pt-5">

            <div class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="toolbox">
                                <div class="toolbox-left">
                                    <div class="toolbox-info">
                                        Showing <span>9 of 56</span> Products
                                    </div>
                                </div>

                                <div class="toolbox-right">
                                    <div class="toolbox-sort">
                                        <label for="sortby">Sort by:</label>
                                        <div class="select-custom">
                                            <select name="sortby" id="sortby" class="form-control">
                                                <option value="popularity" selected="selected">Most Popular</option>
                                                <option value="rating">Most Rated</option>
                                                <option value="date">Date</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="products mb-3" :key="productStore.rerendershoppage">
                                <div class="row justify-content-left">

                                    <div class="col-4" v-for="product in productStore.filteredproducts" :key="product.id">
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
                                                <span class="product-label label-new"
                                                    v-show="product.paid == 'yes'">Sponsored</span>
                                                <router-link :to="'/product-details/' + product.id">
                                                    <img :src="productImage(product?.images[0]?.image_path)"
                                                        alt="Product image" class="product-image"
                                                        style="width: auto;max-width: 350px;height:auto;max-height:310px;align-items: center;">
                                                </router-link>

                                                <div class="product-action">
                                                    <router-link :to="'/product-details/' + product.id"
                                                        class="btn-product"><span>View Details</span></router-link>
                                                </div>
                                            </figure>

                                            <div class="product-body">
                                                <div class="product-cat">
                                                    <router-link :to="'/product-details/' + product.id">{{ product.title
                                                    }}</router-link>
                                                </div>
                                                <h3 class="product-title"><router-link
                                                        :to="'/product-details/' + product.id"
                                                        v-html="product.smallDescription"></router-link>
                                                </h3>
                                                <div class="product-price">
                                                    Kes{{ product.price }}
                                                </div>
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val" style="width: 20%;"></div>
                                                    </div>
                                                    <span class="ratings-text">( 2 Reviews )</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>


                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1"
                                            aria-disabled="true">
                                            <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                        </a>
                                    </li>
                                    <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item-total">of 6</li>
                                    <li class="page-item">
                                        <a class="page-link page-link-next" href="#" aria-label="Next">
                                            Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <aside class="col-lg-3 order-lg-first">
                            <div class="sidebar sidebar-shop">
                                <div class="widget widget-clean">
                                    <label>Filters:</label>
                                    <a href="#" class="sidebar-filter-clear" @click.prevent="clearFilters">Clear Filters</a>
                                </div>

                                <div class="widget widget-collapsible">
                                    <h3 class="widget-title">
                                        <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true"
                                            aria-controls="widget-1">
                                            Categories
                                        </a>
                                    </h3>

                                    <div class="collapse show" id="widget-1">
                                        <div class="widget-body">
                                            <div class="filter-items filter-items-count">

                                                <el-checkbox-group v-model="form.category_id" class="checkbox-box">
                                                    <el-checkbox v-for="(category, inx) in categoryStore.categories"
                                                        :key="inx" :label="category.id" :value="category.id">
                                                        {{ category.title }}
                                                    </el-checkbox>
                                                </el-checkbox-group>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="widget widget-collapsible">
                                    <h3 class="widget-title">
                                        <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true"
                                            aria-controls="widget-5">
                                            Price Range
                                        </a>
                                    </h3>

                                    <div class="collapse show" id="widget-5">
                                        <div class="widget-body">
                                            <div class="filter-price">
                                                <el-input-number v-model="form.minimum_price" :min="0" :controls="false" />
                                                <el-input-number v-model="form.maximum_price" :min="0" :controls="false" />
                                                <el-button type="success" class="filter-main-button mt-1"
                                                    @click.prevent="filterProducts">Filter</el-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </main>
        <user-footer></user-footer>
    </div>
</template>

<script setup>
import UserHeader from '../inc/Header.vue';
import UserFooter from '../inc/Footer.vue';
import { useRoute } from "vue-router";
import { useCategoryStore } from '@/stores/category.js'
import { useProductStore } from '@/stores/product.js'
import { onMounted, ref, watchEffect } from "vue";

const route = useRoute()
const categoryStore = useCategoryStore()
const productStore = useProductStore()

let productId = route.params.productId
let categoryId = route.params.categoryId

let params = route.params

const hasCategoryId = (params) => params.hasOwnProperty('categoryId');
const hasProductId = (params) => params.hasOwnProperty('productId');

const num = ref(1)

const form = ref({
    category_id: [],
    minimum_price: 0,
    maximum_price: 0
})


const handleChange = (value) => {
    console.log(value)
}

const productImage = (name) => {
    return "/storage/" + name
}

const clearFilters = () => {
    form.value.category_id = []
    form.value.minimum_price = null
    form.value.maximum_price = null
}

const fetchProducts = async () => {
    let requestParams = { productId, categoryId };
    try {
        const response = await axios.post(`/filtered-products/${categoryId}`, requestParams);
        if (response.status === 200) {
            const sortedProducts = Object.values(response.data.sortedProducts).sort((a, b) => {
                return a.id === productId ? -1 : b.id === productId ? 1 : 0;
            });
            productStore.filteredproducts = sortedProducts;
        }
    } catch (error) {
        console.error('Error fetching products', error);
    }
};

const fetchAllProducts = async () => {
    try {
        const response = await axios.post('/fetch-all-products')
        if (response.status === 200) {
            productStore.filteredproducts = response.data.sortedProducts;
        }
    } catch (error) {
        console.error('Error fetching products', error);
    }
}


const filterProducts = async () => {
    const requestParams = {
        category_id: form.value.category_id,
        minimum_price: form.value.minimum_price,
        maximum_price: form.value.maximum_price
    };

    try {
        const response = await axios.post('/filter-all-products', requestParams);
        if (response.status === 200) {
            productStore.filteredproducts = response.data.sortedProducts;
        }
    } catch (error) {
        console.error('Error fetching filtered products', error);
    }
};

const countProducts = (category) => {
    return category?.products.length;
};

onMounted(() => {
    productStore.filteredproducts = null
    if (hasCategoryId(params) || hasProductId(params)) {
        fetchProducts();
    } else {
        fetchAllProducts();
    }
});

</script>

<style scoped>
.product-card {
    width: 100%;
}

.filter-main-button {
    background-color: #8CC63F;
    color: #fff;
    display: block;
    width: 100%;
}

.filter-main-button:focus {
    background-color: #8CC63F;
    color: #fff;
    border: none;
}

.checkbox-box {
    display: flex;
    flex-direction: column;
}

.checkbox-box .el-checkbox {
    margin-bottom: 0;
}

.checkbox-box .el-checkbox {
    margin-bottom: 0;
}
</style>