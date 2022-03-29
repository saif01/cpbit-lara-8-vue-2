import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import MainIp from './../pages/mainip/index.vue'
import SubIp from './../pages/subip/index.vue'

import MainIpReport from './../pages/report/mainIpReport.vue'
import SubAllReport from './../pages/report/subAllReport.vue'

import AllGroupName from './../pages/allgroup/index.vue'

const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/network/admin', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Admin Network Dashboard',
            },   
        },
        { 
            path: '/network/admin/main-ip', 
            component: MainIp,
            name: 'MainIp',
            meta:{
                title: 'Admin Netwrok Main-IP',
            },   
        },
        { 
            path: '/network/admin/sub-ip', 
            component: SubIp,
            name: 'SubIp',
            meta:{
                title: 'Admin Netwrok Sub-IP',
            },   
        },
        { 
            path: '/network/admin/mainip-report', 
            component: MainIpReport,
            name: 'MainIpReport',
            meta:{
                title: 'Admin Network Main-Ip Report',
            },   
        },
        { 
            path: '/network/admin/suball-report', 
            component: SubAllReport,
            name: 'SubAllReport',
            meta:{
                title: 'Admin Network Sub-All Report',
            },   
        },



        { 
            path: '/network/admin/all-groups', 
            component: AllGroupName,
            name: 'AllGroupName',
            meta:{
                title: 'Admin Network All-Groups',
            },   
        },



        { 
            path: '/carpool/admin/*', 
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