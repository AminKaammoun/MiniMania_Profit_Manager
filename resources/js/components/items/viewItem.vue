<template>
  <AddItem/>
  <Toast ref="toastRef" />
  <div v-if="isUserAdmin()">
    
    <div class="py-6 shadow">
      <Toolbar class="mb-4">
        <template #start>
          <Button label="Delete" icon="pi pi-trash" class="p-button-danger" @click="confirmDeleteSelected"
            :disabled="!selectedProducts || !selectedProducts.length" />
        </template>
        <template #end>
          <InputText v-model="globalFilter" placeholder="Search..." />
        </template>
      </Toolbar>

      <DataTable :value="filteredItems" :loading ="isLoading"
      :paginator="true" :rows="10" :stripedRows="true" :showGridlines="true" :globalFilter="globalFilter"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        responsiveLayout="scroll">

        <template #header>
          <div class="table-header flex flex-column md:flex-row md:justify-content-between">
            <h5 class="mb-2 md:m-0 md:align-self-center">Manage Items</h5>

          </div>
        </template>

        <Column selectionMode="multiple" :headerStyle="{'width': '3em'}"></Column>

        <Column field="image" header="Image" class="align-middle">
          <template #body="{ data }">
            <img :src="data.image" style="width: 70px; height: 65px;" />
          </template>
        </Column>
        <Column field="nameEn" header="Name English" class="align-middle" sortable></Column>
        <Column field="namePt" header="Name Portuguese" class="align-middle" sortable></Column>

        <Column field="typeId" header="Type" class="align-middle" sortable>
          <template #body="{ data }">
            {{ getTypeById(data.typeId) }}
          </template>
        </Column>

        <Column field="categoryId" header="Category" class="align-middle" sortable>
          <template #body="{ data }">
            {{ getCategoryById(data.categoryId) }}
          </template>
        </Column>

        <Column header="Action" class="align-middle">
          <template #body="{ data }">
            <div class="btn-group" role="group">
             <!-- <router-link :to="{ name: 'EditItem', params: { id: data.id } }" class="btn btn-outline-success mx-2">
                <i class="fa-solid fa-pen-to-square"></i>
                Edit
              </router-link>-->
              <EditItem :art="data"/>
              <button class="btn btn-outline-danger mx-2" @click="deleteitem(data.id)">
                <i class="fa-solid fa-trash"></i> Delete
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
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import Toast from 'primevue/toast'; 
import EditItem from './editItem.vue';
import AddItem from './addItem.vue';

import axios from 'axios';
import CryptoJS from 'crypto-js';

const items = ref([]);
const types = ref([]);
const categories = ref([]);
const globalFilter = ref('');
const toastRef = ref(null);
const isLoading = ref(true);


const getitems = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/items?_embed=types,categories");
    items.value = response.data;
    isLoading.value = false;
  } catch (error) {
    console.log(error);
  }
};

const isUserAdmin = () => {
  return localStorage.getItem('role') === CryptoJS.SHA256(0).toString();
};

const gettypes = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/types");
    types.value = response.data;
   
  } catch (error) {
    console.log(error);
  }
};

const getTypeById = (typeId) => {
  const type = types.value.find((t) => t.id === typeId);
  return type ? type.name : "";
};

const getCategoryById = (categoryId) => {
  const category = categories.value.find((t) => t.id === categoryId);
  return category ? category.name : "";
};

const getcategories = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/categories");
    categories.value = response.data;
  } catch (error) {
    console.log(error);
  }
};

onMounted(() => {
  getitems();
  gettypes();
  getTypeById();
  getcategories();
  
});

const deleteitem = async (id) => {
  if (window.confirm("Are you sure to delete this item?")) {
    try {
      await axios.delete(`http://localhost:8000/api/items/${id}`);
      getitems();
      toastRef.value.add({ severity: 'success', summary: 'Delete', detail: 'Item Deleted', life: 3000 });
    } catch (error) {
      console.log(error);
      toastRef.value.add({ severity: 'error', summary: 'Error', detail: 'Error deleting item', life: 3000  });
    }
  }
};

const confirmDeleteSelected = () => {
  if (selectedProducts.value && selectedProducts.value.length > 0) {
    console.log('Confirm and delete selected items:', selectedProducts.value);
  } else {
    console.log('No items selected for deletion.');
  }
};

const filteredItems = computed(() => {
  const regex = new RegExp(globalFilter.value, 'i');
  return items.value.filter((item) => {
    return (
      regex.test(item.nameEn) ||
      regex.test(item.namePt) ||
      regex.test(getTypeById(item.typeId)) ||
      regex.test(getCategoryById(item.categoryId))
    );
    
  });
});
</script>


<style lang="scss" scoped>
@import '@fortawesome/fontawesome-free/css/all.css';
.table-header {
  padding: 1rem;
 
}

.p-input-icon-left {
  display: flex;
  align-items: center;
}

.p-inputtext {
  width: 100%;
}
</style>
