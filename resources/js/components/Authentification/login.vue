<template>
    <div>
        <Toast ref="toastRef" />
        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card card-default" style="background-color: rgba(255, 255, 255, 0.5);">
                    <div class="card-header"><b>Login</b></div>
                    <div class="card-body">
                        <form>
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
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">

                                    <button type="submit" class="btn btn-outline-primary" @click="handleLogin">

                                        Login
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
import axios from 'axios';
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import CryptoJS from 'crypto-js';
import Toast from 'primevue/toast';


const toastRef = ref(null);
const router = useRouter();
let user = {};

const handleLogin = async () => {
    axios.post('http://localhost:8000/api/login/', user)
        .then((response) => {
          
            const hashedId = CryptoJS.SHA256(response.data.user.id.toString()).toString();
            const hashedRole = CryptoJS.SHA256(response.data.user.role_id.toString()).toString();

            localStorage.setItem('id', hashedId);

            localStorage.setItem('role', hashedRole);

            localStorage.setItem('user', response.data.user.name);
            localStorage.setItem('token', response.data.token);

            window.location.href = '/';
            toastRef.value.add({ severity: 'success', summary: 'Login', detail: 'Welcome back ' + user.name, life: 3000 });
        })
        .catch(err => {
            toastRef.value.add({ severity: 'error', summary: 'Error', detail: 'Wrong login information', life: 3000 });
        });
};



</script>
<style scoped></style>