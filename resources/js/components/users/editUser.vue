<template>
    <div>
        <Toast ref="toastRef" />
        <button type="button" class="btn btn-outline-success" @click="visible = true">
            <span>
                <i class="fa-solid fa-pen-to-square"></i>
                Edit
            </span>
        </button>
        <Dialog v-model:visible="visible">
            <div>
                <h3 class="text-center">Edit User</h3>
                <div class="p-fluid">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <InputText id="name" v-model="users.name" class="p-inputtext" />
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <InputText id="email" v-model="users.email" class="p-inputtext" />
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role_id" v-model="users.role_id">
                            <option v-for="roleOption in roles" :key="roleOption.id" :value="roleOption.id">
                                {{ roleOption.name }}
                            </option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-info mx- 2" @click="updateUser"> <i
                                class="fa-solid fa-floppy-disk"></i> Update</button>
                        <button type="button" class="btn btn-outline-danger mx- 2" @click="cancel"> <i
                                class="fa-solid fa-ban"></i>
                            Cancel</button>
                    </div>
                </div>
            </div>
        </Dialog>
    </div>
</template>
  
<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Toast from 'primevue/toast';

const users = ref({});
const roles = ref([]);
const visible = ref(false);
const props = defineProps(['usr'])
const toastRef = ref(null);

const fetchUser = () => {
    users.value = props.usr;
};


const updateUser = async () => {
    try {
        await axios.patch(`http://localhost:8000/api/users/${users.value.id}`, users.value);
        toastRef.value.add({ severity: 'info', summary: 'Update', detail: 'User Updated', life: 3000 });
        visible.value = false
    } catch (error) {
        console.error(error);
    }
};


const cancel = () => {
    visible.value = false;
};

const getroles = async () => {
    try {
        const response = await axios.get('http://localhost:8000/api/roles');
        roles.value = response.data;
        console.log(roles.value);
    } catch (error) {
        console.log(error);
    }
};

onMounted(async () => {
    getroles();
    await fetchUser();
});

</script>
  
<style scoped>
@import '@fortawesome/fontawesome-free/css/all.css';
</style>
  