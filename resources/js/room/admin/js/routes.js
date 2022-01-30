import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import RoomIndex from './../pages/room/index.vue'
import ReportIndex from './../pages/report/index.vue'





const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/room/admin', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Admin Room Dashboard',
            },   
        },
        { 
            path: '/room/admin/room_index', 
            component: RoomIndex,
            name: 'RoomIndex',
            meta:{
                title: 'Admin Room Index',
            },   
        },
        { 
            path: '/room/admin/report', 
            component: ReportIndex,
            name: 'ReportIndex',
            meta:{
                title: 'Admin Report Index',
            },   
        },


        


        { 
            path: '/room/admin/*', 
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