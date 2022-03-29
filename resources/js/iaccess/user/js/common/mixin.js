import axios from "axios";
import {
    mapGetters
} from 'vuex'


import paginateMethods from './paginate_methods'
import imageMethods from './image_methods'
import createUpdate from './crud'


import globalRolePermissions from './../../../../role_permissions'





export default {
    data() {
        return {

            // DataTbl Common Featurs 
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
            editmode: false,
            dataModelTitle: 'Store Data',
            // Loading Animation
            dataLoading: false,

            imageMaxSize: '2111775',
            fileMaxSize: '5111775',
            overlayshow: false,

            allDepartments: [],
            allOffice: [],


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


        getDepartments() {
            axios.get('/super_admin/user/departments').then(response => {
                //console.log(response.data)
                this.allDepartments = response.data

                this.allDepartments.shift();
            }).catch(error => {
                console.log(error)
            })
        },



        getOffice() {
            axios.get('/inventory/admin/new_product/office').then(response => {
                // zone_office
                response.data.office.forEach(element => {
                    this.allOffice.push({
                        value: element.zone_office,
                        text: element.zone_office
                    });
                });
            });
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


    computed: {

        // map this.count to store.state.count getLoading 
        ...mapGetters({
            'auth': 'getAuth',
            'roles': 'getRoles',
        }),

    },



}
