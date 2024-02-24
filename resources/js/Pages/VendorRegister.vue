<template>
    <div class="login-container">
        <div class="login-box">
            <h2>Vendor Register</h2>
            <form @submit.prevent="login">
                <div class="form-group">
                    <label for="username">Full Name:</label>
                    <el-input v-model="form.fullname" placeholder="Enter your full name" clearable
                        :class="{ 'is-invalid': showFullNameError }"></el-input>
                    <span class="text-danger text-sm" v-show="showFullNameError">Full name is required</span>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <el-input v-model="form.email" placeholder="Enter your full name" clearable
                        :class="{ 'is-invalid': showEmailError }"></el-input>
                    <span class="text-danger text-sm" v-show="showEmailError">Email is required</span>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <el-input v-model="form.password" placeholder="" clearable :class="{ 'is-invalid': showPasswordError }"
                        type="password" show-password></el-input>
                    <span class="text-danger text-sm" v-show="showPasswordError">Password is required</span>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password:</label>
                    <el-input v-model="form.password_confirmation" placeholder="" clearable
                        :class="{ 'is-invalid': showPasswordConfirmationError }" type="password" show-password></el-input>
                    <span class="text-danger text-sm" v-show="showPasswordConfirmationError">Password confirmation is
                        required</span>
                </div>

                <span class="text-danger text-sm" v-show="showPasswordAndPasswordConfirmationError">Password and
                    confirmation password do not match</span>

                <el-button @click.prevent="registerAdmin" :loading="loading">{{ loading ? 'Processing ... ' : 'Register'
                }}</el-button>
            </form>
            <div class="register-link">
                Already have an account?
                <router-link to="/admin/vendor-login">Login</router-link>
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

const username = ref('');
const password = ref('');

let showFullNameError = ref(false)
let showEmailError = ref(false)
let showPasswordError = ref(false)
let showPasswordConfirmationError = ref(false)
let showPasswordAndPasswordConfirmationError = ref(false)

let loading = ref(false)

const form = ref({
    fullname: '',
    email: '',
    password: '',
    password_confirmation: ''
})

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


let registerAdmin = async () => {

    if (!form.value.fullname || form.value.fullname == '') {
        showFullNameError.value = true
        ElNotification({
            title: 'Error',
            message: 'Full name is required',
            type: 'error',
        })
        return
    } else {
        showFullNameError.value = false
    }

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
    let response = await axios.post('/admin/register-vendor', form.value);
    if (response.status === 200) {
        const { token, user_type, user } = response.data;
        localStorage.setItem('token', token);
        store.authuser = user
        store.token = token
        if (user_type === 'vendor') {
            if (user.paid === 'no') {
                router.push({ name: 'vendor-setup' });
            } else {
                // router.push({ name: 'dashboard' });
                window.location.href = '/admin'
            }
        } else {
            router.push('/');
        }
        loading.value = false
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
    justify-content: center;
    align-items: center;
    height: 100vh;
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
  