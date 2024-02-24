<template>
    <div class="login-container">

        <!-- <div class="vendor-link">
            <router-link to="/admin/admin-login">Login as admin</router-link>
        </div> -->

        <div class="login-box">
            <h2>Vendor Login</h2>
            <form>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <!-- <input type="text" v-model="form.email" placeholder="Enter your email" required /> -->
                    <el-input v-model="form.email" placeholder="Enter your email" clearable
                        :class="{ 'is-invalid': showEmailError }"></el-input>
                    <span class="text-danger text-sm" v-show="showEmailError">Email is required</span>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <!-- <input type="password" v-model="form.password" placeholder="Enter your password" required /> -->
                    <el-input v-model="form.password" placeholder="Enter your password" password clearable
                        :class="{ 'is-invalid': showPasswordError }" type="password" show-password></el-input>
                    <span class="text-danger text-sm" v-show="showPasswordError">Password is required</span>
                </div>

                <!-- <button type="submit" @click.prevent="loginAdmin">Login</button> -->
                <el-button @click.prevent="loginAdmin" :loading="loading">{{ loading ? 'Processing ... ' : 'Login'
                }}</el-button>
            </form>
            <div class="register-link">
                Don't have an account?
                <router-link to="/admin/vendor-register">Register</router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user.js'
import { ElNotification } from 'element-plus'

const router = useRouter()
const store = useUserStore()

let loading = ref(false)

let showEmailError = ref(false)
let showPasswordError = ref(false)

const form = ref({
    fullname: '',
    email: '',
    password: ''
})

let loginAdmin = async () => {
    if (!form.value.email || form.value.email == '') {
        showEmailError.value = true
        ElNotification({
            title: 'Error',
            message: 'Email is required',
            type: 'error',
        })
        return
    } else {
        showEmailError.value = false
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

    loading.value = true
    let response = await axios.post('/admin/login-vendor', form.value);
    if (response.status === 200) {
        ElNotification({
            title: 'Success',
            message: 'Login successful',
            type: 'success',
        })
        loading.value = false
        const { token, user_type, user } = response.data;
        console.log(user_type)
        localStorage.setItem('token', token);
        store.authuser = user
        store.token = token
        if (user_type === 'vendor') {
            if (user.paid === 'no') {
                router.push({ name: 'vendor-setup' });
            } else {
                // router.push('/admin');
                window.location.href = '/admin'
            }
        } else {
            router.push('/');
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

</script>

<style scoped>
.login-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.vendor-link {
    margin-bottom: 20px;
}

.login-box {
    width: 300px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

button:hover {
    background-color: #2980b9;
}
</style>
