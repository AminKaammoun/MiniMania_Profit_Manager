<template>
  <div>
    <Toast ref="toastRef" />
    <div class="py-6 shadow">
      <Toolbar class="mb-4">
        <template #end>
          <InputText v-model="globalFilter" placeholder="Search..." />
        </template>
      </Toolbar>
      <DataTable :value="filteredUsers" :paginator="true" :rows="10" :stripedRows="true" :showGridlines="true" :loading ="isLoading"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        responsiveLayout="scroll">

        <Column field="name" header="Name" class="align-middle" sortable></Column>
        <Column field="email" header="Email" class="align-middle" sortable></Column>

        <Column field="inventoryWorth" header="Account Worth" class="align-middle" sortable>
          <template #body="{ data }" >
            {{ data.inventoryWorth + data.balance }}
          </template>
        </Column>

        <Column field="role_id" header="Role" class="align-middle" sortable>
          <template #body="{ data }">
            {{ getRoleById(data.role_id) }}
          </template>
        </Column>
        <Column header="Status" class="align-middle" sortable>
          <template #body="{ data }">
            <span style="color: green;">ACTIVE</span>
          </template>
        </Column>
        <Column header="Action" class="align-middle">
          <template #body="{ data }">
            <div class="btn-group" role="group">

              <EditUser :usr="data" />
              <button class="btn btn-outline-danger mx-2" @click="banUser">
                <i class="fa-solid fa-ban"></i> Ban
              </button>
            </div>
          </template>
        </Column>
      </DataTable>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import CryptoJS from 'crypto-js';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import InputText from 'primevue/inputtext';
import EditUser from './editUser.vue';
import Toast from 'primevue/toast';

const roles = ref([]);
const users = ref([]);
const toastRef = ref(null);
const globalFilter = ref('');
const isLoading = ref(true);

const isUserAdmin = () => {
  return localStorage.getItem('role') === CryptoJS.SHA256(0).toString();
};

const getRoleById = (roleId) => {
  const role = roles.value.find((t) => t.id === roleId);
  return role ? role.name : '';
};

const getusers = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/users');
    users.value = response.data;
    isLoading.value = false;
    console.log(users.value);
  } catch (error) {
    console.log(error);
  }
};

const getroles = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/roles');
    roles.value = response.data;
    console.log(roles.value);
  } catch (error) {
    console.log(error);
  }
};

onMounted(() => {
  getroles();
  getusers();
});

const filteredUsers = computed(() => {
  const regex = new RegExp(globalFilter.value, 'i');
  return users.value.filter((user) => {
    return (
      regex.test(user.name) ||
      regex.test(user.email) ||
      regex.test(getRoleById(user.role_id))
    );
  });
});

const banUser = () => {
  toastRef.value.add({ severity: 'error', summary: 'Error', detail: "Can't ban user", life: 3000 });
}

</script>

<style lang="scss" scoped>
@import '@fortawesome/fontawesome-free/css/all.css';
</style>
