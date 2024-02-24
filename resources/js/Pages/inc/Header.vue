<template>
    <header class="header header-14">
        <div class="header-top">
            <div class="container">
                <div class="header-left">
                    <a href="tel:#" class="font-weight-bolder"><i class="icon-phone"></i>Call: +0123 456 789</a>
                </div><!-- End .header-left -->

                <div class="header-right mt-1 mb-1">

                    <ul class="top-menu">
                        <li>
                            <a href="#">Links</a>
                            <ul class="menus" v-show="!store.token">
                                <li class="login font-weight-bolder" style="cursor: pointer;">
                                    <a class="font-weight-bolder" @click="openAuthModal">Sign in / Sign up</a>
                                </li>
                            </ul>
                            <ul class="menus" v-show="store.token">
                                <div class="flex flex-wrap items-center dropdown-button">
                                    <el-dropdown size="small">
                                        <el-button type="primary">
                                            <span style="color:white;font-weight: bolder;">
                                                {{ store?.authuser?.name }}
                                            </span>
                                            <el-icon class="el-icon--right">
                                                <arrow-down /></el-icon>
                                        </el-button>
                                        <template #dropdown>
                                            <el-dropdown-menu>
                                                <router-link :to="{ name: 'account' }">
                                                    <el-dropdown-item>
                                                        <!-- <UserFilled class="mr-2" /> -->
                                                        Account
                                                    </el-dropdown-item>
                                                </router-link>
                                            </el-dropdown-menu>
                                            <el-dropdown-menu>
                                                <router-link :to="{ name: 'chat' }">
                                                    <el-dropdown-item>
                                                        Chats
                                                    </el-dropdown-item>
                                                </router-link>
                                            </el-dropdown-menu>
                                            <el-dropdown-menu>
                                                <el-dropdown-item @click="logoutUser">
                                                    Logout
                                                </el-dropdown-item>
                                            </el-dropdown-menu>
                                        </template>
                                    </el-dropdown>
                                </div>

                            </ul>
                        </li>
                    </ul>



                </div><!-- End .header-right -->

            </div><!-- End .container -->
        </div><!-- End .header-top -->

        <div class="header-middle">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto col-lg-3 col-xl-3 col-xxl-2">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>
                        <a href="/" class="logo">
                            <img src="/public/frontend/assets/images/tigoni-plug.png" alt="Molla Logo"
                                style="width:auto;height:auto;max-width:150px;">
                        </a>
                    </div><!-- End .col-xl-3 col-xxl-2 -->

                    <div class="col col-lg-9 col-xl-9 col-xxl-10 header-middle-right">
                        <div class="row">
                            <div class="col-lg-8 col-xxl-4-5col d-none d-lg-block">
                                <div
                                    class="header-search header-search-extended header-search-visible header-search-no-radius">
                                    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                                    <form action="#" method="get">
                                        <div class="header-search-wrapper search-wrapper-wide">

                                            <el-autocomplete v-model="searchTerm" :fetch-suggestions="querySearch"
                                                :trigger-on-focus="false" clearable class="inline-input w-100"
                                                placeholder="Search service ..." @select="handleSelect">
                                                <template #default="{ item }">
                                                    <span class="font-weight-bolder" v-if="item" v-html="item.value"></span>
                                                </template>
                                            </el-autocomplete>

                                        </div>
                                    </form>
                                </div><!-- End .header-search -->
                            </div><!-- End .col-xxl-4-5col -->

                            <div class="col-lg-4 col-xxl-5col d-flex justify-content-end align-items-center">
                                <div class="header-dropdown-link">
                                    <div class="dropdown compare-dropdown">
                                        <a href="/admin/vendor-login" class="btn btn-primary" target="_blank">
                                            <span>Become a Vendor</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </a>
                                    </div><!-- End .compare-dropdown -->

                                </div>
                            </div><!-- End .col-xxl-5col -->
                        </div><!-- End .row -->
                    </div><!-- End .col-xl-9 col-xxl-10 -->
                </div><!-- End .row -->
            </div><!-- End .container-fluid -->
        </div><!-- End .header-middle -->

        <div class="header-bottom sticky-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto col-lg-3 col-xl-3 col-xxl-2 header-left"
                        v-if="!['account', 'product-details', 'chat', 'shop'].includes($route.name)">
                        <div class="dropdown category-dropdown show is-on" data-visible="true">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" data-display="static" title="Browse Categories">
                                Browse Categories
                            </a>

                            <div class="dropdown-menu show">
                                <nav class="side-nav">
                                    <ul class="menu-vertical sf-arrows">
                                        <li v-for="category in categoryStore.categories" :key="category.id"><a href="#"
                                                class="main-anchor">
                                                <router-link :to="{ name: 'shop', params: { categoryId: category.slug } }"
                                                    class="category-route">
                                                    {{ category.title }}
                                                </router-link>
                                            </a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <div class="col col-lg-6 col-xl-6 col-xxl-8 header-center">
                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="megamenu-container">
                                    <a href="/">Home</a>
                                </li>
                                <li class="megamenu-container">
                                    <router-link :to="{ name: 'shop' }">Shop</router-link>
                                    <!-- <a href="/">Shop</a> -->
                                </li>
                                <li class="megamenu-container">
                                    <a href="/">About</a>
                                </li>
                                <li class="megamenu-container">
                                    <a href="/">Contact</a>
                                </li>

                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .col-xl-9 col-xxl-10 -->

                    <div class="col col-lg-3 col-xl-3 col-xxl-2 header-right">
                        <i class="la la-lightbulb-o"></i>
                        <p>Clearance Up to 30% Off</p>
                    </div>
                </div><!-- End .row -->
            </div><!-- End .container-fluid -->
        </div><!-- End .header-bottom -->


        <el-dialog v-model="authdialog" width="40%" align-center>
            <div class="form-box">
                <div class="form-tab">
                    <ul class="nav nav-pills nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab"
                                aria-controls="signin" aria-selected="true">Sign In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab"
                                aria-controls="register" aria-selected="false">Register</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="tab-content-5">
                        <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                            <form action="#">

                                <div class="form-group">
                                    <label for="singin-email">Email *</label>
                                    <input v-model="form.email" type="text" class="form-control" id="singin-email"
                                        name="singin-email"
                                        :class="{ 'is-invalid': showLoginEmailError || showValidEmailError }">
                                    <span class="text-danger text-sm" v-show="showLoginEmailError">Email is
                                        required</span>
                                    <span class="text-danger text-sm" v-show="showValidEmailError">Invalid email
                                        format</span>

                                </div>

                                <div class="form-group">
                                    <label for="singin-password">Password *</label>
                                    <input v-model="form.password" type="password" class="form-control" id="singin-password"
                                        name="singin-password" :class="{ 'is-invalid': showLoginPasswordError }">
                                    <span class="text-danger text-sm" v-show="showLoginPasswordError">Password is
                                        required</span>
                                </div>

                                <div class="form-footer">
                                    <button type="submit" class="btn btn-outline-primary-2" @click.prevent="login"
                                        :loading="loading2">
                                        <span>
                                            {{ loading2 ? 'Processing ...' : 'Sign in' }}
                                        </span>
                                        <i class="icon-long-arrow-right" v-show="!loading2"></i>
                                    </button>

                                    <!-- End .custom-checkbox -->

                                    <a href="#" class="forgot-link">Forgot Your Password?</a>
                                </div><!-- End .form-footer -->
                            </form>
                            <div class="form-choice">
                                <p class="text-center">or sign in with</p>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <a href="#" class="btn btn-login btn-g">
                                            <i class="icon-google"></i>
                                            Login With Google
                                        </a>
                                    </div><!-- End .col-6 -->
                                    <div class="col-sm-6">
                                        <a href="#" class="btn btn-login btn-f">
                                            <i class="icon-facebook-f"></i>
                                            Login With Facebook
                                        </a>
                                    </div><!-- End .col-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .form-choice -->
                        </div><!-- .End .tab-pane -->
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <form action="#">
                                <div class="form-group">
                                    <label for="singin-email">First Name *</label>
                                    <input v-model="form.firstname" type="text" class="form-control" id="singin-email"
                                        name="singin-email" :class="{ 'is-invalid': showFirstNameError }">
                                    <span class="text-danger text-sm" v-show="showFirstNameError">First name is
                                        required</span>
                                </div><!-- End .form-group -->

                                <div class="form-group">
                                    <label for="singin-email">Last Name *</label>
                                    <input v-model="form.lastname" type="text" class="form-control" id="singsingin-email"
                                        name="singin-email" :class="{ 'is-invalid': showLastNameError }">
                                    <span class="text-danger text-sm" v-show="showLastNameError">Last name is
                                        required</span>
                                </div><!-- End .form-group -->

                                <div class="form-group">
                                    <label for="singin-email">Email *</label>
                                    <input v-model="form.email" type="text" class="form-control" id="singin-email"
                                        name="singin-email"
                                        :class="{ 'is-invalid': showEmailError || showValidEmailError }">
                                    <span class="text-danger text-sm" v-show="showEmailError">Email is required</span>
                                    <span class="text-danger text-sm" v-show="showValidEmailError">Invalid email
                                        format</span>
                                </div><!-- End .form-group -->

                                <div class="form-group">
                                    <label for="singin-password">Password *</label>
                                    <input v-model="form.password" type="text" class="form-control" id="singin-password"
                                        name="singin-password" :class="{ 'is-invalid': showPasswordError }">
                                    <span class="text-danger text-sm" v-show="showPasswordError">Password is
                                        required</span>
                                </div><!-- End .form-group -->

                                <div class="form-group">
                                    <label for="singin-password">Confirm Password *</label>
                                    <input v-model="form.password_confirmation" type="password" class="form-control"
                                        id="singin-password" name="singin-password"
                                        :class="{ 'is-invalid': showPasswordConfirmationError }">
                                    <span class="text-danger text-sm" v-show="showPasswordConfirmationError">Password
                                        confirmation is
                                        required</span>
                                </div><!-- End .form-group -->

                                <span class="text-danger text-sm" v-show="showPasswordAndPasswordConfirmationError">Password
                                    and
                                    confirmation password do not match</span>

                                <div class="form-footer">
                                    <button type="submit" class="btn btn-outline-primary-2" @click.prevent="register"
                                        :loading="loading">
                                        <span>
                                            {{ loading ? 'Processing ...' : 'Sign up' }}
                                        </span>
                                        <i class="icon-long-arrow-right" v-show="!loading"></i>
                                    </button>

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="register-policy" required>
                                        <label class="custom-control-label" for="register-policy">I agree to the <a
                                                href="#">privacy policy</a> *</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </el-dialog>

    </header>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user.js'
import { useCategoryStore } from '@/stores/category.js'
import { useProductStore } from '@/stores/product.js'
import { ElNotification } from 'element-plus'
import {
    ChatDotRound,
    UserFilled,
    User,
    Close
} from '@element-plus/icons-vue'

const router = useRouter()
const store = useUserStore()
const categoryStore = useCategoryStore()
const productStore = useProductStore()


let authdialog = ref(false)

let categories = ref([])

let loading = ref(false)
let loading2 = ref(false)

const searchTerm = ref('');
const selectedProduct = ref(null);

let showLoginEmailError = ref(false)
let showLoginPasswordError = ref(false)

let showFirstNameError = ref(false)
let showLastNameError = ref(false)
let showEmailError = ref(false)
let showValidEmailError = ref(false)
let showPasswordError = ref(false)
let showPasswordConfirmationError = ref(false)
let showPasswordAndPasswordConfirmationError = ref(false)

const form = ref({
    firstname: '',
    lastname: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const openAuthModal = () => {
    authdialog.value = true
}

const querySearch = (queryString, cb) => {
    const results = queryString
        ? productStore.allproducts
            .filter(createFilter(queryString))
            .flatMap((product) =>
                product.categories.map((category) => ({
                    value: `<span>${product.title} in <strong>${category.title}</strong></span>`,
                    product: product.title,
                    category: category.title,
                    productId: product.slug,
                    categoryId: category.slug,
                }))
            )
        : productStore.allproducts.flatMap((product) =>
            product.categories.map((category) => ({
                value: `<span>${product.title} in <strong>${category.title}</strong></span>`,
                product: product.title,
                category: category.title,
                productId: product.slug,
                categoryId: category.slug,
            }))
        );
    cb(results);
};

const createFilter = (queryString) => {
    return (product) =>
        product.title.toLowerCase().indexOf(queryString.toLowerCase()) === 0;
};

const handleSelect = (item) => {

    const regex = /<[^>]+>/g;
    const selectedValue = item.value.replace(regex, '');
    const productId = item.productId;
    const categoryId = item.categoryId;
    searchTerm.value = selectedValue;

    router.push({
        name: 'shop', params: {
            productId: productId,
            categoryId: categoryId
        }
    });
    productStore.rerendershoppage += 1
};

let validatePasswords = () => {
    if (form.value.password !== form.value.password_confirmation) {
        showPasswordAndPasswordConfirmationError.value = true

        ElNotification({
            title: 'Error',
            message: 'Password and confirmation password do not match',
            type: 'error',
        });

        return false;
    } else {
        showPasswordAndPasswordConfirmationError.value = false
        return true;
    }
};


let login = async () => {

    const emailFormatRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    showLoginEmailError.value = false;
    showValidEmailError.value = false;

    if (!form.value.email || form.value.email.trim() === '') {
        showLoginEmailError.value = true;
        ElNotification({
            title: 'Error',
            message: 'Email is required',
            type: 'error',
        });
        return
    } else {
        showLoginEmailError.value = false
    }

    if (!emailFormatRegex.test(form.value.email.trim())) {
        showValidEmailError.value = true;
        ElNotification({
            title: 'Error',
            message: 'Invalid email format',
            type: 'error',
        });
        return
    } else {
        showValidEmailError.value = false
    }

    if (!form.value.password || form.value.password == '') {
        showLoginPasswordError.value = true
        ElNotification({
            title: 'Error',
            message: 'Password is required',
            type: 'error',
        })
        return
    } else {
        showLoginPasswordError.value = false
    }

    loading2.value = true

    let response = await axios.post('/login', form.value);
    if (response.status === 200) {
        ElNotification({
            title: 'Success',
            message: 'Login successful',
            type: 'success',
        })
        const { token, user_type, user } = response.data;
        localStorage.setItem('token', token);
        store.authuser = user
        store.token = token
        if (store.token) {
            router.push({ name: 'account' });
            authdialog.value = false
            // window.location.href = '/account'
        } else {
            router.push('/');
            authdialog.value = false
            // window.location.href = '/'
        }
        loading2.value = false

    } else {
        ElNotification({
            title: 'Error',
            message: 'An error occured. Please try again',
            type: 'error',
        })
        loading.value = false
    }
    loading.value = false

};


let register = async () => {

    const emailFormatRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    showLoginEmailError.value = false;
    showValidEmailError.value = false;

    if (!form.value.firstname || form.value.firstname == '') {
        showFirstNameError.value = true
        ElNotification({
            title: 'Error',
            message: 'First name is required',
            type: 'error',
        })
        return
    } else {
        showFirstNameError.value = false
    }

    if (!form.value.lastname || form.value.lastname == '') {
        showLastNameError.value = true
        ElNotification({
            title: 'Error',
            message: 'Last name is required',
            type: 'error',
        })
        return
    } else {
        showLastNameError.value = false
    }

    if (!form.value.email || form.value.email.trim() === '') {
        showEmailError.value = true;
        ElNotification({
            title: 'Error',
            message: 'Email is required',
            type: 'error',
        });
        return
    } else {
        showEmailError.value = false
    }

    if (!emailFormatRegex.test(form.value.email.trim())) {
        showValidEmailError.value = true;
        ElNotification({
            title: 'Error',
            message: 'Invalid email format',
            type: 'error',
        });
        return
    } else {
        showValidEmailError.value = false
    }

    if (!form.value.password || form.value.password == '') {
        showPasswordError.value = true
        ElNotification({
            title: 'Error',
            message: 'Password is required',
            type: 'error',
        })
        return
    } else {
        showPasswordError.value = false
    }

    if (!form.value.password_confirmation || form.value.password_confirmation == '') {
        showPasswordConfirmationError.value = true
        ElNotification({
            title: 'Error',
            message: 'Password confirmation is required',
            type: 'error',
        })
        return
    } else {
        showPasswordConfirmationError.value = false
    }

    if (!validatePasswords()) {
        return;
    }


    loading.value = true
    let response = await axios.post('/register', form.value);
    if (response.status === 200) {
        ElNotification({
            title: 'Success',
            message: 'Register successful',
            type: 'success',
        })
        const { token, user_type, user } = response.data;
        localStorage.setItem('token', token);
        store.authuser = user
        store.token = token
        if (store.token) {
            router.push({ name: 'account' });
            authdialog.value = false
            loading.value = false
            // window.location.href = '/account'
        } else {
            router.push('/');
            authdialog.value = false
            loading.value = false
            // window.location.href = '/'
        }
    } else {
        ElNotification({
            title: 'Error',
            message: 'An error occured. Please try again',
            type: 'error',
        })
        loading.value = false
    }
    loading.value = false
};


const filteredCategories = computed(() => {
    return categoryStore?.categories?.filter(category =>
        category?.products.some(product =>
            product.title.toLowerCase().includes(searchTerm.value.toLowerCase())
        )
    );
});

const getAllCategories = async () => {
    try {
        const response = await axios.get('/get-categories');
        categoryStore.categories = response.data.categories;
    } catch (error) {
        console.error(error);
    }
};

const getAllProducts = async () => {
    try {
        const response = await axios.get('/get-products');
        productStore.allproducts = response.data.products;
    } catch (error) {
        console.error(error);
    }
};

const navigateToProduct = () => {
    console.log('Selected Product:', selectedProduct.value);
};

const getAdminDetails = async () => {
    let response = await axios.get('/get-admin-details')
    if (response.status == 200) {
        store.admindetails = response.data.admindetails
    }
}

const logoutUser = () => {
    store.token = null
    store.authuser = null
    window.location.href = '/'
}

onMounted(() => {
    getAllCategories();
    getAllProducts()
    getAdminDetails()
});


</script>

<style scoped>
.filtered-results-dropdown {
    margin-top: 10px;
}

button.ivu-btn.ivu-btn-button.el-button.el-button--primary.el-tooltip__trigger {
    background-color: #8CC63F;
    border-radius: 0;
    color: black;
}

button span span {
    color: black;
}

.category-route {
    color: black;
}

a.main-anchor:hover {
    background-color: #8CC63F;
    color: white;
}
</style>
