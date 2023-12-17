<template>
 
    <div>
        <h3 class="text-center">Edit Item</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateItem">
                    <div class="form-group">
                        <label>Name English</label>

                        <input type="text" class="form-control" v-model="items.nameEn">

                    </div>

                    <div class="form-group">
                        <label>Name Portuguese</label>

                        <input type="text" class="form-control" v-model="items.namePt">

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
                            <option v-for="categoryOption in categories" :key="categoryOption.id"
                                :value="categoryOption.id">
                                {{ categoryOption.name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="imageitem" class="form-label">Image</label>
                        <input type="text" class="form-control" id="imageitem" v-model="items.image">
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
const items = ref({});
const types = ref([]);
const categories = ref([]);

const fetchItem = async () => {

    await axios
        .get(`http://localhost:8000/api/items/${route.params.id}`)
        .then((res) => {
            items.value = res.data;
        })
        .catch((err) => { console.error(err) })

}


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

const updateItem = async () => {
    await axios

        .patch(`http://localhost:8000/api/items/${route.params.id}`, items.value)

        .then(() => {
            router.push({ name: 'viewItem' });
        })
        .catch((err) => { console.error(err) })
}

onMounted(async () => {  
     gettypes();
    getcategories();
    await fetchItem();
 
});
</script>