import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import Reports from './../pages/reports.vue'


const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/pbi/', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'PBI Dashboard',
            },   
        },

        { 
            path: '/pbi/report', 
            component: Reports,
            name: 'Reports',
            meta:{
                title: 'PBI Reports',
            },   
        },

        // { 
        //     path: '/pbi/reports', 
        //     component: Reports,
        //     name: 'Reports',
        //     meta:{
        //         title: 'PBI Reports',
        //     },   
        // },
       
       
        


        { 
            path: '/pbi/*', 
            component: er404,
            name: 'er404',
            meta:{
                title: 'PBI 404',
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