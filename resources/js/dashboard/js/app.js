require('./../../bootstrap');
window.Vue = require('vue').default;

// remixicon
import 'remixicon/fonts/remixicon.css'


import  BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue)
// import  IconsPlugin from 'bootstrap-vue'
// Vue.use(IconsPlugin)

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
    
    data(){
        return{
          // For Preloader
          preloader:false
        }
      }
});
