<template>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">

        <div class="page-body">
            <div class="container-xl">

                <el-card class="box-card">
                    <template #header>
                        <div class="card-header d-flex justify-content-between">

                            <div class="az-content-label mg-b-5">Categories Table</div>
                            <div>
                                <el-button @click.prevent="createCategoryModal">Create Category</el-button>
                            </div>

                        </div>
                    </template>
                    <div class="table-responsive">
                        <table class="table table-hover mg-b-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Date Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(category, index) in categories" :key="category.id">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ category.title }}</td>
                                    <td>{{ moment(category.created_at).format('DD-MM-YYYY') }}</td>
                                    <td>
                                        <el-button type="warning" @click="openEditCategoryModal(category)"
                                            size="small">Edit</el-button>
                                        <el-button type="danger" @click="deleteCategory(category.id)"
                                            size="small">Delete</el-button>


                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <template #footer>Footer content</template>

                </el-card>
            </div>
        </div>

        <el-dialog v-model="dialogVisible" :title="titleChange" width="30%" :before-close="handleClose">
            <span>
                <form>
                    <label class="mb-2"> Category Name </label>
                    <el-input v-model="form.title" :class="{ 'is-invalid': categorytitleerror }" />
                    <span class="text-danger mt-3" v-if="categorytitleerror">Category name is required</span>
                </form>

            </span>
            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="closeCategoryModal">Cancel</el-button>
                    <el-button v-show="!editmode" type="primary" @click="createCategory" :loading="loading">
                        {{ loading ? 'Processing ... ' : 'Create' }}
                    </el-button>
                    <el-button v-show="editmode" type="primary" @click="updateCategory" :loading="loading">
                        {{ loading ? 'Processing ... ' : 'Update' }}
                    </el-button>
                </span>
            </template>
        </el-dialog>

    </div>
</template>
  
<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import { ElMessageBox, ElNotification } from "element-plus";
import moment from "moment"

let categories = ref([]);

let dialogVisible = ref(false)

let editmode = ref(false)

let loading = ref(false)

let titleChange = ref('')

let categorytitleerror = ref(false)

let form = ref({
    id: '',
    title: ''
})

const createCategoryModal = () => {
    editmode.value = false
    form.value = {}
    titleChange.value = 'Create Category'
    dialogVisible.value = true
}

const closeCategoryModal = () => {
    editmode.value = false
    form.value = {}
    loading.value = false
    dialogVisible.value = false
}

const openEditCategoryModal = (category) => {
    editmode.value = true
    titleChange.value = 'Edit Category'
    form.value.title = category.title
    form.value.id = category.id
    dialogVisible.value = true
}

const createCategory = async () => {

    if (form.value.title == null || form.value.title == '') {
        ElNotification({
            title: 'Error',
            message: 'Category name is required',
            type: 'error',
        });
        categorytitleerror.value = true
        return
    } else {
        categorytitleerror.value = false
    }

    loading.value = true
    const response = await axios.post('/admin/create-categories', form.value);
    if (response.status == 200) {
        ElNotification({
            title: 'Success',
            message: 'Category created successfully',
            type: 'success',
        });
        loading.value = false
        dialogVisible.value = false
        getAllCategories()
    } else {
        ElNotification({
            title: 'Error',
            message: 'An error occured. Please try again',
            type: 'error',
        });
        loading.value = false
        dialogVisible.value = false
        getAllCategories()
    }
    loading.value = false
    getAllCategories()
};

const updateCategory = async () => {

    if (form.value.title == null || form.value.title == '') {
        ElNotification({
            title: 'Error',
            message: 'Category name is required',
            type: 'error',
        });
        categorytitleerror.value = true
        return
    } else {
        categorytitleerror.value = false
    }

    loading.value = true
    const response = await axios.post(`/admin/update-categories/${form.value.id}`, form.value);
    if (response.status == 200) {
        ElNotification({
            title: 'Success',
            message: 'Category updated successfully',
            type: 'success',
        });
        loading.value = false
        dialogVisible.value = false
        getAllCategories()
    } else {
        ElNotification({
            title: 'Error',
            message: 'An error occured. Please try again',
            type: 'error',
        });
        loading.value = false
        dialogVisible.value = false
        getAllCategories()
    }
    loading.value = false
    getAllCategories()
};

const deleteCategory = async (categoryId) => {
    try {
        const response = await ElMessageBox.confirm('Are you sure you want to delete this category?', 'Warning', {
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            type: 'warning',
        });

        if (response === 'confirm') {
            await axios.delete(`/admin/destroy-categories/${categoryId}`);
            categories.value = categories.value.filter((category) => category.id !== categoryId);
            ElNotification({
                title: 'Success',
                message: 'Category deleted successfully',
                type: 'success',
            });
            getAllCategories()
        }
    } catch (error) {
        console.error(error);
        getAllCategories()
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

onMounted(() => {
    getAllCategories();
});
</script>

<style scoped>
.is-invalid {
    border: 2px solid red;
    border-radius: 5px;
}
</style>
  