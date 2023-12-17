<template>
    <div>
      <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
          <router-link :to="{ name: 'Additem' }" class="btn btn-outline-light">
            New Item
          </router-link>
        </div>
      </nav>
      <div class="py-6">
        <table class="table table-striped shadow">
          <thead>
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
            <tr v-for="item in items" :key="item.id">
              <td class="align-middle">
                <img src="../../../img/Shadow.png" width="80" height="80" />
              </td>
              <td class="align-middle text-center">{{ item.nameEn }}</td>
              <td class="align-middle text-center">{{ item.namePt }}</td>
              <td class="align-middle text-center">{{ getTypeById(item.typeId) }}</td>
              <td class="align-middle text-center">{{ getCategoryById(item.categoryId) }}</td>
              <td class="align-middle text-center">
                <div class="btn-group" role="group">
                  <router-link :to="{ name: 'EditItem', params: { id: item.id } }" class="btn btn-success">
                    Edit
                  </router-link>
                  <button class="btn btn-danger mx-2" @click="deleteitem(item.id)">Delete</button>
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
const items = ref([])
const types = ref([])
const categories = ref([])
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
    getitems();
    gettypes();
    getTypeById();
    getcategories();
});
const deleteitem = async (id) => {
    try {
        await axios.delete(`http://localhost:8000/api/items/${id}`)

        getitems()
    } catch (error) {
        console.log(error)
    }
}
</script>
<style lang="scss" scoped></style>