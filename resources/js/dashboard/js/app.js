require('./../../bootstrap');
window.Vue = require('vue').default;

// Vuex File
import store from './store';

// mixin global added
import common from './mixin';
Vue.mixin(common);


// Vuetify
import Vuetify from 'vuetify'
Vue.use(Vuetify)


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
    vuetify: new Vuetify(),
    data(){
        return{
          // For Preloader
          preloader:false
        }
      }
});
