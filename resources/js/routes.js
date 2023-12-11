import Home from './components/home.vue';
import ViewItem from './components/items/viewItem.vue';
import Additem from './components/items/addItem.vue';
export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'viewItem',
        path: '/items',
        component: ViewItem
    },

    {
        name:"Additem",
        path:"/additem",
        component:Additem
    }
   
];