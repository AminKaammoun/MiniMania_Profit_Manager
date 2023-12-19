<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <router-link to="/" class="btn btn-secondary">Home</router-link>
                <div v-if="isLoggedIn && isUserAdmin" class="navbar-nav">
                    <router-link to="/users" class="btn btn-primary">Users</router-link>
                    <router-link to="/items" class="btn btn-primary">Items</router-link>
                    <router-link to="/categories" class="btn btn-primary">Categories</router-link>
                    <router-link to="/types" class="btn btn-primary">Types</router-link>
                    <router-link to="/inventories" class="btn btn-primary">Inventories</router-link>
                    <router-link to="/transactions" class="btn btn-primary">Transactions</router-link>
                </div>
            </div>

            <div v-if="!isLoggedIn">
                <router-link class="btn btn-secondary" to="/login">Login</router-link>
                <router-link class="btn btn-secondary" to="/register">Register</router-link>
            </div>

            <button v-if="isLoggedIn" class="btn btn-danger" @click="logout">Logout</button>
        </nav>

        <router-view></router-view>
    </div>
</template>
  
<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import CryptoJS from 'crypto-js';

const isLoggedIn = ref(false);
const isUserAdmin = ref(false);
const router = useRouter();

const checkAuthStatus = () => {
    isLoggedIn.value = localStorage.getItem('token') !== null;
    isUserAdmin.value = localStorage.getItem('role') === CryptoJS.SHA256(0).toString();
};

const logout = async () => {
    const token = localStorage.getItem('token');

    try {
        await axios.post('http://localhost:8000/api/logout', null, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        console.log('Logout successful');
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        localStorage.removeItem('role');
        checkAuthStatus();
        router.push('/login');
        
    } catch (err) {
        console.error(err);
        alert(err);
    }
};

onMounted(() => {
   
    checkAuthStatus();
});
</script>
