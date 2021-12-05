require('../../bootstrap');
window.Vue = require('vue').default;


import  BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue)


Vue.component('login-component', require('../login_form.vue').default);


const app = new Vue({
    el: '#app',

    data(){
        return{
          // For Preloader
          preloader:false
        }
      }
});