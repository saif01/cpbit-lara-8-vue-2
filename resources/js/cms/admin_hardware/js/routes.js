import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import Category from './../pages/others/category/index.vue'
import Subcategory from './../pages/others/subcategory/index.vue'
import Acsosoris from './../pages/others/acsosoris/index.vue'

import User from './../pages/user/index.vue'

import NotProcess from './../pages/complain/not_process.vue'
import Processing from './../pages/complain/processing.vue'
import Action from './../pages/complain/action/action.vue'


const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/cms/h_admin', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Admin Hardware Dashboard',
            },   
        },
        { 
            path: '/cms/h_admin/category', 
            component: Category,
            name: 'Category',
            meta:{
                title: 'Hardware Category Admin',
            },   
        },
        { 
            path: '/cms/h_admin/subcategory', 
            component: Subcategory,
            name: 'Subcategory',
            meta:{
                title: 'Hardware Subcategory Admin',
            },   
        },
        { 
            path: '/cms/h_admin/cat_dependency', 
            component: Acsosoris,
            name: 'Acsosoris',
            meta:{
                title: 'Hardware Acsosoris Admin',
            },   
        },
        { 
            path: '/cms/h_admin/user', 
            component: User,
            name: 'User',
            meta:{
                title: 'Hardware User Admin',
            },   
        },
        { 
            path: '/cms/h_admin/not_process', 
            component: NotProcess,
            name: 'NotProcess',
            meta:{
                title: 'Hardware Not Process Admin',
            },   
        },
        { 
            path: '/cms/h_admin/processing', 
            component: Processing,
            name: 'Processing',
            meta:{
                title: 'Hardware Processing Admin',
            },   
        },
        { 
            path: '/cms/h_admin/Action', 
            component: Action,
            name: 'Action',
            meta:{
                title: 'Hardware Action Admin',
            },   
        },

        


        


        { 
            path: '/demo/admin/*', 
            component: er404,
            name: 'er404',
            meta:{
                title: 'Super Admin 404',
            },   
        },

    ]
});


// Run brfore every route request
router.beforeEach( (to, from, next) => {
    // console.log(to, to.meta);
 
    let appName = 'CPB-IT';
    let title = to.meta && to.meta.title ? to.meta.title : '';
    // set current title
    document.title =`${ appName } ${ title }`;

    next();
});


export default router;