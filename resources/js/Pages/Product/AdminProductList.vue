<template>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">

        <div class="page-body">
            <div class="container-xl">

                <el-card class="box-card">
                    <template #header>
                        <div class="card-header d-flex justify-content-between">

                            <div class="az-content-label mg-b-5">Services Table</div>

                            <div>
                                <el-button @click.prevent="createProductModal">Create Service</el-button>
                            </div>

                        </div>
                    </template>
                    <div class="table-responsive">
                        <table class="table table-hover mg-b-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Date Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in products" :key="product.id">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ product.title }}</td>
                                    <td>
                                        <el-tag v-for="(category, indx) in product.categories" :key="indx" type="success"
                                            effect="dark">
                                            {{ category.title }}
                                        </el-tag>
                                    </td>
                                    <td>{{ moment(product.created_at).format('DD-MM-YYYY') }}</td>
                                    <td>

                                        <el-button size="small" type="warning"
                                            @click="openEditCategoryModal(product)">Edit</el-button>
                                        <el-button size="small" type="danger"
                                            @click="deleteProduct(product.id)">Delete</el-button>
                                        <el-button size="small" type="success" @click="openPaymentModal(product)"
                                            v-show="product.paid == 'yes'">Paid</el-button>
                                        <el-button size="small" type="success" @click="openPaymentModal(product)"
                                            v-show="product.paid == 'no'">Pay</el-button>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <template #footer>Footer content</template>

                </el-card>
            </div>
        </div>

        <el-dialog v-model="dialogVisible" :title="titleChange" width="90%" :before-close="handleClose">

            <el-divider content-position="left">Service Details</el-divider>


            <div class="row">

                <div class="col-md-4">
                    <div class="mb-2"> Service Name </div>
                    <el-input v-model="form.title" clearable placeholder="e.g Naivas Supermarket"
                        :class="{ 'is-invalid': servicenameerror }"></el-input>
                    <span class="text-danger mt-3" v-if="servicenameerror">Service name is required</span>
                </div>
                <div class="col-md-4">
                    <div class="mb-2"> Service Minimum Amount </div>
                    <el-input v-model="form.price" clearable
                        :class="{ 'is-invalid': serviceminimumamounterror }"></el-input>
                    <span class="text-danger mt-3" v-if="serviceminimumamounterror">Minimum amount is required</span>
                </div>
                <div class="col-md-4">
                    <div class="mb-2"> Service Maximum Amount </div>
                    <el-input v-model="form.discount" clearable
                        :class="{ 'is-invalid': servicemaximumamounterror }"></el-input>
                    <span class="text-danger mt-3" v-if="servicemaximumamounterror">Maximum amount is required</span>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="mb-2"> Small Description </div>
                    <QuillEditor theme="snow" v-model:content="form.smallDescription" contentType="html"
                        id="small-description" style="height:200px" :formats="[
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                            'blockquote',
                            'code-block',
                            'header',
                            'list',
                            'bullet',
                            'indent',
                            'align'
                        ]" :html-parser="myHtmlParser" :html-formatter="myHtmlFormatter" />
                    <span class="text-danger mt-5" v-if="servicesmalldescriptionerror">Small description is required</span>
                </div>
                <div class="col-md-6">
                    <div class="mb-2"> Main Description </div>
                    <QuillEditor theme="snow" v-model:content="form.description" contentType="html" id="small-description"
                        style="height:200px" :formats="[
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                            'blockquote',
                            'code-block',
                            'header',
                            'list',
                            'bullet',
                            'indent',
                            'align'
                        ]" :html-parser="myHtmlParser" :html-formatter="myHtmlFormatter" />
                    <span class="text-danger mt-5" v-if="servicemaindescriptionerror">Main description is required</span>
                </div>
            </div>

            <el-divider content-position="left">Categories</el-divider>
            <span class="text-danger mt-3" v-if="servicecategoryerror">Select atleast one category</span>

            <el-checkbox-group v-model="form.category_id">
                <el-checkbox v-for="(category, inx) in categories" :key="inx" :label="category.id" :value="category.id">
                    {{ category.title }}
                </el-checkbox>
            </el-checkbox-group>

            <el-divider content-position="left">Upload Product Images</el-divider>
            <span class="text-danger mt-3" v-if="serviceimageserror">Upload atleast one image</span>

            <div class="row">
                <div class="col-md-6">
                    <el-upload v-model:file-list="fileDocumentImageList" :auto-upload="false"
                        :on-remove="handleDocumentImageRemove" :on-change="handleDocumentImageFileChange"
                        :before-remove="beforeDocumentImageRemove" :on-exceed="handleDocumentImageExceed"
                        list-type="picture">
                        <el-button style="background: #ddd">Click to upload</el-button>
                        <template #tip>
                            <div class="el-upload__tip">
                                Max file size 10MB, only Images
                            </div>
                        </template>
                    </el-upload>
                </div>
            </div>

            <el-divider content-position="left" v-show="editmode">Product Images</el-divider>
            <span class="text-danger mt-3" v-if="serviceimageserror">Upload atleast one image</span>

            <div class="row" v-show="editmode">
                <div class="col-md-4" v-for="mainimage in productStore.productimages" :key="mainimage.id">
                    <img :src="imageLink(mainimage.image_path)" alt=""
                        style="width: auto;height: auto;max-width: 300px;max-height: 300px;">
                    <br>
                    <br>
                    <el-button type="danger" size="small" @click.prevent="deleteServiceimage(mainimage)">Delete</el-button>
                </div>
            </div>

            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="closeCategoryModal">Cancel</el-button>
                    <el-button v-show="!editmode" type="primary" @click="createProduct" :loading="loading">
                        {{ loading ? 'Processing ... ' : 'Create' }}
                    </el-button>
                    <el-button v-show="editmode" type="primary" @click="updateProduct" :loading="loading">
                        {{ loading ? 'Processing ... ' : 'Update' }}
                    </el-button>
                </span>
            </template>
        </el-dialog>

        <el-dialog v-model="showpaymentmodal" width="50%">

            <div class="row">
                <div class="col-md-12 mb-2 text-center">
                    <h1>Product {{ mainproduct.title }}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <div>Enter amount to transact</div>
                    <el-input v-model="paymentform.amount" placeholder="Enter amount to pay"></el-input>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <el-button type="danger" @click="closePaymentModal">Cancel</el-button>
                    <el-button type="success" @click.prevent="processPayment" :loading="loading2">
                        {{ loading2 ? 'Processing ...' : 'Process Payment' }}</el-button>
                </div>
            </div>

            <el-divider content-position="left" v-if="showpaymentmodalifram">Pesapal Iframe</el-divider>

            <div class="row" v-if="showpaymentmodalifram">
                <div class="col-md-12" style="width:100%;height: 500px">
                    <iframe :src="showpaymentmodalifram" style="width:100%;height: 500px"></iframe>
                </div>
            </div>



        </el-dialog>

    </div>
</template>
  
<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import { ElMessageBox, ElNotification } from "element-plus";
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user.js'
import { useProductStore } from '@/stores/product.js'
import moment from "moment"
// import Quill from 'quill'

const router = useRouter()
const store = useUserStore()
const productStore = useProductStore()

let categories = ref([]);

let products = ref([])

let product = ref({})

let mainproduct = ref({})

let dialogVisible = ref(false)

let editmode = ref(false)

let loading = ref(false)
let loading2 = ref(false)

let servicenameerror = ref(false)
let serviceminimumamounterror = ref(false)
let servicemaximumamounterror = ref(false)
let servicesmalldescriptionerror = ref(false)
let servicemaindescriptionerror = ref(false)
let servicecategoryerror = ref(false)
let serviceimageserror = ref(false)

let titleChange = ref('')

let fileDocumentImageList = ref([])

let mainimages = ref([])

let showpaymentmodal = ref(false)
let showpaymentmodalifram = ref(null)

let paymentform = ref({
    product_id: '',
    amount: ''
})

let form = ref({
    id: '',
    category_id: '',
    title: '',
    price: '',
    discount: '',
    smallDescription: '',
    description: '',
    imageOne: '',
    imageTwo: '',
    imageThree: '',
})

const myHtmlParser = function (html) {
    const delta = new Quill.imports.Delta();
    if (html.match(/^<ol/)) {
        const matches = html.match(/<ol[^>]*(.*?)]>/gi);
        matches.forEach(match => {
            const attributes = match.match(/[\w-]+="[^"]*"/g);
            const start = +(attributes.find(attr => attr.includes('start=')) || '1').slice(7);
            delta.insert({ list: 'ordered', start });
        });
        return delta;
    }
}

const myHtmlFormatter = function (delta, options) {
    if (delta.ops[0].attributes.list === 'ordered') {
        html = '<ol start="' + delta.ops[0].attributes.start + '">';
    }
}

const createProductModal = () => {
    editmode.value = false
    form.value = {}
    titleChange.value = 'Create Service'
    dialogVisible.value = true
}

const closeCategoryModal = () => {
    editmode.value = false
    form.value = {}
    loading.value = false
    dialogVisible.value = false
    fileDocumentImageList.value = []
}

const openEditCategoryModal = (product) => {
    editmode.value = true;
    titleChange.value = 'Edit Service';
    form.value.id = product.id;
    form.value.title = product.title;
    form.value.category_id = product.categories.map(category => category.id);
    form.value.price = product.price;
    form.value.discount = product.discount;
    form.value.smallDescription = product.smallDescription;
    form.value.description = product.description;
    productStore.productimages = product.images;
    // mainimages.value = product.images;
    dialogVisible.value = true;
};


const imageLink = (name) => {
    return "/storage/" + name
}

const handleDocumentImageRemove = (file, uploadList) => {
    fileDocumentImageList.value = uploadList.filter((f) => f.name !== file.name);
};

const handleDocumentImageFileChange = (file, uploadList) => {
    const extension = file.name.split(".").pop();
    let allowedExtensions = ["jpg", "jpeg", "png"];

    if (!allowedExtensions.includes(extension.toLowerCase())) {
        ElNotification.error(
            `The file extension ${extension} is not allowed. Allowed extensions are ${allowedExtensions.join(
                ", "
            )}`
        );
        handleDocumentImageRemove(file, uploadList);
    } else {
        if (file.size > 10485760) {
            ElNotification.error(
                `The file size is greater than 10MB. Please upload a smaller file.`
            );
            handleDocumentImageRemove(file, uploadList);
        }
    }
};

const createProduct = async () => {

    if (form.value.title == null || form.value.title == '') {
        ElNotification({
            title: 'Error',
            message: 'Service name is required',
            type: 'error',
        });
        servicenameerror.value = true
        return
    } else {
        servicenameerror.value = false
    }

    if (form.value.price == null || form.value.price == '') {
        ElNotification({
            title: 'Error',
            message: 'Minimum amount is required',
            type: 'error',
        });
        serviceminimumamounterror.value = true
        return
    } else {
        serviceminimumamounterror.value = false
    }

    if (form.value.discount == null || form.value.discount == '') {
        ElNotification({
            title: 'Error',
            message: 'Maximum amount is required',
            type: 'error',
        });
        servicemaximumamounterror.value = true
        return
    } else {
        servicemaximumamounterror.value = false
    }

    if (form.value.smallDescription == null || form.value.smallDescription == '') {
        ElNotification({
            title: 'Error',
            message: 'Small description is required',
            type: 'error',
        });
        servicesmalldescriptionerror.value = true
        return
    } else {
        servicesmalldescriptionerror.value = false
    }

    if (form.value.description == null || form.value.description == '') {
        ElNotification({
            title: 'Error',
            message: 'Main description is required',
            type: 'error',
        });
        servicemaindescriptionerror.value = true
        return
    } else {
        servicemaindescriptionerror.value = false
    }

    if (form.value.category_id == null || form.value.category_id == '') {
        ElNotification({
            title: 'Error',
            message: 'Select atleast one category',
            type: 'error',
        });
        servicecategoryerror.value = true
        return
    } else {
        servicecategoryerror.value = false
    }

    if (fileDocumentImageList.value.length < 1) {
        ElNotification({
            title: 'Error',
            message: 'Upload atleast one image',
            type: 'error',
        });
        serviceimageserror.value = true
        return
    } else {
        serviceimageserror.value = false
    }

    let imagesdata = fileDocumentImageList.value;

    const formData = new FormData();
    imagesdata.forEach((image, index) => {
        formData.append(`images[${index}]`, image.raw);
    });

    // Append other form fields to formData
    formData.append('user_id', store?.authuser?.id);
    formData.append('title', form.value.title);
    formData.append('category_id', form.value.category_id);
    formData.append('price', form.value.price);
    formData.append('discount', form.value.discount);
    formData.append('smallDescription', form.value.smallDescription);
    formData.append('description', form.value.description);

    loading.value = true;

    try {
        const response = await axios.post('/admin/create-products', formData);

        if (response.status === 200) {
            ElNotification({
                title: 'Success',
                message: 'Product created successfully',
                type: 'success',
            });

            loading.value = false;
            dialogVisible.value = false;
            getAllProducts();
            fileDocumentImageList.value = [];
        } else {
            throw new Error('Failed to create product');
        }
    } catch (error) {
        ElNotification({
            title: 'Error',
            message: 'An error occurred. Please try again',
            type: 'error',
        });

        loading.value = false;
        dialogVisible.value = false;
        getAllProducts();
        fileDocumentImageList.value = [];
    }
};


const updateProduct = async () => {
    const formData = new FormData();

    for (let i = 0; i < fileDocumentImageList.value.length; i++) {
        formData.append('product_images[]', fileDocumentImageList.value[i].raw);
    }

    // Append other form fields to formData
    formData.append('user_id', store?.authuser?.id);
    formData.append('id', form.value.id);
    formData.append('title', form.value.title);
    formData.append('category_id', form.value.category_id);
    formData.append('price', form.value.price);
    formData.append('discount', form.value.discount);
    formData.append('smallDescription', form.value.smallDescription);
    formData.append('description', form.value.description);

    loading.value = true;

    try {
        const response = await axios.post(`/admin/update-products/${form.value.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        if (response.status === 200) {
            ElNotification({
                title: 'Success',
                message: 'Product updated successfully',
                type: 'success',
            });

            loading.value = false;
            dialogVisible.value = false;
            getAllProducts();
            fileDocumentImageList.value = [];
        } else {
            throw new Error('Failed to update product');
        }
    } catch (error) {
        ElNotification({
            title: 'Error',
            message: 'An error occurred. Please try again',
            type: 'error',
        });

        loading.value = false;
        dialogVisible.value = false;
        getAllProducts();
        fileDocumentImageList.value = [];
    }
};


const deleteProduct = async (productId) => {
    try {
        const response = await ElMessageBox.confirm('Are you sure you want to delete this category?', 'Warning', {
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            type: 'warning',
        });

        if (response === 'confirm') {
            await axios.delete(`/admin/destroy-products/${productId}`);
            products.value = products.value.filter((product) => product.id !== productId);
            ElNotification({
                title: 'Success',
                message: 'Product deleted successfully',
                type: 'success',
            });
            getAllProducts()
            fileDocumentImageList.value = []
        }
    } catch (error) {
        console.error(error);
        getAllProducts()
        fileDocumentImageList.value = []
    }
};

const getAllCategories = async () => {
    try {
        const response = await axios.get('/admin/get-categories');
        categories.value = response.data.categories;
    } catch (error) {
        console.error(error);
    }
};


const getAllProducts = async () => {
    try {
        const response = await axios.get(`/admin/get-products/${store?.authuser?.id}`);
        products.value = response.data.products;
    } catch (error) {
        console.error(error);
    }
};


const openPaymentModal = async (product) => {
    mainproduct.value = product
    paymentform.value.amount = ''
    paymentform.value.product_id = product.id
    showpaymentmodal.value = true
}

const closePaymentModal = () => {
    mainproduct.value = {}
    paymentform.value.amount = ''
    paymentform.value.product_id = ''
    showpaymentmodal.value = false
}

const processPayment = async () => {
    console.log(paymentform.value)
    loading2.value = true
    let response = await axios.post(`/admin/pay-for-product/${store?.authuser?.id}`, paymentform.value)
    if (response.data.redirect_url) {
        showpaymentmodalifram.value = response.data.redirect_url

        if (showpaymentmodalifram.value != null) {
            showpaymentmodal.value = true
        }
    }
    loading2.value = false
}

const deleteServiceimage = async (mainimage) => {
    let response = await axios.delete(`/admin/delete-service-image/${mainimage.id}`)
    productStore.productimages = response.data.productimages
    if (response.status == 200) {
        ElNotification({
            title: 'Success',
            message: 'Product updated successfully',
            type: 'success',
        });
    } else {
        ElNotification({
            title: 'Error',
            message: 'An error occured. Please try again',
            type: 'Error',
        });
    }
    getAllProducts()
}

onMounted(() => {
    getAllCategories();
    getAllProducts()
});
</script>
  
<style scoped>
.is-invalid {
    border: 2px solid red;
    border-radius: 5px;
}
</style>
  