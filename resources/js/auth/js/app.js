require('../../bootstrap');
window.Vue = require('vue').default; 

// vuetify
// import Vuetify from 'vuetify/lib'
// Vue.use(Vuetify)
// import Vuetify from "./../../../Plugins/vuetify"

import Vuetify from 'vuetify'
Vue.use(Vuetify)

// import  BootstrapVue from 'bootstrap-vue';
// Vue.use(BootstrapVue)

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Login from '../pages/login.vue'
import Register from '../pages/register.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/login',
            name: 'Login',
            component: Login,
            meta:{
                title: 'Login',
            }, 
        },
        {
            path: '/register',
            name: 'Register',
            component: Register,
            meta:{
                title: 'Register',
            }, 
        },

        { 
            path: '/login/*', 
            component: Login,
            name: 'error',
            meta:{
                title: 'Login',
            },   
        },
        { 
            path: '/register/*', 
            component: Login,
            name: 'error2',
            meta:{
                title: 'Login',
            },   
        },
    ],
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



// VueProgressBar
import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
    color: '#66FE5E',
    failedColor: 'red',
    thickness: '3px',
});

// sweetalert2
import Swal from 'sweetalert2';
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
  })
window.Swal = Swal;
window.Toast = Toast;


Vue.component('index-component', require('../index.vue').default);


const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify(),

    data(){
        return{
          // For Preloader
          preloader:false
        }
      }
});
