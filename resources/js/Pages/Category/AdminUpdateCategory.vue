<template>
    <div class="page-wrapper">
        <div class="container-xl">
            <div class="az-content-breadcrumb mb-5">
                <span>Components</span>
                <span>UI Elements</span>
                <span>Buttons</span>
            </div>

            <div class="d-flex justify-content-start">
                {{ this.$route.params.id }}
                <div class="az-content-label mg-b-5">Update Products</div>
            </div>

            <div class="d-flex justify-content-end">
                <router-link :to="{ name: 'ProductList' }">
                    <vs-button square> Product List </vs-button>
                </router-link>
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">
                <form @submit.prevent="updateProduct()" enctype="multipart/form-data">
                    <div class="con-form center content-inputs">
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <Input v-model="form.title" placeholder="Input Product Name" />
                            </div>
                            <div class="col-md-6">
                                <Select v-model="form.category_id" filterable multiple placeholder="Select Category">
                                    <Option v-for="category in categories" :label="category.title" :value="category.id"
                                        :key="category.title"></Option>
                                </Select>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <InputNumber class="w-100" v-model="form.price" placeholder="Input Product Price">
                                </InputNumber>
                            </div>
                            <div class="col-md-6">
                                <InputNumber class="w-100" v-model="form.discount" placeholder="Input Product Discount">
                                </InputNumber>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <Input v-model="form.smallDescription" maxlength="255" show-word-limit type="textarea"
                                    placeholder="Input Small Description" />
                            </div>
                            <div class="col-md-6">
                                <Input v-model="form.description" maxlength="255" show-word-limit type="textarea"
                                    placeholder="Input Description" />
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-4">
                                <vs-input class="mb-2" border success type="file" @change="loadImageOne($event)">
                                </vs-input>
                                <span><img :src="fileLinkOne(form.imageOne)" alt=""
                                        style="width: 40px; height: 40px" /></span>
                            </div>
                            <div class="col-md-4">
                                <vs-input class="mb-2" border success type="file" @change="loadImageTwo($event)">
                                </vs-input>
                                <span><img :src="fileLinkTwo(form.imageTwo)" alt=""
                                        style="width: 40px; height: 40px" /></span>
                            </div>
                            <div class="col-md-4">
                                <vs-input class="mb-2" border success type="file" @change="loadImageThree($event)">
                                </vs-input>
                                <span><img :src="fileLinkThree(form.imageThree)" alt=""
                                        style="width: 40px; height: 40px" /></span>
                            </div>
                        </div>
                    </div>
                    <template footer>
                        <div class="footer-dialog d-flex justify-content-center">
                            <vs-button ref="button" flat square><b>Update Product</b></vs-button>
                        </div>
                    </template>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import Api from "@/apis/admin/Api";
import { ref, onMounted, computed, watch } from 'vue';

const form = ref({
    id: "",
    title: "",
    category_id: [],
    code: "",
    price: null,
    discount: null,
    smallDescription: "",
    description: "",
    imageOne: "",
    imageTwo: "",
    imageThree: "",
});

const errors = ref({});

const fileLink = (name, target) => {
    if (name != null && name.length < 256) {
        return '/uploads/products/' + name;
    } else {
        return form[target];
    }
};

const loadImage = (e, target) => {
    let file = e.target.files[0];
    let reader = new FileReader();
    reader.onload = (e) => {
        form[target] = e.target.result;
    };
    reader.readAsDataURL(file);
};

const getProduct = () => {
    $store.dispatch("product/showProduct", $route.params.id);
};

const updateProduct = () => {
    Api()
        .post(`/admin/edit-product/${$route.params.id}`, form.value)
        .then((response) => {
            console.log(response.data);
            Toast.fire({
                icon: "success",
                title: "Product update response success",
            });
        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        });
};

const activeCategories = () => {
    $store.dispatch("category/activeCategories");
};

const categories = computed(() => $store.getters["category/categoryList"]);
const product = computed(() => $store.getters["product/singleProduct"]);

onMounted(() => {
    activeCategories();
    getProduct();
});

watch(() => product.value, () => {
    form.title = product.value.title;
    form.imageOne = product.value.imageOne;
    form.imageTwo = product.value.imageTwo;
    form.imageThree = product.value.imageThree;
    form.category_id = product.value.categories.map((cat) => cat.id);
    form.code = product.value.code;
    form.price = product.value.price;
    form.discount = product.value.discount;
    form.description = product.value.description;
    form.smallDescription = product.value.smallDescription;
});
</script>
