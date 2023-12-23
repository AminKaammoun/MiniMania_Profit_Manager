<template>
    <div>
        <Toast ref="toastRef" />
        <button type="button" class="btn btn-outline-info" @click="load">

            <i class="fa-solid fa-pen-to-square"></i>Edit

        </button>

        <form>
            <Dialog v-model:visible="visible">
                <h3 class="text-center">Edit Transaction</h3>
               
                <div class="form-group" v-if="isUserAdmin">
                    <label for="user" class="form-label">User</label>
                    <select class="form-select" id="user" v-model="transactions.userId">
                        <option v-for="userOption in users" :key="userOption.id" :value="userOption.id">
                            {{ userOption.name }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="item" class="form-label">Item Name English</label>
                    <select class="form-select" id="item" v-model="transactions.itemId">
                        <option v-for="itemOption in items" :key="itemOption.id" :value="itemOption.id">
                            {{ itemOption.nameEn }}
                        </option>
                    </select>
                </div>
                

                <div class="form-group">
                    <label for="item1" class="form-label">Item Name Portuguese</label>
                    <select class="form-select" id="item1" v-model="transactions.itemId">
                        <option v-for="itemOption in items" :key="itemOption.id" :value="itemOption.id">
                            {{ itemOption.namePt }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nameEn" class="form-label">Bought Price</label>
                    <input type="text" class="form-control" id="nameEn" v-model="transactions.boughtPrice">
                </div>

                <div class="form-group">
                    <label for="namePt" class="form-label">Sold Price</label>
                    <input type="text" class="form-control" id="namePt" v-model="transactions.SoldPrice">
                </div>

                <br>
                <button type="submit" class="btn btn-outline-primary mx- 2" @click="updateTransaction"><i
                        class="fa-solid fa-floppy-disk"></i> Update</button>
                <button type="button" class="btn btn-outline-danger mx- 2" @click="cancel"> <i class="fa-solid fa-ban"></i>
                    Cancel</button>
            </Dialog>
        </form>


    </div>
</template>
    
<script setup>
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';
import Dialog from 'primevue/dialog';
import Toast from 'primevue/toast'; 
import CryptoJS from 'crypto-js';

const router = useRouter();

import { ref, onMounted } from 'vue';

const toastRef = ref(null);
const transactions = ref([])
const users = ref([])
const items = ref([])
const visible = ref(false);
const props = defineProps(['tra'])
const isUserAdmin = ref(false);


const cancel = () => {
    visible.value = false;
};

const fetchTransaction = async () => {

    transactions.value = props.tra;

}


const getusers = async () => {
    await axios.get("http://localhost:8000/api/users")
        .then(res => {
            users.value = res.data
            console.log(users.value)
        })
        .catch(error => {
            console.log(error)
        })
}
const getitems = async () => {
    await axios.get("http://localhost:8000/api/items")
        .then(res => {
            items.value = res.data
            console.log(items.value)
        })
        .catch(error => {
            console.log(error)
        })
}

const load = async () => {
    visible.value = true;
    getitems();
    getusers();
    await fetchTransaction();
}

const checkAuthStatus = () => {
    
    isUserAdmin.value = localStorage.getItem('role') === CryptoJS.SHA256('0').toString();
};
const updateTransaction = async () => {
    await axios

        .patch(`http://localhost:8000/api/transactions/${transactions.value.id}`, transactions.value)

        .then(() => {
            visible.value = false;
            toastRef.value.add({ severity: 'info', summary: 'Updated', detail: 'Transaction Updated', life: 3000 });
            router.go(0);
        })
        .catch((err) => { console.error(err) 
            toastRef.value.add({ severity: 'error', summary: 'Error', detail: 'Transaction can not be deleted', life: 3000 });
        })
}
onMounted(() => {
    checkAuthStatus();
});

</script>
<style lang="scss" scoped>
@import '@fortawesome/fontawesome-free/css/all.css';
</style>