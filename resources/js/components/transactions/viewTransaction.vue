<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container-fluid">
                <router-link :to="{ name: 'AddTransaction' }" class="btn btn-outline-light">
                    New Transaction
                </router-link>
            </div>
        </nav>
        <div class="py-6">
            <table class="table table-striped shadow">
                <thead class="text-center">
                    <tr>
                        <th>User</th>
                        <th>Image</th>
                        <th>Item Name English</th>
                        <th>Item Name Portuguese</th>
                        <th>Bought Price</th>
                        <th>Sold Price</th>
                        <th>Profit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="transaction in transactions" :key="transaction.id">
                        <td class="align-middle text-center">{{ getUserById(transaction.userId) }}</td>
                        <td class="align-middle text-center">
                            <img src="../../../img/Shadow.png" width="80" height="80" />
                        </td>
                        <td class="align-middle text-center">{{ getItemEnById(transaction.itemId) }}</td>
                        <td class="align-middle text-center">{{ getItemPtById(transaction.itemId)  }}</td>
                        <td class="align-middle text-center">{{ transaction.boughtPrice }}</td>
                        <td class="align-middle text-center">{{ transaction.SoldPrice }}</td>
                        <td v-if="transaction.profit>=0" class="align-middle text-center" style="color: green;">{{ transaction.profit }}</td>
                        <td v-if="transaction.profit<0" class="align-middle text-center" style="color: red;">{{ transaction.profit }}</td>
                        <td class="align-middle text-center">
                            <div class="btn-group" role="group">
                                <router-link :to="{ name: 'DetailTransaction', params: { id: transaction.id } }"
                                    class="btn btn-warning mx-2">
                                    View
                                </router-link>
                                <router-link :to="{ name: 'EditTransaction', params: { id: transaction.id } }"
                                    class="btn btn-info">
                                    Edit
                                </router-link>
                                <button class="btn btn-danger mx-2"
                                    @click="deletetransaction(transaction.id)">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
  
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const transactions = ref([])
const users = ref([])
const items = ref([])


const gettransactions = async () => {
    try {
        const response = await axios.get("http://localhost:8000/api/transactions");
        transactions.value = response.data;
        console.log(transactions.value);
    } catch (error) {
        console.log(error);
    }
};

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

const getItemEnById = (itemId) => {
    const item = items.value.find((t) => t.id === itemId);
    return item ? item.nameEn : "";
};

const getItemPtById = (itemId) => {
    const item = items.value.find((t) => t.id === itemId);
    return item ? item.namePt : "";
};

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

const getUserById = (userId) => {
    const user = users.value.find((t) => t.id === userId);
    return user ? user.name : "";
};


onMounted(() => {
    getusers();
    getitems();
    gettransactions();
});

const deletetransaction = async (id) => {
    try {
        await axios.delete(`http://localhost:8000/api/transactions/${id}`);
        gettransactions();
    } catch (error) {
        console.log(error);
    }
};
</script>