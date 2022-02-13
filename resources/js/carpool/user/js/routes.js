import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import Booked from '../pages/booked.vue'
import Canceled from '../pages/canceled.vue'

import NotCommented from '../pages/not-commented.vue'
import CarDetails from '../pages/car-details.vue'

const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/carpool/', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Car Dashboard',
            },   
        },
        { 
            path: '/carpool/booked', 
            component: Booked,
            name: 'Booked',
            meta:{
                title: 'Car Booked',
            },   
        },
        { 
            path: '/carpool/canceled', 
            component: Canceled,
            name: 'Canceled',
            meta:{
                title: 'Car Canceled',
            },   
        },
        { 
            path: '/carpool/not-commented', 
            component: NotCommented,
            name: 'notCommented',
            meta:{
                title: 'Car Not Commented',
            },   
        },
        { 
            path: '/carpool/car-details', 
            component: CarDetails,
            name: 'carDetails',
            meta:{
                title: 'Car Not Commented',
            },   
        },
        







        { 
            path: '/Car/*', 
            component: er404,
            name: 'er404',
            meta:{
                title: 'Car 404',
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