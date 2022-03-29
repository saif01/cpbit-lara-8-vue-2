import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'


import checkpoint from './../pages/allCheckPoint/index.vue'
import allemp from './../pages/allEmployee/index.vue'

import emp_rec from './../pages/reports/emp_records.vue'
import other_rec from './../pages/reports/other_records.vue'



const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/itemp/admin', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Admin iTemp Dashboard',
            },   
        },
        { 
            path: '/itemp/admin/all-employee', 
            component: allemp,
            name: 'allemp',
            meta:{
                title: 'Admin All Employees',
            },   
        },
        { 
            path: '/itemp/admin/all-checkpoints', 
            component: checkpoint,
            name: 'checkpoint',
            meta:{
                title: 'Admin All Check Point',
            },   
        },

        { 
            path: '/itemp/admin/employee-records', 
            component: emp_rec,
            name: 'emp_rec',
            meta:{
                title: 'Admin Emloyee Records Report',
            },   
        },
        { 
            path: '/itemp/admin/others-records', 
            component: other_rec,
            name: 'other_rec',
            meta:{
                title: 'Admin Other Records Report',
            },   
        },
        

        


        { 
            path: '/itemp/admin/*', 
            component: er404,
            name: 'er404',
            meta:{
                title: 'iTemp Admin 404',
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