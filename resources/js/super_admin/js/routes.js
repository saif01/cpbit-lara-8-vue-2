import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import AllUser from '../pages/users/all_user.vue'

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
            path: '/super_admin/all_user', 
            component: AllUser,
            name: 'AllUser',
            meta:{
                title: 'Super Admin All User',
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