import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'


import NewProduct from './../pages/new_product/index.vue'
import OldProduct from './../pages/old_product/index.vue'
import operation from './../pages/operation/index.vue'

import givenProduct from './../pages/product_section/givenProduct.vue'
import runningProduct from './../pages/product_section/runningProduct.vue'
import damagedProduct from './../pages/product_section/damagedProduct.vue'

import warrantyProduct from './../pages/warranty_section/warrantyProduct.vue'
import expireProduct from './../pages/warranty_section/expireProduct.vue'

import deletedNewProduct from './../pages/deleted_section/new_product.vue'
import deletedOldProduct from './../pages/deleted_section/old_product.vue'



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
            path: '/inventory/admin/old_product', 
            component: OldProduct,
            name: 'OldProduct',
            meta:{
                title: 'Admin Old Product',
            },   
        },
        { 
            path: '/inventory/admin/operation', 
            component: operation,
            name: 'operation',
            meta:{
                title: 'Admin Operation',
            },   
        },

        // productSection
        { 
            path: '/inventory/admin/given-product', 
            component: givenProduct,
            name: 'givenProduct',
            meta:{
                title: 'Admin Given Product',
            },   
        },
        { 
            path: '/inventory/admin/running-product', 
            component: runningProduct,
            name: 'runningProduct',
            meta:{
                title: 'Admin Running Product',
            },   
        },
        { 
            path: '/inventory/admin/damaged-product', 
            component: damagedProduct,
            name: 'damagedProduct',
            meta:{
                title: 'Admin Damaged Product',
            },   
        },

        // warrantySection
        { 
            path: '/inventory/admin/warranty-product', 
            component: warrantyProduct,
            name: 'warrantyProduct',
            meta:{
                title: 'Admin Warranty Product',
            },   
        },
        { 
            path: '/inventory/admin/expire-product', 
            component: expireProduct,
            name: 'expireProduct',
            meta:{
                title: 'Admin expire Product',
            },   
        },

        // deletedSection
        { 
            path: '/inventory/admin/deletednew-product', 
            component: deletedNewProduct,
            name: 'deletedNewProduct',
            meta:{
                title: 'Admin Deleted New Product',
            },   
        },
        { 
            path: '/inventory/admin/deletedold-product', 
            component: deletedOldProduct,
            name: 'deletedOldProduct',
            meta:{
                title: 'Admin Deleted Old Product',
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