<template>
    <div>
      <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
          <router-link :to="{ name: 'AddCategory' }" class="btn btn-outline-light">
            New Category
          </router-link>
        </div>
      </nav>
      <div class="py-6">
        <table class="table table-striped shadow">
          <thead class="text-center">
            <tr>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="category in categories" :key="category.id">
              <td class="align-middle text-center">{{ category.name }}</td>
              <td class="align-middle text-center">
                <div class="btn-group" role="group">
                  <router-link :to="{ name: 'EditCategory', params: { id: category.id } }" class="btn btn-success">
                    Edit
                  </router-link>
                  <button class="btn btn-danger mx-2" @click="deletecategory(category.id)">Delete</button>
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
  
  const categories = ref([])
  
  const getcategories = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/categories");
      categories.value = response.data;
      console.log(categories.value);
    } catch (error) {
      console.log(error);
    }
  };
  
  onMounted(() => {
    getcategories();
  });
  
  const deletecategory = async (id) => {
    try {
      await axios.delete(`http://localhost:8000/api/categories/${id}`);
      getcategories();
    } catch (error) {
      console.log(error);
    }
  };
  </script>