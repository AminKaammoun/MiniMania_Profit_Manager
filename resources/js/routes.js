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
    },
    
    {
        name:"EditItem",
        path:"/edititem/:id",
        component:EditItem
    },
    {
        name: 'viewCategory',
        path: '/categories',
        component: ViewCategory
    },

    {
        name:"AddCategory",
        path:"/addcategory",
        component:AddCategory
    },
    
    {
        name:"EditCategory",
        path:"/editcategory/:id",
        component:EditCategory
    },
    {
        name: 'viewType',
        path: '/types',
        component: ViewType
    },

    {
        name:"AddType",
        path:"/addtype",
        component:AddType
    },
    
    {
        name:"EditType",
        path:"/edittype/:id",
        component:EditType
    }
   
];