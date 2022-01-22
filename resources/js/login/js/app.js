require('./../../bootstrap');
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

import Login from './../pages/login.vue'
import Register from './../pages/register.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/login/',
            name: Login,
            component: Login
        },
        {
            path: '/login/register',
            name: Register,
            component: Register,
        },
    ],
});


// Vue.component('login-component', require('./../login_form.vue').default);
Vue.component('login-component', require('./../index.vue').default);


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
