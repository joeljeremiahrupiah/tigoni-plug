<template>
    <div class="page-wrapper">
        <div class="container-xl">
            <div class="az-content-breadcrumb mb-5">
                <span>Components</span>
                <span>UI Elements</span>
                <span>Buttons</span>
            </div>

            <div class="d-flex justify-content-start">
                <div class="az-content-label mg-b-5">Create Products</div>
            </div>

            <div class="d-flex justify-content-end">
                <router-link :to="{ name: 'admin-products' }">
                    <vs-button square> Product List </vs-button>
                </router-link>
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">

                <el-card class="box-card">
                    <template #header>
                        <div class="card-header">
                            <span>Card name</span>
                            <el-button class="button" text>Operation button</el-button>
                        </div>
                    </template>
                    <div v-for="o in 4" :key="o" class="text item">{{ 'List item ' + o }}</div>
                    <template #footer>Footer content</template>
                </el-card>

            </div>
        </div>
    </div>
</template>

<script setup>
import Api from "@/apis/admin/Api";
import { ref, computed, onMounted } from 'vue';

const form = ref({
    id: "",
    title: "",
    category_id: null,
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

const loadImage = (e, target) => {
    let file = e.target.files[0];
    let reader = new FileReader();
    reader.onload = (e) => {
        form[target] = e.target.result;
    };
    reader.readAsDataURL(file);
};

const submitProduct = () => {
    Api()
        .post("/admin/product", form.value)
        .then((response) => {
            console.log(response.data);
            Toast.fire({
                icon: "success",
                title: "Product create response success",
            });
        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        });
};

// const activeCategories = () => {
//     $store.dispatch("category/activeCategories");
// };

// const categories = computed(() => $store.getters["category/categoryList"]);

onMounted(() => {
    activeCategories();
});
</script>
