<template>
  <div>
    <div class="py-6 shadow">
      <Toolbar class="mb-4">
        <template #end>
          <InputText v-model="globalFilter" placeholder="Search..." />
        </template>
      </Toolbar>
      
      <DataTable :value="filteredInventories" :paginator="true" :rows="10" :stripedRows="true" :showGridlines="true" :loading ="isLoading"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        responsiveLayout="scroll">

        <Column field="userId" header="Owner" class="align-middle" sortable>
          <template #body="{ data }">
            {{ getUserById(data.userId).name }}
          </template>
        </Column>

        <Column field="userId" header="Value" class="align-middle" sortable>
          <template #body="{ data }" >
            {{ getUserById(data.userId).inventoryWorth}}
          </template>
        </Column>

        <Column header="Action" class="align-middle" >
          <template #body="{ data }">
            <div class="btn-group" role="group">
              <router-link :to="{ name: 'DetailsInventory', params: { id: data.id } }" class="btn btn-outline-info">
                <i class="fa-solid fa-eye"></i>
                View
              </router-link>
              <!--<button class="btn btn-danger mx-2" @click="deleteinventory(data.id)">Delete</button>-->
            </div>
          </template>
        </Column>
      </DataTable>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted,computed } from 'vue';
import axios from 'axios';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import InputText from 'primevue/inputtext';

const isLoading = ref(true);
const inventories = ref([]);
const users = ref([]);
const globalFilter = ref('');

const getinventories = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/inventories");
    inventories.value = response.data;
    isLoading.value = false;
    console.log(inventories.value);
  } catch (error) {
    console.log(error);
  }
};

const getusers = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/users");
    users.value = response.data;
    console.log(users.value);
  } catch (error) {
    console.log(error);
  }
};

const getUserById = (userId) => {
  return users.value.find((t) => t.id === userId);
};

onMounted(() => {
  getusers();
  getinventories();
});

const deleteinventory = async (id) => {
  try {
    await axios.delete(`http://localhost:8000/api/inventories/${id}`);
    getinventories();
  } catch (error) {
    console.log(error);
  }
};

const filteredInventories = computed(() => {
  const regex = new RegExp(globalFilter.value, 'i');
  return inventories.value.filter((inventory) => {
    return (
      regex.test(getUserById(inventory.userId).name) ||
      regex.test(getUserById(inventory.userId).inventoryWorth.toString())
    );
  });
});

</script>

<style lang="scss" scoped>
@import '@fortawesome/fontawesome-free/css/all.css';
</style>
