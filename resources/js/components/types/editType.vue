<template>
    <div>
      <h3 class="text-center">Edit Type</h3>
      <div class="row">
        <div class="col-md-6">
          <form @submit.prevent="updateType">
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" v-model="typeName" />
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import axios from 'axios';
  import { useRouter, useRoute } from 'vue-router';
  const router = useRouter();
  const route = useRoute();
  import { ref, onMounted } from 'vue';
  
  const typeName = ref('');
  
  const fetchType = async () => {
    try {
      const response = await axios.get(`http://localhost:8000/api/types/${route.params.id}`);
      typeName.value = response.data.name;
    } catch (error) {
      console.error(error);
    }
  };
  
  const updateType = async () => {
    try {
       
      await axios.patch(`http://localhost:8000/api/types/${route.params.id}`, {
        name: typeName.value
      });
      router.push({ name: 'viewType' });
    } catch (error) {
      console.error(error);
    }
  };
  
  onMounted(async () => {
    await fetchType();
  });
  </script>
  