<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="6" md="3">
                        <v-autocomplete solo :items="group_names" v-model="sort_by_name" label="Select"></v-autocomplete>
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
                    <v-col cols="8">
                        <span class="error--text">{{sort_by_name}}</span> Main IP Offline 
                        <span v-if="sort_by_startDate == '' && sort_by_endDate == ''">Last <span class="teal--text">One Month</span> Reports </span> 
                        <span v-else>Reports From <span class="teal--text"> {{sort_by_startDate}} To {{sort_by_endDate}} </span> </span>
                    </v-col>

                    <v-col cols="4">
                        <v-text-field
                            v-model="newsearch"
                            append-icon="mdi-magnify"
                            label="Search"
                            hide-details
                            class="mb-5"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-card-title>


            <v-card-text>
                <div v-if="allData">
                    <v-data-table
                        :headers="headers"
                        :items="allData"
                        :items-per-page="10"
                        class="elevation-1"
                    >
                    <template v-slot:body="{ items }">
                        <tbody class="text-center">
                            <tr
                                v-for="item in items"
                                :key="item.id"
                            >
                                <td>{{ item.ip }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.date }}</td>
                                <td>{{ item.length }} minutes</td>
                            </tr>
                        </tbody>
                    </template>
                    </v-data-table>
                </div>
                <div v-else>
                    <div v-if="dataLoading" class="p-5 my-5">
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon></p>
                    </div>
                </div>
            </v-card-text>

        </v-card>

    </div>
</template>



<script>
    export default {
        data() {
            return {
                networkRules:[v => !!v || 'This field is required!'],

                //current page url
                currentUrl: '/network/admin/report',

                group_names:[],

                // offline time
                offlineTime:[],

                // offline details
                offlineDetails:[],
                
                // sort
                sort_by_name: '10.64.50.250',
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

                // for table
                headers: [
                    { text: 'IP', value: 'ip', align: 'center' },
                    { text: 'Name', value: 'name', align: 'center' },
                    { text: 'Date', value: 'date', align: 'center' },
                    { text: 'Office Time', value: 'office_time', align: 'center' },
                    { text: 'Offline Details 10 minutes Interval', value: 'offline_details', align: 'center' },
                ],

                allData:[],
            }


        },

        methods: {
            // all group name
            getAllGroupName() {
                axios.get(this.currentUrl + '/ip_name').then((response) => {
                    //this.group_names = response.data;

                    for (let i = 0; i < response.data.length; i++) {
                        this.group_names.push(response.data[i]);
                        this.group_names[i] = {value: response.data[i].ip, text: response.data[i].ip + ' || ' + response.data[i].name };
                    }
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
                axios.get(this.currentUrl+'/mainip-report?page=' + page +
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
                        console.log(response.data);
                        // all data
                        this.allData = response.data.allData;


                        for (let i = 0; i < response.data.allData.length; i++) {

                            this.allData[i].length = response.data.allData[i].length * 10;

                        }
                        
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