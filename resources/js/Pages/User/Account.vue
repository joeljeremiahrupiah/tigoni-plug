<template>
    <div class="page-wrapper">
        <user-header></user-header>

        <div class="container mt-4">
            <h1 class="mb-4">Account</h1>

            <div class="row">
                <div class="col-md-12 mb-4">
                    <el-tabs v-model="activeTab" tab-position="left" class="account-tabs">
                        <el-tab-pane label="Orders">
                            <el-card class="box-card">
                                <template #header>
                                    <div class="card-header">
                                        <span>Edit Orders</span>
                                    </div>
                                </template>
                            </el-card>
                        </el-tab-pane>
                        <el-tab-pane label="Details">
                            <el-card class="box-card">
                                <template #header>
                                    <div class="card-header">
                                        <span>Edit Details</span>
                                    </div>
                                </template>
                            </el-card>
                        </el-tab-pane>
                        <el-tab-pane label="Settings">
                            <el-card class="box-card">
                                <template #header>
                                    <div class="card-header">
                                        <span>Edit Settings</span>
                                    </div>
                                </template>
                            </el-card>
                        </el-tab-pane>
                    </el-tabs>
                </div>

            </div>
        </div>

        <user-footer></user-footer>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import UserHeader from '../inc/Header.vue';
import UserFooter from '../inc/Footer.vue';

const activeTab = ref('Orders'); 
</script>

<style scoped>
.account-tabs {
    background-color: #f8f9fa;
}

.tab-content {
    background-color: #ffffff;
    padding: 20px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

@media (max-width: 767px) {
    .account-tabs {
        tab-position: top;
    }

    .col-lg-3 {
        width: 100%;
        margin-bottom: 20px;
    }
}
</style>
