<template>
    <div class="container">
        <h2 class="font-weight-bolder">Profile Information</h2>

        <el-form ref="userInfoForm" label-position="top">
            <el-card class="box-card">
                <el-divider content-position="left">Account (Personal) Details</el-divider>

                <div class="row">
                    <el-col :xs="24" :sm="12" v-show="store?.authuser?.company_type == 'Company'">
                        <el-form-item label="Company Name">
                            <el-input v-model="userInfo.fullname" placeholder=""></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12" v-show="store?.authuser?.company_type == 'Individual'">
                        <el-form-item label="Full Name">
                            <el-input v-model="userInfo.fullname" placeholder=""></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12">
                        <el-form-item label="Company Email" v-show="store?.authuser?.company_type == 'Company'">
                            <el-input v-model="userInfo.email" placeholder=""></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12">
                        <el-form-item label="Email" v-show="store?.authuser?.company_type == 'Individual'">
                            <el-input v-model="userInfo.email" placeholder=""></el-input>
                        </el-form-item>
                    </el-col>
                </div>

                <div class="row">
                    <el-col :xs="24" :sm="12" v-show="store?.authuser?.company_type == 'Company'">
                        <el-form-item label="Company Contact Number ">
                            <el-input v-model="userInfo.phoneOne" placeholder=""></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12" v-show="store?.authuser?.company_type == 'Individual'">
                        <el-form-item label="Phone Number">
                            <el-input v-model="userInfo.phoneOne" placeholder=""></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12" v-show="store?.authuser?.company_type == 'Company'">
                        <el-form-item label="Company Contact Number (optional) ">
                            <el-input v-model="userInfo.phoneTwo" placeholder=""></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12" v-show="store?.authuser?.company_type == 'Individual'">
                        <el-form-item label="Phone Number (optional)">
                            <el-input v-model="userInfo.phoneTwo" placeholder=""></el-input>
                        </el-form-item>
                    </el-col>

                </div>
                <div class="row">
                    <el-col :xs="24" :sm="12">
                        <el-form-item label="Facebook Link">
                            <el-input v-model="userInfo.facebooklink" placeholder=""></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12">
                        <el-form-item label="Twitter Link">
                            <el-input v-model="userInfo.twitterlink" placeholder=""></el-input>
                        </el-form-item>
                    </el-col>

                </div>
                <div class="row">
                    <el-col :xs="24" :sm="12">
                        <el-form-item label="Youtube Link">
                            <el-input v-model="userInfo.youtubelink" placeholder=""></el-input>
                        </el-form-item>
                    </el-col>
                </div>


                <div class="row">
                    <div class="col-md-12 d-flex justify-content-start">
                        <template v-if="store?.authuser?.logo">
                            <div class="demo-image__preview mr-5">
                                <el-image style="width: 150px; height: 150px" :src="imageLink(store?.authuser?.logo)"
                                    :zoom-rate="1.0" :initial-index="0" fit="cover" />
                            </div>
                        </template>
                        <el-upload action="#" list-type="picture-card" :auto-upload="false" :on-change="handleChange">
                            <el-icon>
                                <Plus />
                            </el-icon>
                        </el-upload>
                    </div>
                </div>

                <template #footer>
                    <div class="d-flex justify-content-end">
                        <div class="d-flex justify-content-between">
                            <el-button type="danger" @click="cancelForm">Cancel</el-button>
                            <el-button type="success" @click="saveForm">Save</el-button>
                        </div>
                    </div>
                </template>

            </el-card>

        </el-form>

        <el-dialog v-model="dialogVisible">
            <img w-full :src="dialogImageUrl" alt="Preview Image" />
        </el-dialog>
    </div>
</template>
  
<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user.js'
import { Delete, Download, Plus, ZoomIn } from '@element-plus/icons-vue'
import { ElMessage } from 'element-plus'

const router = useRouter()
const store = useUserStore()

const dialogImageUrl = ref('')
const dialogVisible = ref(false)
const disabled = ref(false)

const userInfo = ref({
    fullname: store?.authuser?.name,
    email: store?.authuser?.email,
    facebooklink: store?.authuser?.facebooklink,
    twitterlink: store?.authuser?.twitterlink,
    youtubelink: store?.authuser?.youtubelink,
    phoneOne: store?.authuser?.phoneOne,
    phoneTwo: store?.authuser?.phoneTwo,
    avatar: store?.authuser?.logo,
});

const cancelForm = () => {
    userInfo.value = {
        fullname: store?.authuser?.name,
        email: store?.authuser?.email,
        facebooklink: store?.authuser?.facebooklink,
        twitterlink: store?.authuser?.twitterlink,
        youtubelink: store?.authuser?.youtubelink,
        phoneOne: store?.authuser?.phoneOne,
        phoneTwo: store?.authuser?.phoneTwo,
        avatar: store?.authuser?.logo,
    };
}

const uploadedFile = ref(null);

const handleChange = (file) => {
    uploadedFile.value = file.raw;
};

const handleRemove = (file) => {
    console.log(file)
}

const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file?.url
    dialogVisible.value = true
}

const handleDownload = (file) => {
    console.log(file)
}

const imageLink = (name) => {
    return "/storage/" + name
}


const saveForm = async () => {
    const requestData = new FormData();

    requestData.append('fullname', userInfo.value.fullname);
    requestData.append('email', userInfo.value.email);
    requestData.append('phoneOne', userInfo.value.phoneOne);
    requestData.append('phoneTwo', userInfo.value.phoneTwo);
    requestData.append('facebooklink', userInfo.value.facebooklink);
    requestData.append('twitterlink', userInfo.value.twitterlink);
    requestData.append('youtubelink', userInfo.value.youtubelink);
    requestData.append('avatar', uploadedFile.value);

    try {
        const response = await axios.post(`/admin/process-profile-information/${store?.authuser?.id}`, requestData);
        if (response.status === 200) {
            uploadedFile.value = null;
            store.authuser.name = response.data.user.name
            store.authuser.email = response.data.user.email
            store.authuser.facebooklink = response.data.user.facebooklink
            store.authuser.twitterlink = response.data.user.twitterlink
            store.authuser.youtubelink = response.data.user.youtubelink
            store.authuser.phoneOne = response.data.user.phoneOne
            store.authuser.phoneTwo = response.data.user.phoneTwo
            store.authuser.logo = response.data.user.logo
        }
    } catch (error) {
        ElMessage.error('An error occured. Please try again.');
    }
};

</script>
  
<style scoped>
.container {
    padding: 20px;
}

.el-divider {
    border-color: #3498db;
    color: #3498db;
    font-weight: bold;
    margin-top: 10px;
    margin-bottom: 20px;
}

.box-card {
    margin-top: 20px;
    padding: 20px;
}

.el-divider {
    margin: 20px 0;
}

.el-button {
    margin-right: 10px;
}

.avatar-uploader .avatar {
    width: 178px;
    height: 178px;
    display: block;
}
</style>
