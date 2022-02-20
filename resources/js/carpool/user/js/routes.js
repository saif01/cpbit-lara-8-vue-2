import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// Vuex File
import store from './store';

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import Booked from '../pages/booked.vue'
import Canceled from '../pages/canceled.vue'
import BookedHistory from '../pages/booked_history.vue'

import NotCommented from '../pages/not_commented.vue'
//import CarDetails from '../pages/car_details.vue'

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
            path: '/carpool/booked_history', 
            component: BookedHistory,
            name: 'BookedHistory',
            meta:{
                title: 'Car Booked History',
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

    // Not Commented Dialog Show
    if(store.state.counter >= 2){
        store.commit('setCounterDialogKey')
        store.commit('setCounterDialog', true)
    }
    
    next();
});


export default router;