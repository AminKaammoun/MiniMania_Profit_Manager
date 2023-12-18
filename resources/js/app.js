import { createApp } from 'vue';
import { createRouter, createWebHashHistory } from "vue-router";
import 'bootstrap/dist/css/bootstrap.min.css'
import App from './App.vue';
import { routes } from "./routes";

let app = createApp(App);

const router = createRouter({
    history: createWebHashHistory(),
    routes: routes,
});

router.beforeEach(async (to, from, next) => {
    const isLoggedIn = localStorage.getItem('token');

    if ((to.name === 'login' || to.name === 'register') && isLoggedIn) {
        
        next('/');
    } else if (to.matched.some(record => record.meta.isAuth) && !isLoggedIn) {
        
        next("/login");
    } else {
       
        next();
    }
});


app.use(router);
app.mount("#app");
