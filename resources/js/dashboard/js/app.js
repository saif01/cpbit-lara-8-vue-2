require('./../../bootstrap');
window.Vue = require('vue').default;

// remixicon
import 'remixicon/fonts/remixicon.css'


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
