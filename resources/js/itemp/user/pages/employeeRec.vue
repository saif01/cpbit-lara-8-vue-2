<template>
    <div>

        <div class="d-flex justify-content-between">
            <h3>All Employee Records</h3>

            
        </div>
        

        <div v-if="allData.data">

            <v-row>
                <v-col cols="2">
                    <!-- Show -->
                    <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" outlined dense>
                    </v-select>
                </v-col>

                <v-col cols="2">
                    <v-autocomplete :items="userData" label="All Users" item-text="name" item-value="name" v-model="sort_by_user" outlined dense></v-autocomplete>
                </v-col>

                <v-col cols="2">
                    <v-select :items="reportType" label="Select Type" v-model="sort_by_day" outlined dense></v-select>
                </v-col>

                <v-col cols="2">
                    <v-menu v-model="menu" min-width="auto">
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field v-model="sort_by_startDate" label="Start Date" prepend-inner-icon="mdi-calendar"
                                readonly v-bind="attrs" v-on="on" outlined dense></v-text-field>
                        </template>

                        <v-date-picker v-model="sort_by_startDate" no-title scrollable>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="menu = false">
                                Cancel
                            </v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-col>

                <v-col cols="2">
                    <v-menu v-model="menu2" min-width="auto">
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field v-model="sort_by_endDate" label="End Date" prepend-inner-icon="mdi-calendar"
                                readonly v-bind="attrs" v-on="on" outlined dense></v-text-field>
                        </template>

                        <v-date-picker v-model="sort_by_endDate" no-title scrollable>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="menu2 = false">
                                Cancel
                            </v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-col>

                <v-col cols="2">
                    <v-text-field prepend-inner-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                        placeholder="Search Input..." outlined dense></v-text-field>
                </v-col>
            </v-row>


            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Department
                        </th>
                        <th>
                            Temparature
                        </th>
                        <th>
                            Date
                        </th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="singleData in allData.data" :key="singleData.id">
                        <td>
                            {{singleData.emp_id}}
                        </td>

                        <td>
                            {{singleData.name}}
                        </td>

                        <td>
                            {{singleData.department}}
                        </td>

                        <td>

                            <span v-if="singleData.temp_final > 100">
                                <v-btn class="error">{{singleData.temp_final}}</v-btn>
                            </span>

                            <span v-else>
                                <v-btn class="success">{{singleData.temp_final}}</v-btn>
                            </span>
                            
                        </td>

                        <td>
                            {{singleData.created_at | moment("MMM Do YYYY")}}
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
                <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon>
                </p>
            </div>
        </div>
        <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>


    </div>

</template>


<script>
    export default {

        data() {
            return {

                //current page url
                currentUrl: '/itemp/admin/report/employee-records',

                // all car data
                userData: [],

                // sort by car value
                sort_by_user: '',

                // sort by day
                sort_by_day: '',

                // sort by between date
                sort_by_startDate: '',
                sort_by_endDate: '',

                // report type
                reportType: [{
                        value: '',
                        text: "All"
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

                // datepicker
                menu: '',
                menu2: '',



            }


        },

        methods: {

            // Get table data
            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl + '/index?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field +
                        '&sort_by_user=' + this.sort_by_user +
                        '&sort_by_day=' + this.sort_by_day +
                        '&sort_by_startDate=' + this.sort_by_startDate +
                        '&sort_by_endDate=' + this.sort_by_endDate
                    )
                    .then(response => {
                        // console.log(response.data.data);
                        //console.log(response.data.from, response.data.to);
                        this.allData = response.data;
                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;

                        // Loading Animation
                        this.dataLoading = false;

                    });
            },



            // get all user data
            getUserData() {
                axios.get(this.currentUrl + '/emp_data').then(response => {

                    this.userData = response.data;

                }).catch(error => {
                    console.log(error)
                })
            },





        },


        watch: {

            //Excuted When make change value 
            sort_by_user: function (value) {
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

            this.getUserData();
        },

        created() {

            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();

        }



    }

</script>
