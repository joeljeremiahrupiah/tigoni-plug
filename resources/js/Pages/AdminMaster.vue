<template>
    <div id="admin_master">
        <div class="wrapper">
            <admin-header
                v-if="!['admin-login', 'admin-register', 'vendor-login', 'vendor-register', 'vendor-setup'].includes($route.name)"></admin-header>
            <admin-navbar
                v-if="!['admin-login', 'admin-register', 'vendor-login', 'vendor-register', 'vendor-setup'].includes($route.name)"></admin-navbar>
            <div class="page-wrapper">
                <router-view></router-view>
                <admin-footer
                    v-if="!['admin-login', 'admin-register', 'vendor-login', 'vendor-register', 'vendor-setup'].includes($route.name)"></admin-footer>
            </div>
        </div>
    </div>
</template>
  
<script>
import AdminHeader from './inc/AdminHeader.vue'
import AdminNavbar from './inc/AdminNavbar.vue'
import AdminFooter from './inc/AdminFooter.vue'
export default {
    name: 'AdminMaster',
    components: {
        AdminHeader,
        AdminNavbar,
        AdminFooter
    }
}
</script>