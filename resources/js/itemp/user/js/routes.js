import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import all_emp from '../pages/allEmployee.vue'
import emp_rec from '../pages/employeeRec.vue'
import others from '../pages/others.vue'
import my_profile from '../pages/myProfile.vue'

import er404 from '../pages/common/404.vue'


const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/itemp', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'iTemp Dashboard',
            },   
        },

        { 
            path: '/itemp/all-employee', 
            component: all_emp,
            name: 'all_emp',
            meta:{
                title: 'iTemp All Employees',
            },   
        },

        { 
            path: '/itemp/employee-record', 
            component: emp_rec,
            name: 'emp_rec',
            meta:{
                title: 'iTemp Employees Record',
            },   
        },

        { 
            path: '/itemp/others', 
            component: others,
            name: 'others',
            meta:{
                title: 'iTemp Others',
            },   
        },

        { 
            path: '/itemp/my-profile', 
            component: my_profile,
            name: 'my_profile',
            meta:{
                title: 'iTemp My Profile',
            },   
        },
       
        


        { 
            path: '/demo/*', 
            component: er404,
            name: 'er404',
            meta:{
                title: 'iTemp 404',
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