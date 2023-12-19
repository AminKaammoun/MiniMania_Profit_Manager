<template>
    <div>
     
      <div class="py-6">
        <table class="table table-striped shadow">
          <thead class="text-center">
            <tr>
              <th>Owner</th>
              <th>Value</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="inventory in inventories" :key="inventory.id">
              <td class="align-middle text-center">{{ getUserById(inventory.userId).name }}</td>
              <td class="align-middle text-center">{{getUserById(inventory.userId).inventoryWorth }} </td>
              <td class="align-middle text-center">
                <div class="btn-group" role="group">
                  <router-link :to="{ name: 'DetailsInventory', params: { id: inventory.id } }" class="btn btn-info">
                    View
                  </router-link>
                  <!--<button class="btn btn-danger mx-2" @click="deleteinventory(inventory.id)">Delete</button>-->
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
  
  const inventories = ref([])
  const users = ref([])


  const getinventories = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/inventories");
      inventories.value = response.data;
      console.log(inventories.value);
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
  </script>