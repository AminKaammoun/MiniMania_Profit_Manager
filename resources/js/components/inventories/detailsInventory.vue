<template>
  <div>
    <Toast ref="toastRef" />
    <Toolbar class="mb-4">
        <template #end>
          <InputText v-model="globalFilter" placeholder="Search..." />
        
        </template>
      </Toolbar>

    <DataView :value="filteredItems" :layout="layout" >
      <template #header>
        <div class="flex justify-content-end">
          <DataViewLayoutOptions v-model="layout" />
        </div>
      </template>

      <template #list="slotProps">
        <div class="grid grid-nogutter">
          <div v-for="(item, index) in slotProps.items" :key="index" class="col-12">
            <div class="flex flex-column xl:flex-row xl:align-items-start p-4 gap-4"
              :class="{ 'border-top-1 surface-border': index !== 0 }">
              <img class="w-9 sm:w-16rem xl:w-10rem shadow-2 block xl:block mx-auto border-round"
                :src="`https://placekitten.com/200/300?image=${index + 1}`" :alt="item.name" />
              <div
                class="flex flex-column sm:flex-row justify-content-between align-items-center xl:align-items-start flex-1 gap-4">
                <div class="flex flex-column align-items-center sm:align-items-start gap-3">
                  <div class="text-2xl font-bold text-900">{{ item.name }}</div>
                  <Rating :modelValue="item.rating" readonly :cancel="false"></Rating>
                  <div class="flex align-items-center gap-3">
                    <span class="flex align-items-center gap-2">
                      <i class="pi pi-tag"></i>
                      <span class="font-semibold">{{ item.category }}</span>
                    </span>
                    <Tag :value="item.inventoryStatus" :severity="getSeverity(item)"></Tag>
                  </div>
                </div>
                <div class="flex sm:flex-column align-items-center sm:align-items-end gap-3 sm:gap-2">
                  <span class="text-2xl font-semibold">${{ item.price }}</span>
                  <Button icon="pi pi-shopping-cart" rounded :disabled="item.inventoryStatus === 'OUTOFSTOCK'"></Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template #grid="slotProps">
        <div class="grid grid-nogutter">
          <div v-for="(item, index) in slotProps.items" :key="index" class="col-12 sm:col-6 lg:col-5 xl:col-2 p-1">
            <div class="p-4 border-1 surface-border surface-card border-round">
              <div class="flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="flex align-items-center gap-2">
                  <i class="pi pi-tag"></i>
                  <span style="font-size: 0.75rem;" class="font-semibold">{{
                    getCategoryById(getItemById(item.itemId).categoryId) }}</span>
                </div>
                <Tag :value="getTypeById(getItemById(item.itemId).typeId)" :severity="getSeverity(item)"></Tag>
              </div>
              <div class="flex flex-column align-items-center gap-3 py-5">
                <img :src="getItemById(item.itemId).image" :alt="item.nameEn" />
                <!--<div class="text-2xl font-bold">{{ getItemById(item.itemId).nameEn }}</div>-->

              </div>
              <div class="flex align-items-center justify-content-between">
                <Button class="btn btn-outline-danger" @click="deleteitem(item.id)">
                  <i class="fa-solid fa-trash"></i>
                </Button>

              </div>
            </div>
          </div>
        </div>
      </template>


    </DataView>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import DataView from 'primevue/dataview';
import Tag from 'primevue/tag';
import DataViewLayoutOptions from 'primevue/dataviewlayoutoptions';
import Button from 'primevue/button';
import Toolbar from 'primevue/toolbar';
import InputText from 'primevue/inputtext';
import Toast from 'primevue/toast'; 

const route = useRoute();

import CryptoJS from 'crypto-js';
const items = ref([])
const types = ref([])
const categories = ref([]);
const layout = ref('grid');
const toastRef = ref(null);

const invitems = ref([]);
const globalFilter = ref('');

const getSeverity = (item) => {

  const itemType = getTypeById(getItemById(item.itemId).typeId);
  switch (itemType) {
    case 'Rare':
      return 'warning';
    case 'Super Rare':
      return 'danger';
    case 'Common':
      return 'primary';
    case 'Legendary':
      return 'info';
      case 'Seasonal':
      return 'success';
  }
};


const getAllitems = async () => {
  await axios.get("http://localhost:8000/api/items")
    .then(res => {
      items.value = res.data
      console.log(items.value)
    })
    .catch(error => {
      console.log(error)
    })
}

const fetchItems = async () => {

  await axios
    .get(`http://localhost:8000/api/inventoryitems/${route.params.id}`)
    .then((res) => {
      invitems.value = res.data;
    })
    .catch((err) => { console.error(err) })

}


const isUserAdmin = () => {
  return localStorage.getItem('role') === CryptoJS.SHA256(0).toString();
}

const getItemById = (itemId) => {
  return items.value.find((t) => t.id === itemId) || {};
};

const gettypes = async () => {
  await axios.get("http://localhost:8000/api/types")
    .then(res => {
      types.value = res.data
      console.log(types.value)
    })
    .catch(error => {
      console.log(error)
    })
}
const getTypeById = (typeId) => {
  const type = types.value.find((t) => t.id === typeId);
  return type ? type.name : "";
};

const getCategoryById = (categoryId) => {
  const category = categories.value.find((t) => t.id === categoryId);
  return category ? category.name : "";
};


const getcategories = async () => {
  await axios.get("http://localhost:8000/api/categories")
    .then(res => {
      categories.value = res.data
      console.log(categories.value)
    })
    .catch(error => {
      console.log(error)
    })
}

onMounted(() => {
  fetchItems();
  getAllitems();
  gettypes();
  getTypeById();
  getcategories();
  getItemById();
});
const deleteitem = async (id) => {
  if (window.confirm("Are you sure to delete this item?")) {
  try {
    await axios.delete(`http://localhost:8000/api/inventoryitems/${id}`)
    toastRef.value.add({ severity: 'success', summary: 'Delete', detail: 'Item Deleted', life: 3000 });
    fetchItems()
  } catch (error) {
    console.log(error);
    toastRef.value.add({ severity: 'error', summary: 'Error', detail: 'Error deleting item', life: 3000  });
  }
}
}


const filteredItems = computed(() => {
  const regex = new RegExp(globalFilter.value, 'i');
  return invitems.value.filter(item => {

    return (
    regex.test(getItemById(item.itemId).nameEn) 
    
    );
  });
});



</script>
<style scoped>
@import 'primevue/resources/primevue.min.css';
@import 'primevue/resources/themes/saga-blue/theme.css';
@import 'primeicons/primeicons.css';
@import 'primeflex/primeflex.css';
@import '@fortawesome/fontawesome-free/css/all.css';
</style>
