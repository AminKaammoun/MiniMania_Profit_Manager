<template>
    <div>
        <h3 class="text-center">Edit Item</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateTransaction">
                   
                    <div class="mb-3">
                        <label for="user" class="form-label">User</label>
                        <select class="form-select" id="user" v-model="transactions.userId">
                            <option v-for="userOption in users" :key="userOption.id" :value="userOption.id">
                                {{ userOption.name }}
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="item" class="form-label">Item Name English</label>
                        <select class="form-select" id="item" v-model="transactions.itemId">
                            <option v-for="itemOption in items" :key="itemOption.id" :value="itemOption.id">
                                {{ itemOption.nameEn }}
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="item1" class="form-label">Item Name Portuguese</label>
                        <select class="form-select" id="item1" v-model="transactions.itemId">
                            <option v-for="itemOption in items" :key="itemOption.id" :value="itemOption.id">
                                {{ itemOption.namePt }}
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nameEn" class="form-label">Bought Price</label>
                        <input type="text" class="form-control" id="nameEn" v-model="transactions.boughtPrice">
                    </div>

                    <div class="mb-3">
                        <label for="namePt" class="form-label">Sold Price</label>
                        <input type="text" class="form-control" id="namePt" v-model="transactions.SoldPrice">
                    </div>


                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</template>
    
<script setup>
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';
const router = useRouter();
const route = useRoute();
import { ref, onMounted } from 'vue';
const transactions = ref([])
const users = ref([])
const items = ref([])

const fetchTransaction = async () => {

    await axios
        .get(`http://localhost:8000/api/transactions/${route.params.id}`)
        .then((res) => {
            transactions.value = res.data;
        })
        .catch((err) => { console.error(err) })

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

const updateTransaction = async () => {
    await axios

        .patch(`http://localhost:8000/api/transactions/${route.params.id}`, transactions.value)

        .then(() => {
            router.push({ name: 'ViewTransaction' });
        })
        .catch((err) => { console.error(err) })
}

onMounted(async () => {
    getitems();
    getusers();
    await fetchTransaction();

});
</script>