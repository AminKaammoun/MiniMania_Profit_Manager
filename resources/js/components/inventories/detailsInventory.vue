<template>
    <div v-if="isUserAdmin()">
     
      <div class="py-6">
        <table class="table table-striped shadow">
          <thead class="text-center">
            <tr>
              <td>Image</td>
              <td>Name English</td>
              <td>Name Portuguese</td>
              <td>Type</td>
              <td>Category</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="invitem in invitems" :key="invitem.id">
              <td class="align-middle text-center">
                <img :src="getItemById(invitem.itemId).image" style="width: 90px; height: 80px;" />
              </td>
              <td class="align-middle text-center">{{ getItemById(invitem.itemId).nameEn }}</td>
              <td class="align-middle text-center">{{ getItemById(invitem.itemId).namePt }}</td>
              <td class="align-middle text-center">{{ getTypeById(getItemById(invitem.itemId).typeId) }}</td>
              <td class="align-middle text-center">{{ getCategoryById(getItemById(invitem.itemId).categoryId) }}</td>
              <td class="align-middle text-center">
                <div class="btn-group" role="group">
                  <router-link :to="{ name: 'EditItem', params: { id: invitem.id } }" class="btn btn-success">
                    Edit
                  </router-link>
                  <button class="btn btn-danger mx-2" @click="deleteitem(invitem.id)">Delete</button>
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
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
const route = useRoute();
const router = useRouter();
import CryptoJS from 'crypto-js';
const items = ref([])
const types = ref([])
const categories = ref([])

const invitems = ref([])

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


const isUserAdmin = () =>{
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
    try {
        await axios.delete(`http://localhost:8000/api/inventoryitems/${id}`)

        fetchItems()
    } catch (error) {
        console.log(error)
    }
}
</script>
<style lang="scss" scoped></style>