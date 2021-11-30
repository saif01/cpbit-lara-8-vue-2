require('./../../bootstrap');
window.Vue = require('vue').default;

// remixicon
import 'remixicon/fonts/remixicon.css'


Vue.component('login-component', require('./../login_form.vue').default);


const app = new Vue({
    el: '#app',
    
    data(){
        return{
          // For Preloader
          preloader:false
        }
      }
});
