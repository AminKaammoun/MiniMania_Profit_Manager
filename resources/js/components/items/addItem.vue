<template>
    <div className="col-md-6 offset-md-3 border rounded p-4 mt-2 shadow">
        <form @submit.prevent="addItem">
            <div class="mb-3">
                <label for="nameEn" class="form-label">Name English</label>
                <input type="text" class="form-control" id="nameEn" v-model="item.nameEn">
            </div>
            <div class="mb-3">
                <label for="namePt" class="form-label">Name Portuguese</label>
                <input type="text" class="form-control" id="namePt" v-model="item.namePt">
            </div>
            <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <select class="form-select" id="type" v-model="item.typeId">
          <option v-for="typeOption in typeOptions" :key="typeOption.id" :value="typeOption.id">
            {{ typeOption.name }}
          </option>
        </select>
      </div>
      <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select class="form-select" id="category" v-model="item.categoryId">
          <option v-for="categoryOption in categoryOptions" :key="categoryOption.id" :value="categoryOption.id">
            {{ categoryOption.name }}
          </option>
        </select>
      </div>
            <div class="mb-3">
                <label for="imageitem" class="form-label">Image</label>
                <input type="text" class="form-control" id="imageitem" v-model="item.image">
            </div>
            <button type="submit" class="btn btn-outline-primary">
                Save
            </button>
            <router-link to="/items" class="btn btn-outline-danger mx-2">
                Cancel
            </router-link>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRouter } from 'vue-router';

const router = useRouter()
import axios from 'axios';

const item = ref({
    nameEn: "",
    namePt: "",
    typeId: "", 
    categoryId: "",
    image: ""
});

const typeOptions = ref([]);
const categoryOptions = ref([]);

onMounted(async () => {
 
  const typeResponse = await axios.get("http://localhost:8000/api/types");
  typeOptions.value = typeResponse.data;

 
  const categoryResponse = await axios.get("http://localhost:8000/api/categories");
  categoryOptions.value = categoryResponse.data;
});

const addItem = async () => {
 
    try {
        await axios.post("http://localhost:8000/api/items/", item.value);
        router.push({ name: 'viewItem' });
    } catch (error) {
        console.error(error);
    }
}
</script>

<style scoped></style>
