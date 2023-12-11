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
                        <!--<td><img :src="item.image" width="80" height="80" /> </td>-->
                        <td><img src="../../../img/Shadow.png" width="80" height="80" /> </td>
                        <td>{{ item.nameEn }}</td>
                        <td>{{ item.namePt }}</td>
                        <td>{{ getTypeById(item.typeId)  }}</td>
                        <td>{{ getCategoryById(item.categoryId) }}</td>
                        

                        <td><button class="btn btn-warning mx-2">Edit</button>

                       <button class="btn btn-danger mx-2" @click="deleteitem(item.id)">Delete</button></td>

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