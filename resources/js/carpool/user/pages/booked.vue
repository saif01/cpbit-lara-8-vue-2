<template>
    <div>

        <div v-if="allData">

            <v-row v-if="allData.length > 0">
                <v-col v-for="item in allData" :key="item.id" cols="12" lg="6">
                    <v-card dark :img="imagePathSm + item.car.image">
                        <div class="d-sm-flex flex-no-wrap justify-space-between">
                            <v-card-text>
                                <div class="card_text_bg py-2 pl-2">

                                   
                                        <div v-if="item.driver">Driver: <b>{{ item.driver.name }} || <a
                                                    :href="'tel:'+item.driver.contact">{{ item.driver.contact }}
                                                </a></b></div>
                                        <div  v-if="item.car">Car: {{ item.car.name }} || {{ item.car.number }}</div>
                                        <div>Destination: {{ item.destination }}</div>
                                        <div>Purpose: {{ item.purpose }}</div>
                                        <div>Booked: {{ item.start | moment("MMM Do YYYY, h:mm a") }} - To -
                                        {{ item.end | moment("MMM Do YYYY, h:mm a") }}</div>
                                    
                                   
                                </div>

                            </v-card-text>

                            <!-- <v-avatar class="ma-3" size="150"> 
                                            <v-img v-if="item.driver" :src="imagePathSmDriver + item.driver.image" alt=""></v-img>
                                        </v-avatar> -->

                            <div class="ma-3">
                                <v-img v-if="item.driver" :src="imagePathSmDriver + item.driver.image"
                                    alt="IMG" class="size_avatar mx-auto"></v-img>
                            </div>

                        </div>
                        <v-card-actions>
                            <!-- <v-btn @click="bookingModal(item)" color="indigo white--text" block rounded small>
                                <v-icon left>mdi-plus-circle-outline</v-icon>
                                Book
                            </v-btn> -->
                            <v-btn v-if="cancelBtnShow(item.start)" @click="cancelBooking(item.id)"
                                    color="error" rounded class="px-4 mx-auto">
                                    <v-icon>mdi-delete-empty</v-icon>
                                    Cancel
                                </v-btn>
                                <v-btn @click="modifyBooking(item)" color="orange" rounded class="px-4 mx-auto">
                                    <v-icon>mdi-fountain-pen-tip</v-icon>
                                    Modify
                                </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>




            <div v-else>
                <div class="p-5 my-5">
                    <p class="text-center text-info h1">Sorry !! You have no current booking. </p>
                </div>
            </div>


        </div>

        <div v-else>
            <div v-if="dataLoading" class="p-5 my-5">
                <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon>
                </p>
            </div>
        </div>





        <!-- Booking Data Modify Modal -->
        <v-dialog v-model="eventDataStoreModal" scrollable max-width="700px">
            <v-card>
                <!-- Dilog Title -->
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Modify Booking
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="eventDataStoreModal = false, resetForm()" color="red lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>

                <v-card-text>

                    <div v-if="selectedForModify.car" class="text-center rounded mb-2">
                        Car: <b>{{ selectedForModify.car.name }}</b>, Booked:
                        <b>{{ selectedForModify.start | moment("MMM Do YYYY, h:mm a") }} - To -
                            {{ selectedForModify.end | moment("MMM Do YYYY, h:mm a") }}</b>
                    </div>

                    <div class="mb-2">
                        <v-expansion-panels>
                            <v-expansion-panel>
                                <v-expansion-panel-header>
                                    <span v-if="selectedForModify.car">{{ selectedForModify.car.name }}</span> Related
                                    Bookings <v-icon>mdi-eye-check </v-icon>
                                </v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <v-card>
                                        <div v-if="relatedBookings.length > 0">
                                            <v-card-text v-for="item in relatedBookings" :key="item.id" class="bg-info">
                                                <table class="table table-sm text-center">
                                                    <tr>
                                                        <th>Purpose:</th>
                                                        <td>{{ item.purpose }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Booked: ( <span
                                                                v-if="item.bookby">{{ item.bookby.name }}</span> )</th>
                                                        <td>{{ item.start | moment("MMM Do YYYY, h:mm a") }} - To -
                                                            {{ item.end | moment("MMM Do YYYY, h:mm a") }}</td>
                                                    </tr>
                                                </table>
                                            </v-card-text>
                                        </div>

                                    </v-card>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-expansion-panels>
                    </div>

                    <v-form ref="form">

                        <form @submit.prevent="storeCurrentEventData()">

                            <v-row>
                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('destination')"
                                        v-html="form.errors.get('destination')" />
                                    <v-autocomplete dense solo :items="allDestinations" v-model="form.destination"
                                        label="Select a destination" :rules="[v => !!v || 'Destination  is required!']"
                                        required></v-autocomplete>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12" md="6">
                                    <!-- start_date -->
                                    <v-menu v-model="menu" min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.start_date" label="Start Date"
                                                prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on">
                                            </v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('start_date')"
                                                v-html="form.errors.get('start_date')" />
                                        </template>

                                        <v-date-picker v-model="form.start_date" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu = false"> Cancel</v-btn>
                                            <v-btn text color="success"> Set Today</v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <!-- end_date -->
                                    <v-menu v-model="menu2" min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.end_date" label="End Date"
                                                prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"
                                                :class="{ 'is-invalid': form.errors.has('end_date') }" required>
                                            </v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('end_date')"
                                                v-html="form.errors.get('end_date')" />
                                        </template>

                                        <v-date-picker v-model="form.end_date" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu2 = false"> Cancel</v-btn>
                                            <v-btn text color="success"> Set Today </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>


                                <v-col cols="12" md="6">
                                    <!-- start_time -->
                                    <v-menu ref="menu3" v-model="menu3" :close-on-content-click="false"
                                        :return-value.sync="time" max-width="290px" min-width="290px">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.start_time" label="Start Time"
                                                prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs"
                                                v-on="on" id="Start_Time"
                                                :class="{ 'is-invalid': form.errors.has('start_time') }" required>
                                            </v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('start_time')"
                                                v-html="form.errors.get('start_time')" />
                                        </template>
                                        <v-time-picker v-if="menu3" v-model="form.start_time" full-width
                                            @click:minute="$refs.menu3.save(time)"></v-time-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-menu ref="menu4" v-model="menu4" :close-on-content-click="false"
                                        :return-value.sync="time" max-width="290px" min-width="290px">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.end_time" label="End Time"
                                                prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs"
                                                v-on="on" required></v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('end_time')"
                                                v-html="form.errors.get('end_time')" />
                                        </template>
                                        <v-time-picker v-if="menu4" v-model="form.end_time" full-width
                                            @click:minute="$refs.menu4.save(time)"></v-time-picker>
                                    </v-menu>
                                </v-col>



                                <!-- purpose -->
                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('purpose')"
                                        v-html="form.errors.get('purpose')" />
                                    <v-textarea label="Booking Purpose" rows="2" outlined v-model="form.purpose"
                                        placeholder="Enter booking purpose in details" :rules="remRules" counter="500"
                                        required></v-textarea>
                                </v-col>

                                <v-btn type="submit" block color="teal" class="white--text"
                                    :loading="loadingdataStoreShow">
                                    <v-icon>mdi-fountain-pen-tip</v-icon> Modify
                                </v-btn>
                            </v-row>

                        </form>

                    </v-form>

                </v-card-text>
            </v-card>
        </v-dialog>


    </div>
</template>

<script>
    // vform
    import Form from 'vform';

    export default {
        data() {
            return {

                // time and date picker
                menu: false,
                menu2: false,
                menu3: false,
                menu4: false,
                time: '',

                //current page url
                currentUrl: '/carpool/booked',

                imagePath: '/images/carpool/car/',
                imagePathSm: '/images/carpool/car/small/',

                imagePathDriver: '/images/carpool/driver/',
                imagePathSmDriver: '/images/carpool/driver/small/',

                eventDataStoreModal: false,
                datePickerHeader: true,

                selectedForModify: '',


                allData: '',
                dataLoading: false,

                relatedBookings: '',
                loadingdataStoreShow: false,

                // Form
                form: new Form({
                    id: '',
                    purpose: '',
                    start_date: '',
                    start_time: '00:01:00',
                    end_date: '',
                    end_time: '23:59:00',
                    car_id: '',
                    start: '',
                    end: '',
                    car_name: '',
                    destination: '',
                }),


                allDestinations: [],
                remRules: [
                    v => (v || '').length <= 500 || 'Purpose must be 500 characters or less',
                    v => (v || '').length >= 5 || '5 characters minimum or more',
                ],



            }
        },

        methods: {

            // Booked Data
            getBookedData() {
                // Loading
                this.dataLoading = true
                axios.get(this.currentUrl + '/data').then(response => {
                    //console.log(response.data)
                    this.allData = response.data
                    // Loading
                    this.dataLoading = false
                }).catch(error => {
                    console.log(error)
                })
            },

            // getDastination
            getDastination() {
                axios.get('/carpool/booked/destinations').then(response => {
                    // console.log(response.data)
                    for (let i = 0; i < response.data.length; i++) {
                        this.allDestinations.push(response.data[i]);
                        this.allDestinations[i] = {
                            value: response.data[i].name,
                            text: response.data[i].name
                        };
                    }
                }).catch(error => {
                    console.log(error)
                })
            },


            // Modify Btn Clicked
            modifyBooking(item) {
                // Loading
                this.$Progress.start()
                // Current Data 
                this.selectedForModify = item

                axios.post(this.currentUrl + '/bycar', {
                    item
                }).then(response => {

                    this.relatedBookings = response.data

                    //console.log(item)
                    // Start
                    let startDateTime = item.start
                    let startDateTimeArr = startDateTime.split(" ")
                    let start_date = startDateTimeArr[0]
                    let start_time = startDateTimeArr[1]
                    // End
                    let endDateTime = item.end
                    let endDateTimeArr = endDateTime.split(" ")
                    let end_date = endDateTimeArr[0]
                    let end_time = endDateTimeArr[1]
                    // console.log(startDateTime, start_date, start_time)
                    // Form Data Update
                    this.form.start_date = start_date
                    this.form.start_time = start_time
                    this.form.end_date = end_date
                    this.form.end_time = end_time
                    this.form.purpose = item.purpose
                    this.form.car_id = item.car_id
                    this.form.car_name = item.car.name
                    this.form.id = item.id
                    this.form.destination = item.destination

                    // Overlay
                    this.$Progress.finish()
                    // Modal
                    this.eventDataStoreModal = true

                }).catch(error => {
                    // Overlay
                    this.$Progress.finish()
                    console.log(error)
                })

            },


            // store Current Event Data DB async
            async storeCurrentEventData() {

                let startDateTime = this.form.start_date + " " + this.form.start_time
                let endDateTime = this.form.end_date + " " + this.form.end_time

                // Check Start DateTime After End DateTime
                let dateTimeIsAfter = this.$moment(startDateTime).isAfter(endDateTime)

                // Check Start DateTime End DateTime Same 
                let dateTimeIsSame = this.$moment(startDateTime).isSame(endDateTime)
                //console.log(dateTimeIsAfter, dateTimeIsSame, startDateTime, endDateTime )

                // Check DateTime Modify or not
                let startDateTimeIsNotModified = this.$moment(this.selectedForModify.start).isSame(startDateTime)
                let endDateTimeIsNotModified = this.$moment(this.selectedForModify.end).isSame(endDateTime)

                if (startDateTimeIsNotModified && endDateTimeIsNotModified) {
                    // Same Date Time
                    Swal.fire({
                        icon: "error",
                        title: "Sorry! Datetime not changed",
                    });
                } else if (dateTimeIsAfter) {
                    // Start Date Grater
                    Swal.fire({
                        icon: "error",
                        title: "Sorry! Start time can't be greater than the end time",
                    });
                } else if (dateTimeIsSame) {
                    // Same Date Time
                    Swal.fire({
                        icon: "error",
                        title: "Sorry! Start time can't be the same as the end time",
                    });
                } else {
                    // Everything Ok
                    //final DateTime 
                    this.form.start = startDateTime
                    this.form.end = endDateTime
                    // Loading
                    this.loadingdataStoreShow = true
                    try {

                        const response = await this.form.post(this.currentUrl + '/store');
                        console.log(response.data)
                        // Overlay
                        this.loadingdataStoreShow = false
                        if (response.data.status == 'success') {

                            // Refresh Calendar
                            this.getBookedData();
                            // Hide Booking Modal
                            this.eventDataStoreModal = false
                            // Hide car Status Modal
                            this.carStatusShow = false

                            this.resetForm();

                            Swal.fire({
                                icon: response.data.icon,
                                title: response.data.msg,
                            })
                        } else {
                            // Hide Booking Modal
                            this.eventDataStoreModal = false
                            Swal.fire({
                                icon: response.data.icon,
                                title: response.data.msg,
                            })
                        }


                    } catch (error) {
                        // Overlay
                        this.loadingdataStoreShow = false
                        Swal.fire({
                            icon: 'error',
                            title: 'Sorry!! Somthing Going Wrong',
                            customClass: 'text-danger'
                        });
                        console.error(error);
                    }

                }





            },


            // cancelBtnShow
            cancelBtnShow(start) {
                // Check Start DateTime After Now DateTime
                let nowDateTimeIsAfterStart = this.$moment().isAfter(start)
                //console.log(startDateTime, nowDateTimeIsAfterStart)
                if (nowDateTimeIsAfterStart) {
                    return false
                } else {
                    return true
                }

            },


            // Change Status
            cancelBooking(id) {
                // console.log('status', data.status)

                var text = "Are you want to Cancel ?"
                var btnText = "Yes! Cancel it"

                Swal.fire({
                    title: 'Are you sure?',
                    text: text,
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: btnText,
                }).then((result) => {

                    // Send request to the server
                    if (result.value) {
                        //console.log(id);
                        this.$Progress.start();
                        this.form.post(this.currentUrl + '/status/' + id).then((response) => {
                            //console.log(response);
                            Swal.fire(
                                'Changed!',
                                'Status has been Changed.',
                                'success'
                            );
                            // Refresh Tbl Data with current page
                            this.getBookedData();
                            this.$Progress.finish();

                        }).catch((data) => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Somthing Going Wrong<br>' + data.message,
                                customClass: 'text-danger'
                            });
                            // Swal.fire("Failed!", data.message, "warning");
                        });
                    }
                })
            },



            // duration cal
            durationCal(time1, time2) {
                let now = time1;
                let then = time2;

                let duration = this.$moment.utc(this.$moment(now, "YYYY/MM/DD HH:mm:ss").diff(this.$moment(then,
                    "YYYY/MM/DD HH:mm:ss"))).format("HH");

                return duration

            },

            resetForm() {

                this.form.reset()
                this.$refs.form.resetValidation()
            }

        },

        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getBookedData();
            this.getDastination();
            this.$Progress.finish();

        }
    }

</script>


<style scoped>
    .custom_color_btn {
        background-color: #001F61;
        border: 1px solid #001F61;
        color: white;
    }

    .booking_card_details {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .bg_card {
        background: linear-gradient(120deg, rgba(70, 185, 108, 255) 60%, rgba(58, 58, 60, 255) 40%);
    }

</style>
