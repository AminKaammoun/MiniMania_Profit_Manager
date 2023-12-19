import Home from './components/home.vue';
import ViewItem from './components/items/viewItem.vue';
import Additem from './components/items/addItem.vue';
import EditItem from './components/items/EditItem.vue';

import ViewCategory from './components/categories/viewCategory.vue';
import AddCategory from './components/categories/addCategory.vue';
import EditCategory from './components/categories/editCategory.vue';

import ViewType from './components/types/viewType.vue';
import AddType from './components/types/addType.vue';
import EditType from './components/types/editType.vue';

import ViewUser from './components/users/viewUser.vue';
import EditUser from './components/users/editUser.vue';

import ViewInventory from './components/inventories/viewInventory.vue';
import DetailsInventory from './components/inventories/detailsInventory.vue';

import ViewTransaction from './components/transactions/viewTransaction.vue';
import EditTransaction from './components/transactions/editTransaction.vue';
import AddTransaction from './components/transactions/addTransaction.vue';
import DetailTransaction from './components/transactions/detailTransaction.vue';

import Login from './components/authentification/login.vue'
import Register from './components/authentification/register.vue'

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'viewItem',
        path: '/items',
        component: ViewItem,
       
    },

    {
        name: "Additem",
        path: "/additem",
        component: Additem,
      
    },

    {
        name: "EditItem",
        path: "/edititem/:id",
        component: EditItem,
    
    },
    {
        name: 'viewCategory',
        path: '/categories',
        component: ViewCategory,
    },

    {
        name: "AddCategory",
        path: "/addcategory",
        component: AddCategory
    },

    {
        name: "EditCategory",
        path: "/editcategory/:id",
        component: EditCategory
    },
    {
        name: 'viewType',
        path: '/types',
        component: ViewType
    },

    {
        name: "AddType",
        path: "/addtype",
        component: AddType
    },

    {
        name: "EditType",
        path: "/edittype/:id",
        component: EditType
    },
    {
        name: "login",
        path: "/login",
        component: Login,
     
    },
    {
        name: "register",
        path: "/register",
        component: Register,
    },
    {
        name: 'viewUser',
        path: '/users',
        component: ViewUser,
    },

    {
        name: "EditUser",
        path: "/edituser/:id",
        component: EditUser
    },
    {
        name: "ViewInventory",
        path: "/inventories",
        component: ViewInventory
    },
    {
        name: "DetailsInventory",
        path: "/detailsinventory/:id",
        component: DetailsInventory
    },
    {
        name: "AddTransaction",
        path: "/addTransaction",
        component: AddTransaction
    },
    {
        name: "EditTransaction",
        path: "/edittransaction/:id",
        component: EditTransaction
    },
    {
        name: "ViewTransaction",
        path: "/transactions",
        component: ViewTransaction
    },
    {
        name: "DetailTransaction",
        path: "/detailtransaction/:id",
        component: DetailTransaction
    },
];