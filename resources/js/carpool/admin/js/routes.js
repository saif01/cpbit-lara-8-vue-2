import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import CarpoolIndex from './../pages/carpool/index.vue'
import DriverIndex from './../pages/driver/index.vue'

import AllReport from './../pages/report/index.vue'
import DriverLeave from './../pages/report/driverLeave.vue'
import CarMaintenance from './../pages/report/carMaintenance.vue'
import CarRequisition from './../pages/report/carRequisition.vue'

import Destinations from './../pages/destination/index.vue'

const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/carpool/admin', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Admin Carpool Dashboard',
            },   
        },
        { 
            path: '/carpool/admin/cars', 
            component: CarpoolIndex,
            name: 'CarpoolIndex',
            meta:{
                title: 'Admin Carpool Index',
            },   
        },
        { 
            path: '/carpool/admin/drivers', 
            component: DriverIndex,
            name: 'DriverIndex',
            meta:{
                title: 'Admin Carpool Driver Index',
            },   
        },
        { 
            path: '/carpool/admin/report_all', 
            component: AllReport,
            name: 'AllReport',
            meta:{
                title: 'Admin Car All-Report',
            },   
        },

        { 
            path: '/carpool/admin/report_driver_leave', 
            component: DriverLeave,
            name: 'DriverLeave',
            meta:{
                title: 'Admin Car Driver Leave Report',
            },   
        },

        { 
            path: '/carpool/admin/report_car_maintenance', 
            component: CarMaintenance,
            name: 'CarMaintenance',
            meta:{
                title: 'Admin Car Maintenance Report',
            },   
        },

        { 
            path: '/carpool/admin/report_car_requisition', 
            component: CarRequisition,
            name: 'CarRequisition',
            meta:{
                title: 'Admin Car Requisition Report',
            },   
        },




        { 
            path: '/carpool/admin/destination', 
            component: Destinations,
            name: 'Destinations',
            meta:{
                title: 'Admin Destination Index',
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