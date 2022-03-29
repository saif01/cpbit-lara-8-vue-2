<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>

                <v-col cols="6" md="3">
                    <v-select label="Search By Group Name" v-model="sort_by_name" :items="group_names" item-text="name" item-value="name">
                    </v-select>
                </v-col>

                <v-col cols="6" md="3">
                    <v-select
                        :items="reportType"
                        label="Select Type"
                        v-model="sort_by_day"
                    ></v-select>
                </v-col>

                <v-col cols="6" md="3">
                    <v-menu v-model="menu" min-width="auto" >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                            v-model="sort_by_startDate"
                            label="Start Date"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            ></v-text-field>
                        </template>

                        <v-date-picker v-model="sort_by_startDate" no-title scrollable >
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="menu = false">
                                Cancel
                            </v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-col>

                <v-col cols="6" md="3">
                    <v-menu v-model="menu2" min-width="auto">
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                            v-model="sort_by_endDate"
                            label="End Date"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            ></v-text-field>
                        </template>

                        <v-date-picker v-model="sort_by_endDate" no-title scrollable >
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="menu2 = false">
                                Cancel
                            </v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-col>

            </v-row>
                <v-row>
                    <v-col cols="10">
                        All Sub Ip Ping Reports
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text>
                <div v-if="allData.data">
                    <v-row>
                        <v-col cols="2">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" small>
                            </v-select>
                        </v-col>

                        <v-col cols="10">
                            <v-text-field prepend-icon="mdi-clipboard-text-search" v-model="newsearch" label="Search:"
                                placeholder="Search Input..."></v-text-field>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>IP</th>
                                <th>Name</th>
                                <th>Group Name</th>
                                <th>Status</th>
                                <th>Ping Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>
                                    <span v-if="singleData.ip">
                                        {{singleData.ip}}
                                    </span>
                                </td>
                                <td>
                                    <span v-if="singleData.name">
                                        {{singleData.name}}
                                    </span>
                                </td>
                                <td>
                                    <span v-if="singleData.group_name">
                                        {{singleData.group_name}}
                                    </span>
                                </td>
                                <td>
                                    <span v-if="singleData.status">
                                        {{singleData.status}}
                                    </span>
                                </td>
                                <td>
                                    <span v-if="singleData.created_at">
                                        {{singleData.created_at | moment("MMM Do YYYY, h:mm a")}}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span>Total Records: {{ totalValue }}</span>
                    </div>
                    <pagination :data="allData" :limit="3" @pagination-change-page="getResults" class="justify-content-end">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-else>
                    <div v-if="dataLoading" class="p-5 my-5">
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </v-card-text>
        </v-card>



        <!-- overlay -->
        <v-overlay :value="overlay">
            <v-progress-circular
                indeterminate
                size="64"
            ></v-progress-circular>
        </v-overlay>
    </div>
</template>



<script>
    // vform
    import Form from 'vform';
   

    export default {
      
        data() {

            return {
                // overlay
                overlay: false,

                // v-form
                valid:false,
                // dialog
                dataModalDialog:false,

                // loader
                addNetworkLoader:false,

                networkRules:[v => !!v || 'This field is required!'],


                //current page url
                currentUrl: '/network/admin/report',


              
                // Form
                form: new Form({
                    id: '',
                    ip: '',
                    name: '',
                    group_name: '',
                    status: '',
                }),


                group_names:[],
                
                // sort
                sort_by_name: '',
                sort_by_day: '',
                sort_by_startDate: '',
                sort_by_endDate: '',

                // datepicker
                menu:'',
                menu2:'',

                // report type
                reportType:[
                    {
                        value: '',
                        text: "All Reports"
                    },
                    {
                        value: "3",
                        text: "Last 3 Days Reports"
                    },
                    {
                        value: "5",
                        text: "Last 5 Days Reports"
                    },
                    {
                        value: "7",
                        text: "Last 7 Days Reports"
                    },
                    {
                        value: "10",
                        text: "Last 10 Days Reports"
                    },
                    {
                        value: "15",
                        text: "Last 15 Days Reports"
                    },
                    {
                        value: "30",
                        text: "Last 30 Days Reports"
                    },
                ],


            }


        },

        methods: {
            // all group name
            getAllGroupName() {
                axios.get(this.currentUrl + '/group_name').then((response) => {
                    this.group_names = response.data;
                }).catch((data) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong<br>'+data.message,
                        customClass: 'text-danger'
                    });
                    
                });

            },


            // Get table data
            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl+'/suball-report?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.newsearch +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field+
                        '&sort_by_name=' + this.sort_by_name +
                        '&sort_by_day=' + this.sort_by_day +
                        '&sort_by_startDate=' + this.sort_by_startDate +
                        '&sort_by_endDate=' + this.sort_by_endDate
                    )
                    .then(response => {
                        //console.log(response.data.data);
                        //console.log(response.data.from, response.data.to);
                        this.allData = response.data;
                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;
                        
                        // stick into current page
                        this.currentPageNumber  = response.data.current_page

                        //console.log('currentPageNumber: ', this.currentPageNumber)
                    
                        // Loading Animation
                        this.dataLoading = false;

                    });
                },
            

        },


        watch: {

            //Excuted When make change value 
            sort_by_name: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },

            sort_by_day: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },

            sort_by_startDate: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },

            sort_by_endDate: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            }
        },


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
            this.getAllGroupName();
        },



    }

</script>