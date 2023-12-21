<template>
    <div class="profile-container">
        <h1>My Profile</h1>

        <div class="profile-info">
            <div class="profile-right">
                <div class="profile-data">
                    <img src="../../../../img/avatar.jpg" alt="User Image" />

                    <Card :style="{ 'max-width': '200px' }">
                        <template #header>
                            <img alt="user header" src="../../../../img/inventory.png" />
                        </template>
                        <template #title><center>Inventory</center></template>
                        <template #content>
                            <div class="card-content">
                                <p class="m-0">
                                    <center><b>{{ formatNumber(0) }}</b></center>
                                </p>
                            </div>
                        </template>
                    </Card>
                    <Card style="max-width: 200px;">
                        <template #header>
                            <img alt="user header" src="../../../../img/transaction.jpg" />
                        </template>
                        <template #title>Transaction</template>
                        <template #content>
                            <div class="card-content">
                                <p class="m-0">
                                    <center><b>{{ formatNumber(0) }}</b></center>
                                </p>
                            </div>
                        </template>
                    </Card>
                </div>
            </div>
        </div>

        <div class="profile-info">
            <div class="profile-right">
                <div class="profile-data">
                    <p><strong>Name:</strong></p>
                    <p><b>{{ user.name }}</b></p>
                </div>
                <div class="profile-data">
                    <p><strong>Email:</strong></p>
                    <p><b>{{ user.email }}</b></p>
                </div>

                <div class="profile-data">
                    <p><strong>All time spent:</strong></p>
                    <p><b>{{ 0 }} <img src="../../../../img/goldCoin.png" alt="Custom Icon" class="custom-icon"/></b></p>
                </div>

                <div class="profile-data">
                    <p><strong>All time gained:</strong></p>
                    <p><b>{{ 0 }} <img src="../../../../img/goldCoin.png" alt="Custom Icon" class="custom-icon"/></b></p>
                </div>

                <div class="profile-data">
                    <p><strong>All time Profit:</strong></p>
                    <p><b>{{ 0 }} <img src="../../../../img/goldCoin.png" alt="Custom Icon" class="custom-icon"/></b></p>
                </div>

                <div class="profile-data">
                    <p><strong>Inventory Value:</strong></p>
                    <p><b>{{ formatNumber(user.inventoryWorth) }} <img src="../../../../img/goldCoin.png" alt="Custom Icon" class="custom-icon"/></b></p>
                </div>

                <div class="profile-data">
                    <p><strong>Balance:</strong></p>
                    <p><b>{{ formatNumber(user.balance) }} <img src="../../../../img/goldCoin.png" alt="Custom Icon" class="custom-icon"/></b></p>
                </div>
                <br><br>

                <div class="profile-data">
                    <p><strong>Account Value:</strong></p>
                    <p><b>{{ formatNumber(user.balance + user.inventoryWorth) }} </b><img src="../../../../img/goldCoin.png" alt="Custom Icon" class="custom-icon"/></p>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import Card from 'primevue/card';

const user = ref({});

const fetchProfile = async () => {
    try {
        const response = await axios.get(`http://localhost:8000/api/profile/${useRoute().params.id}`);
        user.value = response.data;
    } catch (error) {
        console.error(error);
    }
};

onMounted(() => {
    fetchProfile();
});

const formatNumber = (number) => {
    return parseFloat(number).toLocaleString('en-US', { maximumFractionDigits: 2 });
};
</script>
  
<style scoped>
@import '@fortawesome/fontawesome-free/css/all.css';
.profile-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.profile-info {
    margin-top: 20px;
    display: flex;
    align-items: center;
}

.profile-left {
    margin-right: 20px;
}

.profile-right {
    flex-grow: 1;
}

.profile-data {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}


.profile-info p {
    margin: 0;
    /* Reset margin for paragraphs */
}

img.custom-icon {
  width: 24px; 
  height: 28px; 
 
}
</style>
  