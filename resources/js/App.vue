<template>
    <div id="app" class="container">
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #64B2B3;">
            <div class="collapse navbar-collapse">
                <img src="../img/logotipo.png" width="10%" />
                <router-link to="/" class="btn btn-success" style="margin-right: 5px;" data-toggle="tooltip"
                    title="Home page">
                    <b>Home</b>
                </router-link>

                <div v-if="isLoggedIn && isUserAdmin" class="navbar-nav">
                    <router-link to="/users" class="btn btn-outline-light" style="margin-right: 5px;" data-toggle="tooltip"
                        title="List of all users"><b>Users</b>
                    </router-link>
                    <router-link to="/items" class="btn btn-outline-light" style="margin-right: 5px;" data-toggle="tooltip"
                        title="List of all items"><b>Items</b>
                    </router-link>
                    <router-link to="/categories" class="btn btn-outline-light" style="margin-right: 5px;"
                        data-toggle="tooltip" title="Available item categories"><b>Categories</b>
                    </router-link>
                    <router-link to="/types" class="btn btn-outline-light" style="margin-right: 5px;" data-toggle="tooltip"
                        title="Available item types"><b>Types</b>
                    </router-link>
                    <router-link to="/inventories" class="btn btn-outline-light" style="margin-right: 5px;"
                        data-toggle="tooltip" title="Users inventories"><b>Inventories</b>
                    </router-link>
                    <router-link to="/transactions" class="btn btn-outline-light" style="margin-right: 5px;"
                        data-toggle="tooltip" title="List of all transactions"><b>Transactions</b>
                    </router-link>
                </div>

                <div v-if="isLoggedIn && !isUserAdmin" class="navbar-nav">
                    <router-link :to="'/profile/' + userId" class="btn btn-outline-light" style="margin-right: 5px;"
                        data-toggle="tooltip" title="My profile">
                        <b>Profile</b>
                    </router-link>

                    <router-link :to="'/inventory/' + userId" class="btn btn-outline-light" style="margin-right: 5px;"
                        data-toggle="tooltip" title="My inventory"><b>Inventory</b>
                    </router-link>
                    <router-link :to="`/transaction/${userId}`" class="btn btn-outline-light" style="margin-right: 5px;"
                        data-toggle="tooltip" title="My transactions">
                        <b>Transactions</b>
                    </router-link>

                    <router-link to="#" class="btn btn-outline-light" style="margin-right: 5px;" data-toggle="tooltip"
                        title="List of all items"><b>Item List</b>
                    </router-link>

                </div>


                <div style="margin-left: auto; margin-right: 20px;" v-if="isLoggedIn && !isUserAdmin">
                    <div
                        style="background-color: #2A768D; padding: 0px 15px; display: flex; align-items: center; border-radius: 30px;">
                        <img src="../img/goldCoin.png" style="vertical-align: middle;" />
                        <p style="margin-left: 10px; margin-top: 10px; color: white; font-size: 19px; align-self: center; font-family: cursive;"
                            data-toggle="tooltip" title="100,000 gold">
                            {{ formatNumber(getUserBalance()) }}
                        </p>
                    </div>

                </div>
            </div>

            <div v-if="!isLoggedIn" style="display: flex;">
                <router-link class="btn btn-light" to="/login" style="margin-right: 5px;"><b>Login</b></router-link>
                <router-link class="btn btn-warning" to="/register"
                    style="margin-right: 20px;"><b>Register</b></router-link>
            </div>

            <button v-if="isLoggedIn" class="btn btn-danger" @click="logout"
                style="margin-right: 20px;"><b>Logout</b></button>
        </nav>

        <router-view></router-view>

        <footer style="background-color: #64B2B3; color: #fff; padding: 10px; text-align: center;">
            <p><b>Developed by: Amin Otaku</b> <img src="../img/aminOtaku.png" width="7%" /></p>
            <p><b>&copy; 2023 MiniMania Tracker. All rights reserved.</b></p>
        </footer>
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
const users = ref([]);
const userId = ref(null);

const checkAuthStatus = () => {
    isLoggedIn.value = localStorage.getItem('token') !== null;
    isUserAdmin.value = localStorage.getItem('role') === CryptoJS.SHA256('0').toString();
};

const getUserBalance = () => {
    const userName = localStorage.getItem('user');
    const user = users.value.find((t) => t.name === userName);
    userId.value = user ? user.id : null;
    return user ? user.balance : "";
}

const getUserInventory = () => {

}

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
        localStorage.removeItem('id');
        checkAuthStatus();
        router.push('/login');

    } catch (err) {
        console.error(err);
        alert(err);
    }
};

const formatNumber = (number) => {
    return parseFloat(number).toLocaleString('en-US', { maximumFractionDigits: 2 });
};

const getusers = async () => {
    try {
        const response = await axios.get('http://localhost:8000/api/users');
        users.value = response.data;

        console.log(users.value);
    } catch (error) {
        console.log(error);
    }
};

onMounted(() => {
    checkAuthStatus();
    getusers();
});
</script>
<style scoped>
#app {
    background: rgba(255, 255, 255, 0.3) url('../img/background.png') center/cover no-repeat fixed;

    height: 100vh;
    /* Make sure the background covers the entire viewport height */
}
</style>