<template>
    <div class="multistep-form-container">
        <div class="step-navigation">
            <div v-for="step in totalSteps" :key="step"
                :class="['step', { active: currentStep === step, completed: currentStep > step }]">
                <div class="step-number">{{ step }}</div>
                <div class="step-label">{{ stepLabels[step - 1] }}</div>
            </div>
        </div>
        <div v-if="currentStep === 1" class="step-container">
            <h2>User Details</h2>
            <form @submit.prevent="nextStep">

                <div class="form-group mt-3">
                    <label>Select Company Type</label>
                    <el-radio-group v-model="formOne.company_type">
                        <el-radio label="Company">Company</el-radio>
                        <el-radio label="Individual">Individual</el-radio>
                    </el-radio-group>
                </div>

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" v-model="formOne.fullname" placeholder="Enter your name" />
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" v-model="formOne.email" placeholder="Enter your email" />
                </div>

                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" v-model="formOne.phoneOne" placeholder="Enter your phone number" />
                </div>

                <div class="form-group">
                    <label for="phone">Another Phone:</label>
                    <input type="text" v-model="formOne.phoneTwo" placeholder="Enter your phone number" />
                </div>


                <button type="submit" class="next-button">Next</button>
            </form>
        </div>

        <div v-if="currentStep === 2" class="step-container-two">

            <h2>Payment Step</h2>

            <form>
                <iframe :src="pesapalLink" v-if="pesapalLink" style="width:100%;height: 500px"></iframe>
            </form>

            <!-- <form @submit.prevent="submitForm">
                <div class="form-group">
                    <label for="cardNumber">Card Number:</label>
                    <input type="text" v-model="paymentDetails.cardNumber" placeholder="Enter your card number" />
                </div>

                <div class="form-group">
                    <label for="expirationDate">Expiration Date:</label>
                    <input type="text" v-model="paymentDetails.expirationDate" placeholder="Enter card expiration date" />
                </div>

                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" v-model="paymentDetails.cvv" placeholder="Enter CVV" />
                </div>

                <button type="button" @click="prevStep" class="prev-button">Previous</button>
                <button type="submit" class="submit-button">Submit</button>
            </form> -->
        </div>
    </div>
</template>
  
<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user.js'

const router = useRouter()
const store = useUserStore()

const currentStep = ref(1);

const totalSteps = 2;
const stepLabels = ['User Details', 'Payment Step'];

let pesapalLink = ref(null)

const formOne = ref({
    userid: store?.authuser?.id,
    fullname: store?.authuser?.name,
    email: store?.authuser?.email,
    company_type: store?.authuser?.company_type,
    phoneOne: store?.authuser?.phoneOne,
    phoneTwo: store?.authuser?.phoneTwo,
    logo: store?.authuser?.logo,
})

const userDetails = ref({
    name: '',
    email: '',
    phone: ''
});

const paymentDetails = ref({
    cardNumber: '',
    expirationDate: '',
    cvv: ''
});

const nextStep = async () => {
    let response = await axios.post('/admin/create-user-details', formOne.value)
    if (response.status == 200) {
        store.authuser = response.data.user
        if (response.data.redirect_url) {
            pesapalLink.value = response.data.redirect_url;
            currentStep.value = 2;
        }
    }
};

const prevStep = () => {
    currentStep.value = 1;
};

const submitForm = () => {
    router.push({ name: 'dashboard' })
};
</script>
  
<style scoped>
.multistep-form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.step-container {
    width: 500px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}


.step-container-two {
    width: 50%;
    /* height: 100%; */
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
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

.next-button,
.prev-button,
.submit-button {
    padding: 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.next-button {
    background-color: #3498db;
    color: #fff;
    float: right;
    /* Align to the right */
}

.prev-button {
    background-color: #e74c3c;
    color: #fff;
    float: left;
    /* Align to the left */
    margin-right: 5px;
}

.submit-button {
    background-color: #2ecc71;
    color: #fff;
    float: right;
}

.step-navigation {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.step-number {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #ccc;
    color: #fff;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 5px;
}

.step-label {
    text-align: center;
}

.step.active .step-number {
    background-color: #007bff;
}

.step.completed .step-number {
    background-color: #28a745;
}
</style>