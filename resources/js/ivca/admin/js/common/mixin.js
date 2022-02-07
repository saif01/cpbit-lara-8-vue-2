import axios from "axios";
import { mapGetters } from 'vuex'
// Vuex File
// import store from './../vuex/store';

import paginateMethods from './paginate_methods'
import imageMethods from './image_methods'
import createUpdate from './crud'
import rolesPermission from './roles_permission'




export default {
    data() {
      return {
      
        // DataTbl Common Featurs 
        paginate: 10,
        search: '',
        sort_direction: 'desc',
        sort_field: 'id',
        currentPageNumber: null,
        // Our data object that holds the Laravel paginator data
        allData: {},
        totalValue: '',
        dataShowFrom: '',
        dataShowTo: '',
        editmode: false,
        dataModelTitle: 'Store Data',
        // Loading Animation
        dataLoading: false,

        imageMaxSize: '2111775',
        fileMaxSize: '5111775',

        // veutify Dilog
        dataModalDilog: false,
        valid: false,
        modalBtnLoading: false,

        // Tbl number of data show
        tblItemNumberShow:[5,10,15,25,50,100],
        search_field:'',

      }
    },

    methods: {

        
        // Permission Role check
        ...rolesPermission,
      
        // Paginate Methods
        ...paginateMethods,

        // Image Upload Methods
        ...imageMethods,

        // create Update Methods
        ...createUpdate,




    
        handleResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
        },

       
        // Add model show
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        // Edit Model show
        editModal(singleData) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(singleData);
        },



        testMethod(){
            return ' Come form common';
        },


       
        
        async callApi(method, url, dataObj) {

            try {

                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                })

            } catch (e) {
                return e.response
            }

        }

        // End Methods
    },

    watch: {

        //Excuted When make change value 
        paginate: function (value) {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        },

        //Excuted When make change value 
        search: function (value) {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        }
       
    },

    created() {
        // window.addEventListener('resize', this.handleResize);
        // this.handleResize();

    },


    mounted() {
 
    },


    destroyed() {
        // window.removeEventListener('resize', this.handleResize);
    },


    computed : {

        // map this.count to store.state.count getLoading 
        ...mapGetters({
            'auth'      : 'getAuth',
            'roles'     : 'getRoles',
        }),
       
        // All Roles Permission
        // ...rolesPermission

    },



  }