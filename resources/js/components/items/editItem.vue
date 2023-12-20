<template>
    <div>
      
      <button type="button" class="btn btn-outline-success" @click="visible = true">
        <span>
          <i class="fa-solid fa-pen-to-square"></i>
          Edit
        </span>
      </button>
      <form>
        <Dialog v-model:visible="visible">
        <h3 class="text-center">Edit Item</h3>
        <div class="form-group">
          <label>Name English</label>
          <input type="text" class="form-control" v-model="items.nameEn" />
        </div>

        <div class="form-group">
          <label>Name Portuguese</label>
          <input type="text" class="form-control" v-model="items.namePt" />
        </div>

        <div class="form-group">
          <label for="type" class="form-label">Type</label>
          <select class="form-select" id="type" v-model="items.typeId">
            <option v-for="typeOption in types" :key="typeOption.id" :value="typeOption.id">
              {{ typeOption.name }}
            </option>
          </select>
        </div>

        <div class="form-group">
          <label for="category" class="form-label">Category</label>
          <select class="form-select" id="category" v-model="items.categoryId">
            <option v-for="categoryOption in categories" :key="categoryOption.id" :value="categoryOption.id">
              {{ categoryOption.name }}
            </option>
          </select>
        </div>

        <div class="form-group">
          <label for="imageitem" class="form-label">Image</label>
          <input type="text" class="form-control" id="imageitem" v-model="items.image" />
        </div>
<br>
        <button type="submit" class="btn btn-outline-info mx- 2" @click="updateItem"> <i class="fa-solid fa-floppy-disk"></i> Update</button>
        <button type="button" class="btn btn-outline-danger mx- 2" @click="cancel"> <i class="fa-solid fa-ban"></i> Cancel</button>
      </Dialog>
    </form>
  </div>
</template>

<script setup>
import api from '../config/api.js';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
import Dialog from 'primevue/dialog';

const props = defineProps(['art'])
const router = useRouter();
const route = useRoute();
const visible = ref(false);
const items = ref({});
const types = ref([]);
const categories = ref([]);

const fetchItem = async () => {
  items.value = props.art;
};

const getcategories = async () => {
  await axios
    .get("http://localhost:8000/api/categories")
    .then((res) => {
      categories.value = res.data;
      console.log(categories.value);
    })
    .catch((error) => {
      console.log(error);
    });
};
const gettypes = async () => {
  await axios.get("http://localhost:8000/api/types")
    .then((res) => {
      types.value = res.data;
      console.log(types.value);
    })
    .catch((error) => {
      console.log(error);
    });
};

const updateItem = async () => {
    console.log('Before API call');
  api.put(`/api/items/${items.value.id}`, items.value)
    .then(() => {
        console.log('After API call');
      visible.value = false
      
    })
    .catch((err) => {
      console.error(err);
    });
};

const cancel = () => {
  visible.value = false;
};

onMounted(async () => {
  gettypes();
  getcategories();
  await fetchItem();
});
</script>
<style lang="scss" scoped>
@import '@fortawesome/fontawesome-free/css/all.css';</style>