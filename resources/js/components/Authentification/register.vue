<template>
    <div>
        <Toast ref="toastRef" />
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default" style="background-color: rgba(255, 255, 255, 0.5);">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form>
                            <div class="form-group row">

                                <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">

                                    <input id="name" type="text" class="form-control" v-model="user.name" required autofocus autocomplete="off">

                                </div>
                            </div>
                            <br>
                            <div class="form-group row">

                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="user.email" required
                                        autofocus autocomplete="off">

                                </div>
                            </div>
                               <br>
                            <div class="form-group row">

                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="user.password"
                                        required autocomplete="off">

                                </div>
                            </div>
                            <br>
                            <div class="form-group row">

                                <label for="password" class="col-md-4 col-form-label text-md-right">Password Confirmation</label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control"
                                        v-model="user.password_confirmation" required autocomplete="off">

                                </div>
                            </div>
                            <br>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">

                                    <button type="submit" class="btn btn-outline-primary" @click="handleSubmit">

                                        Register
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import axios from "axios"
import { useRouter } from 'vue-router';
import Toast from 'primevue/toast'; 
import {ref} from 'vue';

const router = useRouter()
let user = {}
const toastRef = ref(null);

const handleSubmit = async () => {
    try {
        const response = await axios.post('http://localhost:8000/api/register/', user);
        console.log(response);
        router.replace({ name: 'login' });
        toastRef.value.add({ severity: 'success', summary: 'Successfully registered', detail: 'You can now login!', life: 3000 });
    } catch (err) {
        console.error(err);
        toastRef.value.add({ severity: 'error', summary: 'Error', detail: 'Please fill the whole form', life: 3000 });
    }
}
</script>
<style scoped>
.marge {
    position: fixed;
    width: 100%;
    height: 300px;
    margin: 5% auto;
    padding: 20px;
    border: 5px solid #ccc;
    background-color: #fff;
}
</style>