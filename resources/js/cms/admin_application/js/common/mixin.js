import axios from "axios";
import store from './../store'
import { mapGetters } from 'vuex'


import paginateMethods from './paginate_methods'
import imageMethods from './image_methods'
import createUpdate from './crud'


import globalRolePermissions from './../../../../role_permissions'





export default {
    data() {
      return {
      
        paginate: 10,
        search: '',
        search_field: '',
        sort_direction: 'desc',
        sort_field: 'id',
        currentPageNumber: null,
        // Our data object that holds the Laravel paginator data
        allData: {},
        totalValue: '',
        dataShowFrom: '',
        dataShowTo: '',

        // For Modal Dilog
        dataModalDialog :false,
        // Loading Animation
        dataModalLoading: false,

        editmode: false,
        dataModelTitle: 'Store Data',
        // Loading Animation
        dataLoading: false,

        imageMaxSize: '2111775',
        fileMaxSize: '5111775',

        // Tbl number of data show
        tblItemNumberShow:[5,10,15,25,50,100],

        // v-form
        valid: false,
        
        // overlay
        overlay:false,

        // For Report search
        allZoneOffices:[],
        allDepartments:[],
      }
    },

    methods: {

        
        // Permission Role check
        ...globalRolePermissions,
      
        // Paginate Methods
        ...paginateMethods,

        // Image Upload Methods
        ...imageMethods,

        // create Update Methods
        ...createUpdate,




        // get Zone Offices
        getZoneOffices(){
            axios.get('/super_admin/user/zoneoffices').then(response=>{
                // console.log(response.data)
                this.allZoneOffices = response.data
            }).catch(error=>{
                console.log(error)
            })
        },

        // get Departments
        getDepartments(){
            axios.get('/super_admin/user/departments').then(response=>{
                //console.log(response.data)
                this.allDepartments = response.data
            }).catch(error=>{
                console.log(error)
            })
        },



        // countNotProcess
        countAll() {

            axios.get('/cms/a_admin/count/sidebar_count_data').then(response=>{
                //console.log(response.data)

                store.commit('setCountNotProcess', response.data.notprocess)
                store.commit('setCountProcess', response.data.process)
            }).
            catch(error=>{
                console.log(error)
            })
            
        },

        
     

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
        },

        //Excuted When make change value 
        search_field: function (value) {
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
            'sidebar_notprocess_counter'  : 'getCountNotProcess',
            'sidebar_process_counter'     : 'getCountProcess',
        }),

    },



  }