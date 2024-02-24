<template>
  <div id="admin_navbar">
    <div class="navbar-expand-md">
      <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
          <div class="container-xl">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="/admin">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                      stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <polyline points="5 12 3 12 12 3 21 12 19 12" />
                      <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                      <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                    </svg>
                  </span>
                  <span class="nav-link-title">
                    Home
                  </span>
                </a>
              </li>
              <li class="nav-item dropdown" v-show="store?.authuser?.user_type == 'admin'">
                <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                  data-bs-auto-close="outside" role="button" aria-expanded="false">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                      stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <circle cx="9" cy="7" r="4" />
                      <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                      <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                      <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                    </svg>
                  </span>
                  <span class="nav-link-title">
                    User Management
                  </span>
                </a>
                <div class="dropdown-menu">
                  <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column" v-show="store?.authuser?.user_type == 'admin'">
                      <router-link class="dropdown-item" :to="{ name: 'admin-users' }">
                        Users List
                      </router-link>
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                  data-bs-auto-close="outside" role="button" aria-expanded="false">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                      stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <rect x="4" y="4" width="6" height="6" rx="1" />
                      <rect x="14" y="4" width="6" height="6" rx="1" />
                      <rect x="4" y="14" width="6" height="6" rx="1" />
                      <path d="M14 17h6m-3 -3v6" />
                    </svg>
                  </span>
                  <span class="nav-link-title">
                    Product Management
                  </span>
                </a>
                <div class="dropdown-menu">
                  <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column" v-show="store?.authuser?.user_type == 'admin'">
                      <router-link class="dropdown-item" :to="{ name: 'admin-categories' }">
                        Category List
                      </router-link>
                    </div>
                    <div class="dropdown-menu-column">

                      <router-link class="dropdown-item" :to="{ name: 'admin-products' }">
                        Product List
                      </router-link>

                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'admin-chat' }">
                  <span class="nav-link-title">
                    Chats
                  </span>
                </router-link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user.js'

const router = useRouter()
const store = useUserStore()
</script>