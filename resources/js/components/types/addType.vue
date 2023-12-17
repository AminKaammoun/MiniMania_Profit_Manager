<template>
    <div className="col-md-6 offset-md-3 border rounded p-4 mt-2 shadow">
        <form @submit.prevent="addType">
            <div class="mb-3">
                <label for="nameEn" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" v-model="type.name">
            </div>
            
            <button type="submit" class="btn btn-outline-primary">
                Save
            </button>
            <router-link to="/types" class="btn btn-outline-danger mx-2">
                Cancel
            </router-link>
        </form>
    </div>
</template>

<script setup>
import { ref} from "vue"
import { useRouter } from 'vue-router';

const router = useRouter()
import axios from 'axios';

const type = ref({
    name: "",
});



const addType = async () => {
 
    try {
        await axios.post("http://localhost:8000/api/types/", type.value);
        router.push({ name: 'viewType' });
    } catch (error) {
        console.error(error);
    }
}
</script>

<style scoped></style>
