<template>
    <div className="col-md-6 offset-md-3 border rounded p-4 mt-2 shadow">
        <form @submit.prevent="addTransaction">
            
            <div class="mb-3">
                <label for="user" class="form-label">User</label>
                <select class="form-select" id="user" v-model="transaction.userId">
                    <option v-for="userOption in userOptions" :key="userOption.id" :value="userOption.id">
                        {{ userOption.name }}
                    </option>
                </select>
            </div>
          
            <div class="mb-3">
                <label for="item" class="form-label">Item Name English</label>
                <select class="form-select" id="item" v-model="transaction.itemId">
                    <option v-for="itemOption in itemOptions" :key="itemOption.id" :value="itemOption.id">
                        {{ itemOption.nameEn }}
                    </option>
                </select>
            </div>
           
            <div class="mb-3">
                <label for="item1" class="form-label">Item Name Portuguese</label>
                <select class="form-select" id="item1" v-model="transaction.itemId">
                    <option v-for="itemOption in itemOptions" :key="itemOption.id" :value="itemOption.id">
                        {{ itemOption.namePt }}
                    </option>
                </select>
            </div>

             <div class="mb-3">
                <label for="nameEn" class="form-label">Bought Price</label>
                <input type="text" class="form-control" id="nameEn" v-model="transaction.boughtPrice">
            </div>
           
            <div class="mb-3">
                <label for="namePt" class="form-label">Sold Price</label>
                <input type="text" class="form-control" id="namePt" v-model="transaction.SoldPrice">
            </div>
            
         
            <button type="submit" class="btn btn-outline-primary">
                Save
            </button>
            <router-link to="/transactions" class="btn btn-outline-danger mx-2">
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

const transaction = ref({
    boughtPrice: "",
    SoldPrice: "",
    itemId: "",
    userId: "" 
});

const itemOptions = ref([]);
const userOptions = ref([]);

onMounted(async () => {
    const itemResponse = await axios.get("http://localhost:8000/api/items");
  itemOptions.value = itemResponse.data;

  const userResponse = await axios.get("http://localhost:8000/api/users");
  userOptions.value = userResponse.data;
   
});

const addTransaction = async () => {

    try {
        await axios.post("http://localhost:8000/api/transactions/", transaction.value);
        router.push({ name: 'ViewTransaction' });
        console.log(transaction.value);
    } catch (error) {
        console.error(error);
    }
}
</script>

<style scoped></style>
