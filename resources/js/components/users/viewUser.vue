<template>
    <div>
      
      <div class="py-6">
        <table class="table table-striped shadow">
          <thead class="text-center">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>worth</th>
              <th>Role</th>
              <th>Status</th>
              <th>Action</th>

            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td class="align-middle text-center">{{ user.name }}</td>
              <td class="align-middle text-center">{{ user.email }}</td>
              <td class="align-middle text-center">{{ user.inventoryWorth + user.balance }}</td>
              <td class="align-middle text-center">{{ getRoleById(user.role_id)}}</td>
              <td class="align-middle text-center" style="color: green;">ACTIVE</td>
              <td class="align-middle text-center">
                <div  class="btn-group" role="group">
                  <router-link :to="{ name: 'EditUser', params: { id: user.id } }" class="btn btn-success">
                    Edit
                  </router-link>
                  <button class="btn btn-danger mx-2" @click="banUser(user.id)">Ban</button>
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
  import CryptoJS from 'crypto-js';
  const roles = ref([])
  const users = ref([])

  const isUserAdmin = () =>{
  return localStorage.getItem('role') === CryptoJS.SHA256(0).toString();
}

const getRoleById = (roleId) => {
    const role = roles.value.find((t) => t.id === roleId);
    return role ? role.name : "";
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
  
  const getroles = async () => {
    await axios.get("http://localhost:8000/api/roles")
        .then(res => {
            roles.value = res.data
            console.log(roles.value)
        })
        .catch(error => {
            console.log(error)
        })
}


  onMounted(() => {
    getroles();
    getusers();
  });
  
  const banUser = async (id) => {
    try {
      await axios.delete(`http://localhost:8000/api/users/${id}`);
      getusers();
    } catch (error) {
      console.log(error);
    }
  };
  </script>