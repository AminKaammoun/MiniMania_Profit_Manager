<template>
  <div>
    <Toast ref="toastRef" />
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
      <div class="container-fluid">
        <button type="button" class="btn btn-outline-light" @click="visible = true">
          <span style="color: rgb(0, 0, 0)">
            <i class="fa-solid fa-square-plus"></i>
          </span>
          New Item
        </button>
      </div>
    </nav>

    <form>
      <Dialog v-model:visible="visible">
        <h3 class="text-center">Add Item</h3>

        <div class="form-group">
          <label for="nameEn" class="form-label">Name English</label>
          <input type="text" class="form-control" id="nameEn" v-model="item.nameEn">
        </div>
        <div class="form-group">
          <label for="namePt" class="form-label">Name Portuguese</label>
          <input type="text" class="form-control" id="namePt" v-model="item.namePt">
        </div>
        <div class="form-group">
          <label for="type" class="form-label">Type</label>
          <select class="form-select" id="type" v-model="item.typeId">
            <option v-for="typeOption in typeOptions" :key="typeOption.id" :value="typeOption.id">
              {{ typeOption.name }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="category" class="form-label">Category</label>
          <select class="form-select" id="category" v-model="item.categoryId">
            <option v-for="categoryOption in categoryOptions" :key="categoryOption.id" :value="categoryOption.id">
              {{ categoryOption.name }}
            </option>
          </select>
        </div>

        <div class="form-group">
          <div>
            <br>
            <file-pond name="test" ref="pond" class-name="my-pond" label-idle="Drop files here..." allow-multiple="false"
              accepted-file-types="image/jpeg, image/png" v-bind:files="myFiles" v-on:init="handleFilePondInit"
              :server="serverOptions()" />
          </div>
        </div>

        <button type="submit" class="btn btn-outline-primary" @click="addItem">
          Save
        </button>
        <router-link to="/items" class="btn btn-outline-danger mx-2" @click="cancel">
          Cancel
        </router-link>

      </Dialog>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRouter } from 'vue-router';
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import Dialog from 'primevue/dialog';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import Toast from 'primevue/toast';

const FilePond = vueFilePond(FilePondPluginImagePreview);
const myFiles = ref([]);
const toastRef = ref(null);
const router = useRouter()
import axios from 'axios';
const visible = ref(false);

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
    visible.value = false;
    toastRef.value.add({ severity: 'success', summary: 'Successful', detail: 'Item Added', life: 3000 });
    await router.push({ name: 'viewItem' });

    await router.replace({ name: 'viewItem' });

    await router.go();

  } catch (error) {
    console.error(error);
    toastRef.value.add({ severity: 'error', summary: 'Error', detail: 'Error adding item', life: 3000 });
  }
}

const cancel = () => {
  visible.value = false;
}

const handleFilePondInit = () => {
  console.log('FilePond has initialized');
}
const serverOptions = () => {
  console.log('server pond');
  return {
    process: (fieldName, file, metadata, load, error, progress, abort) => {
      const data = new FormData();
      data.append('file', file);
      data.append('upload_preset', 'minimania_cloudinary');
      data.append('cloud_name', 'ddjwe8iuw');
      data.append('public_id', file.name);
      axios.post('https://api.cloudinary.com/v1_1/ddjwe8iuw/upload', data)
        .then((response) => response.data)
        .then((data) => {
          console.log(data);

          item.value.image = data.url;
          load(data);
        })
        .catch((error) => {
          console.error('Error uploading file:', error);
          error('Upload failed');
          abort();
        });
    },
  };
};

</script>

<style scoped>
@import '@fortawesome/fontawesome-free/css/all.css';
</style>
