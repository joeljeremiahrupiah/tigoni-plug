<template>
    <div class="container-fluid">

        <el-card class="box-card">
            <template #header>
                <div class="card-header">
                    <span>Chats</span>
                </div>
            </template>

            <div class="card-header">
                <div class="container-fluid mt-4">
                    <div class="row">

                        <div class="col-md-4 bg-white">

                            <ul class="friend-list">
                                <li v-for="chat in chatStore?.adminchats" :key="chat.id"
                                    :class="{ 'active bounceInDown': chat?.id === chatStore?.latestchat?.id }"
                                    @click="selectChat(chat)">
                                    <a href="#" class="clearfix">
                                        <img :src="brokerLogo(chat?.vendor?.logo)" alt="" class="img-circle">
                                        <div class="friend-name">
                                            <strong>{{ chat?.vendor?.name }}</strong>
                                        </div>
                                        <div class="last-message text-muted">{{ chat?.product?.title }}</div>
                                        <small class="time text-muted">{{ formatTime(chat?.created_at) }}</small>
                                    </a>
                                </li>
                            </ul>

                        </div>

                        <div class="col-md-8 bg-white">

                            <div class="chat-message">
                                <ul class="chat">
                                    <li v-for="(message, index) in chatStore?.adminlatestchat?.messages" :key="index"
                                        :class="{ 'left': message?.user?.user_type === 'customer', 'right': message?.user?.user_type !== 'customer' }"
                                        class="clearfix">
                                        <span
                                            :class="{ 'chat-img pull-left': message?.user?.user_type === 'customer', 'chat-img pull-right': message?.user?.user_type !== 'customer' }">
                                            <img :src="messageLogo(message?.user?.logo)" alt="User Avatar">
                                        </span>
                                        <div class="chat-body clearfix">
                                            <div class="header">
                                                <strong class="primary-font">{{ message?.user?.name }}</strong>
                                                <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> {{
                                                    formatMessageDateTime(message?.created_at) }}</small>
                                            </div>
                                            <p>{{ message?.content }}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>




                            <div class="chat-box bg-white">
                                <div class="input-group">
                                    <input v-model="newMessage" class="form-control border no-shadow no-rounded"
                                        placeholder="Type your message here">
                                    <span class="input-group-btn">
                                        <button @click.prevent="sendMessage" class="btn btn-success no-rounded"
                                            type="button">Send</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </el-card>
    </div>
</template>
  
<script setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user.js'
import { useCategoryStore } from '@/stores/category.js'
import { useProductStore } from '@/stores/product.js'
import { useChatStore } from '@/stores/chat.js'
import axios from 'axios';
import moment from 'moment';


const product = ref(null);
const user = ref(null);

let error = ref('')

const router = useRouter()
const store = useUserStore()
const categoryStore = useCategoryStore()
const productStore = useProductStore()
const chatStore = useChatStore()

let route = useRoute()
const newMessage = ref('');
const chartid = ref(null)

const brokerLogo = (name) => {
    return '/storage/' + name
}

const messageLogo = (name) => {
    return '/storage/' + name
}

const formatTime = (time) => {
    return moment(time).format('MMMM Do YYYY, h:mm:ss a');
}

const formatMessageDateTime = (time) => {
    return moment(time).format('MMMM Do YYYY, h:mm:ss a');
}

const selectChat = (chart) => {
    chartid.value = chart.id
    chatStore.latestchat = chart
}

const fetchChatData = async () => {
    chatStore.chats = null
    chatStore.latestchat = null
    try {
        const response = await axios.get(`/admin/get-admin-chat-data/${store?.authuser?.id}`);
        if (response.status == 200) {
            user.value = response.data.adminUser;
            chatStore.adminchats = response.data.chats
            chatStore.adminlatestchat = response.data.latestChat
        } else if (response.status == 203) {
            error.value = response.data.error
        }

    } catch (error) {
        console.error('Error fetching chat data:', error);
    }
};

Echo.private("chat").listen("MessageSent", (e) => {
    console.log(e)
    messages.push({
        message: e.message.message,
        user: e.user,
    });
});

onMounted(() => {
    fetchChatData();
});

</script>
  
<style scoped>
body {
    padding-top: 0;
    font-size: 12px;
    color: #777;
    background: #f9f9f9;
    font-family: 'Open Sans', sans-serif;
    margin-top: 20px;
}

.friend-list {
    max-height: 400px;
    /* Adjust the max height as needed */
    overflow-y: auto;
}

.chat-message {
    max-height: 400px;
    /* Adjust the max height as needed */
    overflow-y: auto;
}

.bg-white {
    background-color: #fff;
}

.friend-list {
    list-style: none;
    margin-left: -40px;
}

.friend-list li {
    border-bottom: 1px solid #eee;
}

.friend-list li a img {
    float: left;
    width: 45px;
    height: 45px;
    margin-right: 10px;
}

.friend-list li a {
    position: relative;
    display: block;
    padding: 10px;
    transition: all .2s ease;
    -webkit-transition: all .2s ease;
    -moz-transition: all .2s ease;
    -ms-transition: all .2s ease;
    -o-transition: all .2s ease;
}

.friend-list li.active a {
    background-color: #f1f5fc;
}

.friend-list li a .friend-name,
.friend-list li a .friend-name:hover {
    color: #777;
}

.friend-list li a .last-message {
    width: 65%;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}

.friend-list li a .time {
    position: absolute;
    top: 10px;
    right: 8px;
}

small,
.small {
    font-size: 85%;
}

.friend-list li a .chat-alert {
    position: absolute;
    right: 8px;
    top: 27px;
    font-size: 10px;
    padding: 3px 5px;
}

.chat-message {
    padding: 60px 20px 115px;
}

.chat {
    list-style: none;
    margin: 0;
}

.chat-message {
    background: #f9f9f9;
}

.chat li img {
    width: 45px;
    height: 45px;
    border-radius: 50em;
    -moz-border-radius: 50em;
    -webkit-border-radius: 50em;
}

img {
    max-width: 100%;
}

.chat-body {
    padding-bottom: 20px;
}

.chat li.left .chat-body {
    margin-left: 70px;
    background-color: #fff;
}

.chat li .chat-body {
    position: relative;
    font-size: 11px;
    padding: 10px;
    border: 1px solid #f1f5fc;
    box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
    -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
}

.chat li .chat-body .header {
    padding-bottom: 5px;
    border-bottom: 1px solid #f1f5fc;
}

.chat li .chat-body p {
    margin: 0;
}

.chat li.left .chat-body:before {
    position: absolute;
    top: 10px;
    left: -8px;
    display: inline-block;
    background: #fff;
    width: 16px;
    height: 16px;
    border-top: 1px solid #f1f5fc;
    border-left: 1px solid #f1f5fc;
    content: '';
    transform: rotate(-45deg);
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    -o-transform: rotate(-45deg);
}

.chat li.right .chat-body:before {
    position: absolute;
    top: 10px;
    right: -8px;
    display: inline-block;
    background: #fff;
    width: 16px;
    height: 16px;
    border-top: 1px solid #f1f5fc;
    border-right: 1px solid #f1f5fc;
    content: '';
    transform: rotate(45deg);
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
}

.chat li {
    margin: 15px 0;
}

.chat li.right .chat-body {
    margin-right: 70px;
    background-color: #fff;
}

.chat-box {
    /*
  position: fixed;
  bottom: 0;
  left: 444px;
  right: 0;
*/
    padding: 15px;
    border-top: 1px solid #eee;
    transition: all .5s ease;
    -webkit-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -ms-transition: all .5s ease;
    -o-transition: all .5s ease;
}

.primary-font {
    color: #3c8dbc;
}

a:hover,
a:active,
a:focus {
    text-decoration: none;
    outline: 0;
}
</style>
