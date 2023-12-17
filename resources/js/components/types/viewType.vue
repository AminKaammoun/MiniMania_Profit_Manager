<template>
    <div>
      <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
          <router-link :to="{ name: 'AddType' }" class="btn btn-outline-light">
            New Type
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
            <tr v-for="Type in types" :key="Type.id">
              <td class="align-middle text-center">{{ Type.name }}</td>
              <td class="align-middle text-center">
                <div class="btn-group" role="group">
                  <router-link :to="{ name: 'EditType', params: { id: Type.id } }" class="btn btn-success">
                    Edit
                  </router-link>
                  <button class="btn btn-danger mx-2" @click="deletetype(Type.id)">Delete</button>
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
  
  const types = ref([])
  
  const gettypes = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/types");
      types.value = response.data;
      console.log(types.value);
    } catch (error) {
      console.log(error);
    }
  };
  
  onMounted(() => {
    gettypes();
  });
  
  const deletetype = async (id) => {
    try {
      await axios.delete(`http://localhost:8000/api/types/${id}`);
      gettypes();
    } catch (error) {
      console.log(error);
    }
  };
  </script>