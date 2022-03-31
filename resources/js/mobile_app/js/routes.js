import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'



import AppVersion from './../pages/version/index.vue'
import AppRole from './../pages/role/index.vue'
import AppUser from './../pages/user/index.vue'


const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/mobile_app', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Admin Demo Dashboard',
            },   
        },

        { 
            path: '/mobile_app/version', 
            component: AppVersion,
            name: 'AppVersion',
            meta:{
                title: 'Admin App Version',
            },   
        },

        { 
            path: '/mobile_app/role', 
            component: AppRole,
            name: 'AppRole',
            meta:{
                title: 'Admin App Role',
            },   
        },

        { 
            path: '/mobile_app/user', 
            component: AppUser,
            name: 'AppUser',
            meta:{
                title: 'Admin App User',
            },   
        },

        


        { 
            path: '/mobile_app/admin/*', 
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