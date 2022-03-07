import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'


import NewProduct from './../pages/new_product/index.vue'



const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/inventory/admin', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Admin Demo Dashboard',
            },   
        },
        { 
            path: '/inventory/admin/new_product', 
            component: NewProduct,
            name: 'NewProduct',
            meta:{
                title: 'Admin New Product',
            },   
        },

        


        { 
            path: '/inventory/admin/*', 
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