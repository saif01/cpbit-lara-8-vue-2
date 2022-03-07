<template>
    <div>

        <h3> Car Bookings Information </h3>

        <div v-if="allData.data">

            <v-row>
                <v-col cols="2">
                    <!-- Show -->
                    <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" small>
                    </v-select>
                </v-col>

                <v-col cols="2">
                    <v-select :items="carData" label="All Cars Data" v-model="sort_by_car"></v-select>
                </v-col>

                <v-col cols="2">
                    <v-select :items="reportType" label="Select Type" v-model="sort_by_day"></v-select>
                </v-col>

                <v-col cols="2">
                    <v-menu v-model="menu" min-width="auto">
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field v-model="sort_by_startDate" label="Start Date" prepend-icon="mdi-calendar"
                                readonly v-bind="attrs" v-on="on"></v-text-field>
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
                            <v-text-field v-model="sort_by_endDate" label="End Date" prepend-icon="mdi-calendar"
                                readonly v-bind="attrs" v-on="on"></v-text-field>
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
                    <v-text-field prepend-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                        placeholder="Search Input..."></v-text-field>
                </v-col>
            </v-row>


            <v-card v-for="singleData in allData.data" :key="singleData.id" class="mb-3">
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="8">
                            {{ singleData.car.name }} || {{ singleData.car.number }} <v-badge
                                v-if="singleData.status == 1" color="teal" content="Booked" bordered></v-badge>
                            <v-badge v-else color="error" content="Cancelled" bordered></v-badge>
                        </v-col>
                        <v-col cols="4" class="text-right">
                            <v-btn color="teal white--text" small depressed
                                @click=" getBookbyModalData( singleData.bookby.id)">
                                {{ singleData.bookby.name }}
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col>
                            <div>
                                Driver: <v-btn color="indigo white--text" small depressed
                                    @click=" showDriverDialog( singleData.driver )">
                                    {{ singleData.driver.name }}
                                </v-btn>
                            </div>

                            <div>
                                Purpose: {{ singleData.purpose }}
                            </div>

                            <div>
                                Destination: {{ singleData.destination }}
                            </div>


                        </v-col>
                        <v-col class="text-right">
                            <v-row>
                                <v-col>
                                    <div>
                                        Mileage: <span v-if="singleData.start_mileage"> {{ singleData.start_mileage }}
                                            -- {{ singleData.end_mileage }} </span> <span v-else class="error--text">Not
                                            Found !!</span>
                                    </div>
                                    <div>
                                        Gasoline: <span v-if="singleData.gasoline !== null">{{ singleData.gasoline }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </div>
                                    <div>
                                        Octane: <span v-if="singleData.octane !== null">{{ singleData.octane }}</span> <span
                                            v-else class="error--text">N/A</span>
                                    </div>
                                    <div>
                                        Toll: <span v-if="singleData.toll !== null">{{ singleData.toll }}</span> <span v-else
                                            class="error--text">N/A</span>
                                    </div>
                                   
                                </v-col>
                                <v-col>
                                    <div>
                                        KM: <span v-if="singleData.km">{{ singleData.km }}</span> <span v-else
                                            class="error--text">N/A</span>
                                    </div>
                                    <div>
                                        Total: <span v-if="singleData.cost !== null">{{ singleData.cost }}</span> <span v-else
                                            class="error--text">N/A</span>
                                    </div>
                                    <div>
                                        Rating: <span
                                            v-if="singleData.driver_rating">{{ singleData.driver_rating }}</span> <span
                                            v-else class="error--text">N/A</span>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-col>

                    </v-row>
                    <div>
                        Booking Duration: <span
                            class="orange--text">{{ singleData.start  | moment("MMMM Do YYYY, h:mm a") }} </span> to
                        <span class="orange--text"> {{ singleData.end  | moment("MMMM Do YYYY, h:mm a") }} </span>
                    </div>

                </v-card-text>

            </v-card>
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



        <!-- driver infomation modal -->
        <v-dialog v-model="driverModal" max-width="600px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Driver Details
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="driverModal = false" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-list-item three-line>
                        <v-list-item-content class="text-overline">
                            <div>
                                Name: <span v-if="driverData">{{ driverData.name }}</span>
                            </div>
                            <div>
                                Contact: <span v-if="driverData">{{ driverData.contact }}</span>
                            </div>

                            <div>
                                License: <span v-if="driverData.license">{{ driverData.license }}</span> <span v-else
                                    class="error--text">Not Available !</span>
                            </div>

                            <div>
                                NID: <span v-if="driverData.nid">{{ driverData.nid }}</span> <span v-else
                                    class="error--text">Not Available !</span>
                            </div>

                        </v-list-item-content>

                        <v-list-item-avatar tile size="150">
                            <v-img v-if="driverData.image" :src="imagePath + driverData.image" alt="image" contain>
                            </v-img>
                        </v-list-item-avatar>
                    </v-list-item>
                </v-card-text>
            </v-card>
        </v-dialog>




        <v-dialog v-model="bookbyModal" max-width="900px">
            <v-card class="bg_card">
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            User Details
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="bookbyModal = false" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="9">

                            <v-row class="text-white text-overline">
                                <v-col cols="6">
                                    <div>
                                        Name: <span v-if="bookbyData">{{ bookbyData.name }}</span>
                                    </div>

                                    <div>
                                        Personal Contact: <span
                                            v-if="bookbyData.personal_contact">{{ bookbyData.personal_contact }}</span>
                                    </div>

                                    <div>
                                        Office ID: <span v-if="bookbyData.office_id">{{ bookbyData.office_id }}</span>
                                        <span v-else class="red--text">Not Available !</span>
                                    </div>

                                    <div>
                                        Office Contact: <span
                                            v-if="bookbyData.office_contact">{{ bookbyData.office_contact }}</span>
                                        <span v-else class="red--text">Not Available !</span>
                                    </div>

                                    <div>
                                        Office Email: <span
                                            v-if="bookbyData.office_email">{{ bookbyData.office_email }}</span> <span
                                            v-else class="red--text">Not Available !</span>
                                    </div>

                                    <div>
                                        Personal Email: <span
                                            v-if="bookbyData.personal_email">{{ bookbyData.personal_email }}</span>
                                        <span v-else class="red--text">Not Available !</span>
                                    </div>
                                </v-col>

                                <v-col cols="6">
                                    <div>
                                        Office: <span v-if="bookbyData.office">{{ bookbyData.office }}</span> <span
                                            v-else class="red--text">Not Available !</span>
                                    </div>

                                    <div>
                                        Zone Office: <span
                                            v-if="bookbyData.zone_office">{{ bookbyData.zone_office }}</span> <span
                                            v-else class="red--text">Not Available !</span>
                                    </div>

                                    <div>
                                        NID: <span v-if="bookbyData.nid">{{ bookbyData.nid }}</span> <span v-else
                                            class="red--text">Not Available !</span>
                                    </div>

                                    <div>
                                        Manager: <span v-if="bookbyData.manager">{{ bookbyData.manager }}</span> <span
                                            v-else class="red--text">Not Available !</span>
                                    </div>

                                    <div>
                                        Manager Email: <span
                                            v-if="bookbyData.manager_emails">{{ bookbyData.manager_emails }}</span>
                                        <span v-else class="red--text">Not Available !</span>
                                    </div>

                                    <div>
                                        Designation: <span
                                            v-if="bookbyData.department">{{ bookbyData.department }}</span> <span v-else
                                            class="red--text">Not Available !</span>
                                    </div>

                                    <div>
                                        Business Unit: <span
                                            v-if="bookbyData.business_unit">{{ bookbyData.business_unit }}</span> <span
                                            v-else class="red--text">Not Available !</span>
                                    </div>
                                </v-col>
                            </v-row>

                        </v-col>

                        <v-col cols="3">
                            <v-img v-if="bookbyData.image" :src="imagePathBookby + bookbyData.image" alt="image" contain
                                max-height="220px"></v-img>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>




    </div>

</template>


<script>
    export default {

        data() {
            return {

                // dialog
                driverModal: false,
                bookbyModal: false,

                // driverData
                driverData: '',
                bookbyData: '',

                // datepicker

                menu: '',
                menu2: '',


                //current page url
                currentUrl: '/carpool/admin/report',

                // all car data
                carData: [],

                // sort by car value
                sort_by_car: '',

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




                imageMaxSize: '5111775',
                imagePath: '/images/carpool/driver/',
                imagePathSm: '/images/carpool/driver/small/',


                imagePathBookby: '/images/users/',
                imagePathSmBookby: '/images/users/small/',

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
                        '&sort_by_car=' + this.sort_by_car +
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



            // get all car data
            getCarData() {
                axios.get(this.currentUrl + '/car-data').then(response => {

                    for (let i = 0; i < response.data.length; i++) {
                        this.carData.push(response.data[i]);
                        this.carData[i] = {
                            value: response.data[i].id,
                            text: response.data[i].name + ' || ' + response.data[i].number
                        };

                    }


                }).catch(error => {
                    console.log(error)
                })
            },




            // bookby data modal information
            getBookbyModalData(id) {

                axios.get(this.currentUrl + '/bookby-user/' + id).then(response => {

                    this.bookbyData = response.data

                    this.bookbyModal = true
                }).catch(error => {
                    console.log(error)
                })


            },


            // showDriverDialog
            showDriverDialog(val) {
                //console.log('Driver', val)
                this.driverData = val
                this.driverModal = true
            },



        },


        watch: {

            //Excuted When make change value 
            sort_by_car: function (value) {
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

            this.getCarData();
        },

        created() {

            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();

        }



    }

</script>

<style scoped>
    .image-thum-size {
        height: 50px;
        width: 100px;
    }

    .bg_card {
        background: linear-gradient(120deg, rgb(249, 168, 37) 60%, rgba(0, 0, 0, 1) 40%);
    }

</style>
