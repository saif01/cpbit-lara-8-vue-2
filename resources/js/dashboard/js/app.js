require('./../../bootstrap');
window.Vue = require('vue').default;

// Vuex File
import store from './store';

// mixin global added
import common from './mixin';
Vue.mixin(common);


import  BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue)


// VueProgressBar
import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
    color: '#66FE5E',
    failedColor: 'red',
    thickness: '3px',
});

 

Vue.component('index-component', require('./../index.vue').default);


const app = new Vue({
    el: '#app',
    store,
    
    data(){
        return{
          // For Preloader
          preloader:false
        }
      }
});
