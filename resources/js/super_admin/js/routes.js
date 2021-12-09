import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import Users from '../pages/users/index.vue'
import Roles from '../pages/roles/index.vue'

const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/super_admin', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Super Admin Dashboard',
            },   
        },
        { 
            path: '/super_admin/users', 
            component: Users,
            name: 'Users',
            meta:{
                title: 'Super Admin Users',
            },   
        },
        { 
            path: '/super_admin/roles', 
            component: Roles,
            name: 'Roles',
            meta:{
                title: 'Super Admin Roles',
            },   
        },




        { 
            path: '/super_admin/*', 
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