import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'


import Operations from './../pages/operation/index.vue'
import SmsUser from './../pages/user/index.vue'



const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/sms/admin', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Admin SMS Dashboard',
            },   
        },
        { 
            path: '/sms/admin/users', 
            component: SmsUser,
            name: 'SmsUser',
            meta:{
                title: 'Admin SMS Users',
            },   
        },
        { 
            path: '/sms/admin/operations', 
            component: Operations,
            name: 'Operations',
            meta:{
                title: 'Admin SMS Operations',
            },   
        },
        

        


        { 
            path: '/sms/admin/*', 
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