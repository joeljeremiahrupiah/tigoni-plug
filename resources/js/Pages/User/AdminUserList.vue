<template>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">

        <div class="page-body">
            <div class="container-xl">

                <el-card class="box-card">
                    <template #header>
                        <div class="card-header d-flex justify-content-between">

                            <div class="az-content-label mg-b-5">Users List</div>
                            <!-- <div>
                                <el-button @click.prevent="createCategoryModal">Create Category</el-button>
                            </div> -->

                        </div>
                    </template>

                    <div class="table-responsive">
                        <table class="table table-hover mg-b-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User name</th>
                                    <th>User email</th>
                                    <th>Date Created</th>
                                    <th>Type</th>
                                    <th>Section</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in store?.users" :key="user.id">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.user_type }}</td>
                                    <td>{{ user.company_type }}</td>
                                    <td>{{ moment(user.created_at).format('DD-MM-YYYY') }}</td>
                                    <td>
                                        <el-button type="warning" @click="openEdituserModal(user)"
                                            size="small">Edit</el-button>
                                        <el-button type="danger" @click="deleteuser(user.id)"
                                            size="small">Delete</el-button>
                                        <el-button type="info" @click="changeUserStatus(user.id)" size="small"
                                            v-show="user.status == 'false'">Activate</el-button>
                                        <el-button type="primary" @click="changeUserStatus(user.id)" size="small"
                                            v-show="user.status == 'true'">Deactivate</el-button>
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
                    <el-input v-model="form.title" />
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
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user.js'
import moment from "moment"

const router = useRouter()
const store = useUserStore()

let users = ref([]);

const getAllUsers = async () => {
    try {
        const response = await axios.get('/admin/get-users');
        store.users = response.data.users
    } catch (error) {
        console.error(error);
    }
};

const changeUserStatus = async (id) => {
    let response = await axios.post(`/admin/update-user-status/${id}`)
    if (response.status == 200) {
        store.users = response.data.users
    }
}

onMounted(() => {
    getAllUsers();
});
</script>
  