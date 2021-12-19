require('./../../bootstrap');
window.Vue = require('vue').default;


import  BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue)


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
