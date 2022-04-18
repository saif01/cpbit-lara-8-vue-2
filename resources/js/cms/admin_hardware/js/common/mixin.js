import axios from "axios";
import { mapGetters } from 'vuex'


import paginateMethods from './paginate_methods'
import imageMethods from './image_methods'
import createUpdate from './crud'

import store from './../store'


import globalRolePermissions from './../../../../role_permissions'

import {debounce} from './../../../../helpers'



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

        // allRepDrafts: [],
        selectDraft:'',
        
        // overlay
        overlay:false,

        // For Report search
        allZoneOffices:[],
        allDepartments:[],
        allZoneOfficesAssign:[],

        
        department:'',
        start_date:'',
        end_date:'',
        zone_office: '',
        
          
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




        // all Replay Draft
        allReplayDraft(){
            axios.get('/cms/h_admin/draft/all_data').then(response=>{
                //console.log(response.data)
                //this.allRepDrafts = response.data;
                // Store
                store.commit('setDraft', response.data )

            }).catch(error=>{
                console.log(error)
            })
        },


        // get Zone Offices
        getZoneOffices(){
            axios.get('/super_admin/user/zoneoffices').then(response=>{
                // console.log(response.data)
                this.allZoneOffices = response.data
            }).catch(error=>{
                console.log(error)
            })
        },

        // get Zone Offices
        getZoneOfficesAssign(){
            axios.get('/cms/h_admin/complain/get_user_assign_zone_offices').then(response=>{
                 console.log(response.data)
                this.allZoneOfficesAssign = response.data
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

            axios.get('/cms/h_admin/count/sidebar_count_data').then(response=>{
                //console.log(response.data)

                store.commit('setCountNotProcess', response.data.notprocess)
                store.commit('setCountProcess', response.data.process)
                store.commit('setCountDeliverable', response.data.deliverable)
                store.commit('setCountService', response.data.service )
                store.commit('setCountServiceAccess', response.data.serviceAccess )
                store.commit('setConuntHOService', response.data.hoService )
                store.commit('setConuntHOServiceAccess', response.data.hoServiceAccess )
                
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
        search: debounce(function (value) {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        }, 500),

        //Excuted When make change value 
        search_field: function (value) {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        }, 

        // selectDraft
        selectDraft: function(value){
            if(this.form.details){
                this.form.details = this.form.details + value 
            }else{
                this.form.details = value 
            }
        }, 

        start_date: function (value) {
            if(this.end_date){
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            }
        }, 

        end_date: function (value) {
            if(this.start_date){
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            }
        }, 

       
        department: function (value) {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        }, 

        zone_office: function (value) {  
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        }, 


       
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
            'auth'        : 'getAuth',
            'roles'       : 'getRoles',
            'drafts'      : 'getDraft',
            'CountNotprocess'  : 'getCountNotProcess',
            'CountProcess'     : 'getCountProcess',
            'CountDeliverable' : 'getCountDeliverable',
            'CountService'     : 'getCountService',
            'CountServiceAccess'     : 'getCountServiceAccess',
            'CountHOService'     : 'getConuntHOService',
            'CountHOServiceAccess'     : 'getConuntHOServiceAccess',
        }),

    },



  }