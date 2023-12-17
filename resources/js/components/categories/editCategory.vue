<template>
    <div>
      <h3 class="text-center">Edit Category</h3>
      <div class="row">
        <div class="col-md-6">
          <form @submit.prevent="updateCategory">
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" v-model="categoryName" />
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
  
  const categoryName = ref('');
  
  const fetchCategory = async () => {
    try {
      const response = await axios.get(`http://localhost:8000/api/categories/${route.params.id}`);
      categoryName.value = response.data.name;
    } catch (error) {
      console.error(error);
    }
  };
  
  const updateCategory = async () => {
    try {
        console.log('Updating category:', categoryName.value);
      await axios.patch(`http://localhost:8000/api/categories/${route.params.id}`, {
        name: categoryName.value
      });
      router.push({ name: 'viewCategory' });
    } catch (error) {
      console.error(error);
    }
  };
  
  onMounted(async () => {
    await fetchCategory();
  });
  </script>
  