import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'



import Category from './../pages/category/index.vue'
import Subcategory from './../pages/subcategory/index.vue'


import NotProcess from './../pages/complain/not_process.vue'
import Processing from './../pages/complain/processing.vue'
import Closed from './../pages/complain/closed.vue'
import Action from './../pages/complain/action/action.vue'

import ReportIndex from './../pages/reports/index.vue'
import ReportCanceled from './../pages/reports/cancel.vue'



const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/cms/a_admin', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Application Dashboard Admin',
            },   
        },
        { 
            path: '/cms/a_admin/category', 
            component: Category,
            name: 'Category',
            meta:{
                title: 'Application Category Admin',
            },   
        },
        { 
            path: '/cms/a_admin/subcategory', 
            component: Subcategory,
            name: 'Subcategory',
            meta:{
                title: 'Application Subcategory Admin',
            },   
        },
        { 
            path: '/cms/a_admin/not_process', 
            component: NotProcess,
            name: 'NotProcess',
            meta:{
                title: 'Application Not Process Admin',
            },   
        },
        { 
            path: '/cms/a_admin/processing', 
            component: Processing,
            name: 'Processing',
            meta:{
                title: 'Application Processing Admin',
            },   
        },
        { 
            path: '/cms/a_admin/closed', 
            component: Closed,
            name: 'Closed',
            meta:{
                title: 'Application Closed Admin',
            },   
        },
        { 
            path: '/cms/a_admin/action', 
            component: Action,
            name: 'Action',
            meta:{
                title: 'Application Action Admin',
            },   
        },


        { 
            path: '/cms/a_admin/report', 
            component: ReportIndex,
            name: 'ReportIndex',
            meta:{
                title: 'Application Report Admin',
            },   
        },

        { 
            path: '/cms/a_admin/report_canceled', 
            component: ReportCanceled,
            name: 'ReportCanceled',
            meta:{
                title: 'Application Canceled Report Admin',
            },   
        },

        


        { 
            path: '/cms/a_admin/*', 
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