require('./../../bootstrap');
window.Vue = require('vue').default;


import  BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue)



// sweetalert2
import Swal from 'sweetalert2';
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    // onOpen: (toast) => {
    //   toast.addEventListener('mouseenter', Swal.stopTimer)
    //   toast.addEventListener('mouseleave', Swal.resumeTimer)
    // }
  })
window.Swal = Swal;
window.Toast = Toast;


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
