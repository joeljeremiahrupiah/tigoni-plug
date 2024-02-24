<template>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">

        <div class="page-body">
            <div class="container-xl">

                <div class="row">
                    <div class="col-md-4" v-for="(fixture, index) in fixturemaindata" :key="index">
                        <el-card class="box-card" v-for="fixturedata in  fixture.fixturedatas" :key="fixturedata.id">
                            <template #header>
                                <!-- <div class="card-header d-flex justify-content-between">
                                    <div class="az-content-label mg-b-5 d-flex justify-content-between">
                                        <img :src="fixturedata?.country_logo" alt=""
                                            style="width: auto;max-width: 50px;height: auto;max-height: 50px;">
                                        <div style="display:block">
                                            <p>{{ fixturedata?.league }}</p>
                                            <p>{{ fixturedata?.country }}</p>
                                        </div>
                                    </div>
                                </div> -->

                                <el-collapse v-model="activeName" accordion>
                                    <el-collapse-item v-for="fixturedata in  fixture.fixturedatas" :key="fixturedata.id"
                                        :title="fixturedata.league" :name="index.toString()">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="az-content-label mg-b-5 d-flex justify-content-between">
                                                <img :src="fixturedata?.country_logo" alt=""
                                                    style="width: auto;max-width: 50px;height: auto;max-height: 50px;">
                                                <div style="display:block">
                                                    <p>{{ fixturedata?.league }}</p>
                                                    <p>{{ fixturedata?.country }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <!-- Content specific to each collapse item -->
                                            <!-- Add your desired content here -->
                                        </div>
                                    </el-collapse-item>
                                </el-collapse>

                            </template>
                            <span></span>
                            <template #footer>Footer content</template>


                        </el-card>
                    </div>
                </div>


            </div>
        </div>

        <el-dialog v-model="dialogVisible" :title="titleChange" width="90%" :before-close="handleClose">

            <el-divider content-position="left">Service Details</el-divider>


            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="mb-2"> Service Name </div>
                    <el-input v-model="form.title" clearable placeholder="e.g Naivas Supermarket"></el-input>
                </div>
                <div class="col-md-4">
                    <div class="mb-2"> Service Minimum Amount </div>
                    <el-input v-model="form.price" clearable></el-input>
                </div>
                <div class="col-md-4">
                    <div class="mb-2"> Service Maximum Amount </div>
                    <el-input v-model="form.discount" clearable></el-input>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="mb-2"> Facebook Link </div>
                    <el-input v-model="form.facebooklink" clearable></el-input>
                </div>
                <div class="col-md-4">
                    <div class="mb-2"> Instagram Link </div>
                    <el-input v-model="form.instagramlink" clearable></el-input>
                </div>
                <div class="col-md-4">
                    <div class="mb-2"> Twitter Link </div>
                    <el-input v-model="form.twitterlink" clearable></el-input>
                </div>
                <div class="col-md-4">
                    <div class="mb-2"> Youtube Link </div>
                    <el-input v-model="form.youtubelink" clearable></el-input>
                </div>
            </div>

            <div class="row mt-3">
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
                </div>
            </div>

            <el-divider content-position="left">Upload Product Images</el-divider>

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

            <el-divider content-position="left" v-show="editmode">Categories</el-divider>

            <el-checkbox-group v-model="form.category_id">
                <el-checkbox v-for="category in categories" :key="category.id" :label="category.id">
                    {{ category.title }}
                </el-checkbox>
            </el-checkbox-group>

            <el-divider content-position="left" v-show="editmode">Product Images</el-divider>

            <div class="row" v-show="editmode">
                <div class="col-md-4" v-for="mainimage in mainimages" :key="mainimage.id">
                    <img :src="imageLink(mainimage.image_path)" alt=""
                        style="width: auto;height: auto;max-width: 300px;max-height: 300px;">
                    <br>
                    <br>
                    <el-button type="danger" size="small" @click.prevent="deleteService(mainimage)">Delete</el-button>
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
import moment from "moment"
// import Quill from 'quill'

const router = useRouter()
const store = useUserStore()

let categories = ref([]);

let products = ref([])

let product = ref({})

let mainproduct = ref({})

let dialogVisible = ref(false)

let editmode = ref(false)

let loading = ref(false)
let loading2 = ref(false)


let titleChange = ref('')

let fileDocumentImageList = ref([])

let mainimages = ref([])

let fixturemaindata = ref([])

let showpaymentmodal = ref(false)
let showpaymentmodalifram = ref(null)

let paymentform = ref({
    product_id: '',
    amount: ''
})

let form = ref({
    id: '',
    category_id: [],
    title: '',
    price: '',
    discount: '',
    smallDescription: '',
    description: '',
    facebooklink: '',
    instagramlink: '',
    twitterlink: '',
    youtubelink: ''
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
    form.value.facebooklink = product.facebooklink;
    form.value.instagramlink = product.instagramlink;
    form.value.twitterlink = product.twitterlink;
    form.value.youtubelink = product.youtubelink;
    mainimages.value = product.images;
    dialogVisible.value = true;
};


const imageLink = (name) => {
    console.log(name)
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
    let imagesdata = fileDocumentImageList.value;

    const formData = new FormData();
    imagesdata.forEach((image, index) => {
        formData.append(`images[${index}]`, image.raw);
    });

    // Append other form fields to formData
    formData.append('user_id', store?.authuser?.id);
    formData.append('title', form.value.title);
    formData.append('category_id', form.value.category_id.join(','));
    formData.append('price', form.value.price);
    formData.append('discount', form.value.discount);
    formData.append('smallDescription', form.value.smallDescription);
    formData.append('description', form.value.description);
    formData.append('facebooklink', form.value.facebooklink);
    formData.append('instagramlink', form.value.instagramlink);
    formData.append('twitterlink', form.value.twitterlink);
    formData.append('youtubelink', form.value.youtubelink);

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

    formData.append('user_id', store?.authuser?.id);
    formData.append('id', form.value.id);
    formData.append('title', form.value.title);
    formData.append('category_id', form.value.category_id.join(','));
    formData.append('price', form.value.price);
    formData.append('discount', form.value.discount);
    formData.append('smallDescription', form.value.smallDescription);
    formData.append('description', form.value.description);
    formData.append('facebooklink', form.value.facebooklink);
    formData.append('instagramlink', form.value.instagramlink);
    formData.append('twitterlink', form.value.twitterlink);
    formData.append('youtubelink', form.value.youtubelink);

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


const getAllFixtures = async () => {
    try {
        const token = localStorage.getItem('token');
        console.log(token);

        const response = await axios.get('/todays-fixtures', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });

        console.log(response.data);
        fixturemaindata.value = response.data.fixturemaindata;
    } catch (error) {
        console.error(error);
    }
};



const deleteService = async (mainimage) => {
    let response = await axios.delete(`/admin/delete-service-image/${mainimage.id}`)
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
    getAllFixtures()
});
</script>
  