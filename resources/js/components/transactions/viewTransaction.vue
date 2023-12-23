<template>
  
          <AddTransaction/>
        <Toast ref="toastRef" />
        <div class="py-6 shadow">
          
            <Toolbar class="mb-4">
        <template #end>
          <InputText v-model="globalFilter" placeholder="Search..." />
        </template>
      </Toolbar>
      
            <DataTable :value="filteredTransactions" :loading="isLoading" :paginator="true" :rows="10" :stripedRows="true"
                :showGridlines="true" :globalFilter="globalFilter"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                responsiveLayout="scroll">
                <template #header>
                    <div class="table-header flex flex-column md:flex-row md:justify-content-between">
                        <h5 class="mb-2 md:m-0 md:align-self-center">Manage Transactions</h5>
                    </div>
                </template>

                <Column field="userId" header="User" class="align-middle" sortable>
                    <template #body="{ data }">
                        {{ getUserById(data.userId) }}
                    </template>
                </Column>

                <Column field="image" header="Image" class="align-middle">
                    <template #body="{ data }">
                        <img :src="getItemById(data.itemId).image" style="width: 70px; height: 65px;" />
                    </template>
                </Column>

                <Column field="itemId" header="Item Name English" class="align-middle" sortable>
                    <template #body="{ data }">
                        {{ getItemById(data.itemId).nameEn }}
                    </template>
                </Column>

                <Column field="itemId" header="Item Name Portuguese" class="align-middle" sortable>
                    <template #body="{ data }">
                        {{ getItemById(data.itemId).namePt }}
                    </template>
                </Column>

                <Column field="boughtPrice" header="Bought Price" class="align-middle" sortable></Column>

                <Column field="SoldPrice" header="Sold Price" class="align-middle" sortable></Column>

                <Column field="profit" header="Profit" class="align-middle" sortable>
                    <template #body="{ data }">
                        <span :style="{ color: data.profit >= 0 ? 'green' : 'red' }">{{ data.profit }}</span>
                    </template>
                </Column>

                <Column header="Action" class="align-middle">
                    <template #body="{ data }">
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-warning mx-2" @click="viewTransaction"> <i class="fa-solid fa-eye"></i> View</button>

                           
                            <EditTransaction :tra="data"/>
                            <button class="btn btn-outline-danger mx-2" @click="deletetransaction(data.id)"> <i class="fa-solid fa-trash"></i> Delete</button>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
   
</template>


<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toast from 'primevue/toast';

import InputText from 'primevue/inputtext';
import Toolbar from 'primevue/toolbar';

import AddTransaction from './addTransaction.vue';
import EditTransaction from './editTransaction.vue';

const transactions = ref([]);
const users = ref([]);
const items = ref([]);
const globalFilter = ref('');
const toastRef = ref(null);
const isLoading = ref(true);


const gettransactions = async () => {
    try {
        const response = await axios.get("http://localhost:8000/api/transactions");
        transactions.value = response.data;
        isLoading.value = false;
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



const getItemById = (itemId) => {
    return items.value.find((t) => t.id === itemId) || {};
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
    if (window.confirm("Are you sure to delete this transaction?")) {
    try {
        await axios.delete(`http://localhost:8000/api/transactions/${id}`);
        gettransactions();
        toastRef.value.add({ severity: 'success', summary: 'Delete', detail: 'Transaction Deleted', life: 3000 });
    } catch (error) {
        console.log(error);
        toastRef.value.add({ severity: 'error', summary: 'Error', detail: 'Error deleting transaction', life: 3000  });
    }
}
};

const filteredTransactions = computed(() => {
  const regex = new RegExp(globalFilter.value, 'i');
  return transactions.value.filter((transaction) => {
    return (
      regex.test(getUserById(transaction.userId)) ||
      regex.test(getItemById(transaction.itemId).nameEn) ||
      regex.test(getItemById(transaction.itemId).namePt)
    );
  });
});

const viewTransaction = () => {
    toastRef.value.add({ severity: 'warn', summary: 'Coming soon!', detail: 'Not available yet', life: 3000 });
}

const formatNumber = (number) => {
    return parseFloat(number).toLocaleString('en-US', { maximumFractionDigits: 2 });
};

</script>
<style scoped>
@import '@fortawesome/fontawesome-free/css/all.css';
</style>
