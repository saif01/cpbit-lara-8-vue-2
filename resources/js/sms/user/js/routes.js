import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'


const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/sms', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Room Dashboard',
            },   
        },
       
        


        { 
            path: '/demo/*', 
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