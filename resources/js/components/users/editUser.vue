<template>
    <div>
        <h3 class="text-center">Edit Item</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateUser">
                    <div class="form-group">
                        <label>Name</label>

                        <input type="text" class="form-control" v-model="users.name">

                    </div>

                    <div class="form-group">
                        <label>Email</label>

                        <input type="text" class="form-control" v-model="users.email">

                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role_id" v-model="users.role_id">
                            <option v-for="roleOption in roles" :key="roleOption.id" :value="roleOption.id">
                                {{ roleOption.name }}
                            </option>
                        </select>
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
const users = ref({});
const roles = ref([]);
const fetchUser = async () => {

    await axios
        .get(`http://localhost:8000/api/users/${route.params.id}`)
        .then((res) => {
            users.value = res.data;
        })
        .catch((err) => { console.error(err) })

}


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


const updateUser = async () => {
    await axios

        .patch(`http://localhost:8000/api/users/${route.params.id}`, users.value)

        .then(() => {
            router.push({ name: 'viewUser' });
        })
        .catch((err) => { console.error(err) })
}

onMounted(async () => {
    getroles();

    await fetchUser();

});
</script>