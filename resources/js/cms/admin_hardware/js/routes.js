import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import Category from './../pages/others/category/index.vue'
import Subcategory from './../pages/others/subcategory/index.vue'


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