<template>
    <div className="col-md-6 offset-md-3 border rounded p-4 mt-2 shadow">



        <Toast ref="toastRef" />
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container-fluid">
                <button type="button" class="btn btn-outline-light" @click="load()">
                    <span style="color: rgb(0, 0, 0)">
                        <i class="fa-solid fa-square-plus"></i>
                    </span>
                    New Transaction
                </button>
            </div>
        </nav>

        <form>
            <Dialog v-model:visible="visible">
                <h3 class="text-center">Add Item</h3>

                <div class="mb-3" v-if="isUserAdmin()">
                    <label for="user" class="form-label">User</label>
                    <input list="brow" class="form-select" v-model="transaction.userId">
                    <datalist id="brow">
                        <option v-for="userOption in userOptions" :key="userOption.id" :value="userOption.name">
                            {{ userOption.name }}
                        </option>
                    </datalist>
                </div>


                <div class="mb-3" v-if="!isUserAdmin()">
                    <label for="userId" class="form-label">User</label>
                    <input type="text" class="form-control" id="userId" :value="userName" disabled>
                </div>

                <div class="mb-3">
                    <label for="item" class="form-label">Item Name English</label>
                    <input list="nameEn" class="form-select" id="item" v-model="transaction.itemId">
                    <datalist id="nameEn">
                        <option v-for="itemOption in itemOptions" :key="itemOption.idEn" :value="itemOption.nameEn">
                            {{ itemOption.nameEn }}
                        </option>
                    </datalist>
                  
                </div>

                <div class="mb-3">
                    <label for="item1" class="form-label">Item Name Portuguese</label>
                    <input list="namePt" class="form-select" id="item1" v-model="transaction.itemId">
                    <datalist id="namePt">  
                    <option v-for="itemOption in itemOptions" :key="itemOption.idPt" :value="itemOption.namePt">
                            {{ itemOption.namePt }}
                        </option>
                    </datalist>
                </div>

                <div class="mb-3">
                    <label for="nameEn" class="form-label">Bought Price</label>
                    <input type="text" class="form-control" id="nameEn" v-model="transaction.boughtPrice">
                </div>

                <div class="mb-3">
                    <label for="namePt" class="form-label">Sold Price</label>
                    <input type="text" class="form-control" id="namePt" v-model="transaction.SoldPrice">
                </div>


                <button type="submit" class="btn btn-outline-primary" @click="addTransaction">
                    Save
                </button>
                <router-link to="/transactions" class="btn btn-outline-danger mx-2" @click="cancel">
                    Cancel
                </router-link>
            </Dialog>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRouter } from 'vue-router';
import Dialog from 'primevue/dialog';
import Toast from 'primevue/toast';
import CryptoJS from 'crypto-js';

const router = useRouter()
import axios from 'axios';
const visible = ref(false);
const toastRef = ref(null);
const userName = localStorage.getItem('user');
const userId = ref(null);

const transaction = ref({
    boughtPrice: "",
    SoldPrice: "",
    itemId: "",
    userId: ""
});

const itemOptions = ref([]);
const userOptions = ref([]);

onMounted(async () => {
    const itemResponse = await axios.get("http://localhost:8000/api/items");
    itemOptions.value = itemResponse.data;

    const userResponse = await axios.get("http://localhost:8000/api/users");
    userOptions.value = userResponse.data;


});

const addTransaction = async () => {

    try {
        if (transaction.value.userId === '') {
           
            transaction.value.userId = userId.value;
        }else if (/^[a-zA-Z]+$/.test(transaction.value.userId)){
            transaction.value.userId = getUserId(transaction.value.userId);
        }
    
        if (/^[a-zA-Z\s]+$/.test(transaction.value.itemId)) {
            console.log(transaction.value.itemId);
            transaction.value.itemId = getItemId(transaction.value.itemId);
            console.log(transaction.value.itemId);
        }
       console.log(transaction.value);
        await axios.post("http://localhost:8000/api/transactions/", transaction.value);

        visible.value = false;
        toastRef.value.add({ severity: 'success', summary: 'Successful', detail: 'Transaction Added', life: 3000 });

        await router.go(0);
        console.log(transaction.value);
    } catch (error) {
        console.error(error);
    }
}

const getUserId = (name) => {
    const user = userOptions.value.find((t) => t.name === name);
    return user ? user.id : "";
};

const getItemId = (name) => {
    const item = itemOptions.value.find((t) => t.nameEn === name || t.namePt === name);
    return item ? item.id : "";
};

const isUserAdmin = () => {
    return localStorage.getItem('role') === CryptoJS.SHA256('0').toString();
};

const cancel = () => {
    visible.value = false;
}

const load = async () => {
    userId.value = await getUserId(userName);
    visible.value = true;
}

</script>

<style scoped>
@import '@fortawesome/fontawesome-free/css/all.css';
</style>
