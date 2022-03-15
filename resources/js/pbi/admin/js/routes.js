import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import User from './../pages/user/index.vue'
import Role from './../pages/user/role.vue'

import ApiIndex from './../pages/api/index.vue'

const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/pbi/admin/', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'PBI Dashboard',
            },   
        },
        { 
            path: '/pbi/admin/user', 
            component: User,
            name: 'User',
            meta:{
                title: 'PBI User',
            },   
        },
        { 
            path: '/pbi/admin/role', 
            component: Role,
            name: 'Role',
            meta:{
                title: 'PBI User Role',
            },   
        },

        { 
            path: '/pbi/admin/api', 
            component: ApiIndex,
            name: 'ApiIndex',
            meta:{
                title: 'PBI All Api',
            },   
        },
       
        


        { 
            path: '/pbi/admin/*', 
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