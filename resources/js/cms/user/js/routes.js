import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from './../pages/dashboard.vue'
import er404 from './../pages/common/404.vue'

import HardwareHistory from './../pages/hardware_history.vue'
import ApplicationHistory from './../pages/application_history.vue'


const router = new VueRouter({
    mode: 'history',
    routes : [
        { 
            path: '/cms/', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'CMS Dashboard',
            },   
        },
        { 
            path: '/cms/hardware_history', 
            component: HardwareHistory,
            name: 'HardwareHistory',
            meta:{
                title: 'CMS Hardware History',
            },   
        },
         { 
            path: '/cms/application_history', 
            component: ApplicationHistory,
            name: 'ApplicationHistory',
            meta:{
                title: 'CMS application History',
            },   
        },
       
        


        { 
            path: '/cms/*', 
            component: er404,
            name: 'er404',
            meta:{
                title: 'Room 404',
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