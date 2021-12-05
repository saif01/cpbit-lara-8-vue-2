require('./../../bootstrap');
window.Vue = require('vue').default;

// // remixicon
// import 'remixicon/fonts/remixicon.css'

import  BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue)


// Vue.component('login-component', require('./../login_form.vue').default);
Vue.component('login-component', require('./../index.vue').default);


const app = new Vue({
    el: '#app',

    data(){
        return{
          // For Preloader
          preloader:false
        }
      }
});
