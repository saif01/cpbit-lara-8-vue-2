<template>


    <div class='container py-5'>
        <div>
            <v-overlay :value="overlayCalanderShow" indeterminate size="64">
                <FullCalendar :options='calendarOptions'></FullCalendar>
            </v-overlay>
        </div>


        <!-- Single Event data Show Modal -->
        <v-dialog v-model="eventDetailsModal">
            <v-card>
                <v-card-title>
                    Booked Details
                </v-card-title>
                <v-card-text>

                
                    <table class="table small">
                        <tr>
                            <th>Purpose : </th>
                            <td v-if="clickCurrentEvetData.extendedProps">{{ clickCurrentEvetData.extendedProps.purpose }}</td>
                        </tr>
                        <tr>
                            <th>Start : </th>
                            <td v-if="clickCurrentEvetData.start">
                                {{ clickCurrentEvetData.start | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</td>
                        </tr>
                        <tr>
                            <th>End : </th>
                            <td v-if="clickCurrentEvetData.end">
                                {{ clickCurrentEvetData.end | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</td>
                        </tr>
                        <tr>
                            <th>Created At : </th>
                            <td v-if="clickCurrentEvetData.extendedProps">
                                {{ clickCurrentEvetData.extendedProps.created_at | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}
                            </td>
                        </tr>
                        <tr>
                            <th>Booked By : </th>
                            <td>
                                <div class="row">
                                    <div class="col-3">
                                        <span v-if="clickCurrentEvetData.extendedProps"><img
                                                :src="'/images/users/small/' +clickCurrentEvetData.extendedProps.bookby.image"
                                                alt="image" class="img-fluid img-thumbnail" height="80" width="60">
                                        </span>
                                    </div>
                                    <div class="col-9">
                                        <span v-if="clickCurrentEvetData.extendedProps">
                                            <b>Name: </b>{{ clickCurrentEvetData.extendedProps.bookby.name }} <br>
                                            <b>Department: </b>{{ clickCurrentEvetData.extendedProps.bookby.department }}
                                        </span>
                                    </div>
                                </div>
                            </td>


                        </tr>

                    </table>
                </v-card-text>
            </v-card>
        </v-dialog>


        <!-- Booking Data Store Modal -->
        <v-dialog v-model="eventDataStoreModal" scrollable >
            <v-card>
                <v-card-title>
                    Conform Booking
                </v-card-title>
                <v-card-body>
                
                    <v-overlay :value="overlaydataStoreShow" indeterminate size="64">

                        <div v-if="currentSelectedRoom" class="bg-info text-center rounded mb-2">
                            Selected Room: <b>{{ currentSelectedRoom.name }}</b>, Capacity:
                            <b>{{ currentSelectedRoom.capacity }}</b>
                        </div>

                        <form @submit.prevent="storeCurrentEventData()">

                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-menu v-model="menu" min-width="auto" >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                            v-model="form.start_date"
                                            label="Start Date"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                            :class="{ 'is-invalid': form.errors.has('start_date') }"
                                            required
                                            ></v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('start_date')"
                                            v-html="form.errors.get('start_date')" />
                                        </template>

                                        <v-date-picker v-model="form.start_date" no-title scrollable >
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu = false">
                                                Cancel
                                            </v-btn>

                                            <v-btn text color="success" >
                                                Set Today
                                            </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-menu v-model="menu2" min-width="auto" >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                            v-model="form.end_date"
                                            label="End Date"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                            :class="{ 'is-invalid': form.errors.has('end_date') }"
                                            required
                                            ></v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('end_date')"
                                            v-html="form.errors.get('end_date')" />
                                        </template>

                                        <v-date-picker v-model="form.end_date" no-title scrollable >
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu2 = false">
                                                Cancel
                                            </v-btn>

                                            <v-btn text color="success" >
                                                Set Today
                                            </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>

                                
                                <v-col cols="12" md="6">
                                    <v-menu
                                        ref="menu3"
                                        v-model="menu3"
                                        :close-on-content-click="false"
                                        :return-value.sync="time"
                                        max-width="290px"
                                        min-width="290px"
                                    >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                        v-model="form.start_time"
                                        label="Start Time"
                                        prepend-icon="mdi-clock-time-four-outline"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        id="Start_Time"
                                        :class="{ 'is-invalid': form.errors.has('start_time') }"
                                        required
                                        ></v-text-field>
                                        <div class="small text-danger" v-if="form.errors.has('start_time')"
                                            v-html="form.errors.get('start_time')" />
                                    </template>
                                    <v-time-picker
                                        v-if="menu3"
                                        v-model="form.start_time"
                                        full-width
                                        @click:minute="$refs.menu3.save(time)"
                                    ></v-time-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-menu
                                        ref="menu4"
                                        v-model="menu4"
                                        :close-on-content-click="false"
                                        :return-value.sync="time"
                                        max-width="290px"
                                        min-width="290px"
                                    >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                        v-model="form.end_time"
                                        label="End Time"
                                        prepend-icon="mdi-clock-time-four-outline"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        v-if="form.errors.has('end_time')"
                                        id="End_Time"
                                        required
                                        ></v-text-field>
                                        <div class="small text-danger" v-if="form.errors.has('end_time')"
                                            v-html="form.errors.get('end_time')" />
                                    </template>
                                    <v-time-picker
                                        v-if="menu4"
                                        v-model="form.end_time"
                                        full-width
                                        @click:minute="$refs.menu4.save(time)"
                                    ></v-time-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12">
                                    <v-textarea label="Booking Purpose" rows="2" id="purpose" v-model="form.purpose" placeholder="Enter booking purpose in details" :class="{ 'is-invalid': form.errors.has('purpose') }" required></v-textarea>
                                </v-col>

                                <v-btn block dense color="teal" class="white--text" v-if="!form.progress">
                                    <v-icon>mdi-plus-circle-outline</v-icon>
                                    Create
                                </v-btn>
                                
                            </v-row>

                            <!-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <b-form-datepicker v-model="form.start_date" today-button reset-button close-button
                                            locale="en" placeholder="YYYY-MM-DD" autocomplete="off" 
                                            :hide-header="datePickerHeader"
                                            :date-format-options="{ year: 'numeric', month: 'long', day: 'numeric' }"
                                            :class="{ 'is-invalid': form.errors.has('start_date') }" required>
                                        </b-form-datepicker>
                                        <div class="small text-danger" v-if="form.errors.has('start_date')"
                                            v-html="form.errors.get('start_date')" />

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <b-form-datepicker v-model="form.end_date" today-button reset-button close-button
                                            locale="en" placeholder="YYYY-MM-DD" autocomplete="off" 
                                            :hide-header="datePickerHeader"
                                            :date-format-options="{ year: 'numeric', month: 'long', day: 'numeric' }"
                                            :class="{ 'is-invalid': form.errors.has('end_date') }" required>
                                        </b-form-datepicker>
                                        <div class="small text-danger" v-if="form.errors.has('end_date')"
                                            v-html="form.errors.get('end_date')" />
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Start_Time">Start Time</label>
                                        <b-form-timepicker minutes-step="15" id="Start_Time" v-model="form.start_time" now-button reset-button
                                            locale="en"  :class="{ 'is-invalid': form.errors.has('start_time') }"
                                            required>
                                        </b-form-timepicker>
                                        <div class="small text-danger" v-if="form.errors.has('start_time')"
                                            v-html="form.errors.get('start_time')" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="End_Time">End Time</label>
                                        <b-form-timepicker  minutes-step="15" id="End_Time" v-model="form.end_time" now-button reset-button
                                            locale="en"  :class="{ 'is-invalid': form.errors.has('end_time') }"
                                            required>
                                        </b-form-timepicker>
                                        <div class="small text-danger" v-if="form.errors.has('end_time')"
                                            v-html="form.errors.get('end_time')" />
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="purpose">Booking Purpose</label>
                                        <b-form-textarea id="purpose" v-model="form.purpose" 
                                            placeholder="Enter booking purpose in details"
                                            :class="{ 'is-invalid': form.errors.has('purpose') }" required></b-form-textarea>
                                        <div class="small text-danger" v-if="form.errors.has('purpose')"
                                            v-html="form.errors.get('purpose')" />
                                    </div>
                                </div>
                            </div> -->

                            <!-- <b-form-group v-if="!form.progress">
                                <b-button type="submit" class="btn-block" variant="success"><i class="fas fa-plus-circle"></i>
                                    Submit</b-button>
                            </b-form-group> -->

                        </form>

                    </v-overlay>

                </v-card-body>
            </v-card>
        </v-dialog>


        <!-- Room Details for Booking -->
        <v-dialog v-model="roomStatusShow"  scrollable>
            <v-card>
                <v-card-title>Select Room for Booking</v-card-title>

                <v-card-text>

                    <v-overlay :value="overlayRoomStatusShow" indeterminate size="64">

                        <!-- All Free Rooms -->
                        <table v-if="freeRooms.length > 0"
                            class="table table-striped table-bordered table-hover table-sm text-center">
                            <thead class="bg-success">
                                <tr>
                                    <th colspan="3" class="text-center booking_table_border p-0"><span
                                            style="border-bottom:2px solid white">All Free Rooms</span></th>
                                </tr>
                                <tr>
                                    <th class="booking_table_border">Room</th>
                                    <th class="booking_table_border">Details</th>
                                    <th class="booking_table_border">Book</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="singleData in  freeRooms" :key="singleData.id">
                                    <td>
                                        <img v-if="singleData.image" :src="imagePathSm + singleData.image" alt="image"
                                            class="img-fluid" height="50" width="80">

                                    </td>
                                    <td>
                                        <b>Name:</b> {{ singleData.name }} <br>
                                        <b>Capacity:</b> {{ singleData.capacity }}
                                    </td>
                                    <td>
                                        <v-btn @click="bookingModal(singleData)"  color="teal">
                                            <v-icon>mdi-plus-circle-outline</v-icon>    
                                            Book
                                        </v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- All Persial Free Rooms -->
                        <table v-if="bookings.length > 0"
                            class="table table-striped table-bordered table-hover table-sm text-center">
                            <thead class="bg-warning">
                                <tr>
                                    <th colspan="3" class="text-center booking_table_border p-0"><span
                                            style="border-bottom:2px solid black">All Partial Booked Rooms</span></th>
                                </tr>
                                <tr>
                                    <th class="booking_table_border">Room</th>
                                    <th class="booking_table_border">Details</th>
                                    <th class="booking_table_border">Book</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="singleData in bookings" :key="singleData.id">
                                    <td>
                                        <span v-if="singleData.room">
                                            <img v-if="singleData.room.image" :src="imagePathSm + singleData.room.image"
                                                alt="image" class="img-fluid" height="50" width="80">
                                        </span>
                                    </td>
                                    <td class="text-left">
                                        <span v-if="singleData.room">
                                            <b>Name:</b> {{ singleData.room.name }} <br>
                                        </span>
                                        <span v-if="singleData.room">
                                            <b>Capacity:</b> {{ singleData.room.capacity }} <br>
                                        </span>
                                        <b>Booked:</b> {{ singleBookedTimeShow(singleData.start, singleData.end) }} <br>
                                        <span v-if="singleData.bookby">
                                            <b>Booked By:</b> {{ singleData.bookby.name }} <br>
                                        </span>
                                    </td>
                                    <td>
                                        <v-btn @click="bookingModal(singleData.room)"  color="orange">
                                            <v-icon>mdi-plus-circle-outline</v-icon> 
                                            Book
                                        </v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </v-overlay>

                </v-card-text>
            </v-card>

        </v-dialog>


    </div>

</template>


<script>
    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import timeGridPlugin from '@fullcalendar/timegrid'
    import interactionPlugin from '@fullcalendar/interaction'

    // vform
    import Form from 'vform';
    import axios from 'axios'

    import {
        BPopover
    } from 'bootstrap-vue'


    export default {
        components: {
            FullCalendar // make the <FullCalendar> tag available
        },
        data: function () {
            return {
                // time and date picker
                menu:false,
                menu2:false,
                menu3:false,
                menu4:false,
                time:'',

                calendarOptions: {
                    plugins: [
                        dayGridPlugin,
                        timeGridPlugin,
                        interactionPlugin // needed for dateClick
                    ],
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    initialView: 'dayGridMonth',
                    editable: true,
                    selectable: true,
                    selectMirror: true,
                    dayMaxEvents: true,
                    weekends: true,
                    select: this.handleDateSelect,
                    eventClick: this.handleEventClick,
                    // eventsSet: this.handleEvents,
                    themeSystem: 'bootstrap',
                    weekNumbers: true,
                    eventLongPressDelay: 0,
                    selectLongPressDelay: 0,
                    longPressDelay: 0,
                    events: "",
                    eventBackgroundColor: "rgb(24, 130, 42)",
                    eventBorderColor: "red",
                    displayEventTime: false,
                    // For Mouse Hover
                    eventDidMount: this.onEventRender,
                    height: 550,

                },



                clickCurrentEvetData: '',
                datePickerHeader: true,

                // Form
                form: new Form({
                    purpose: '',
                    start_date: '',
                    start_time: '00:01:00',
                    end_date: '',
                    end_time: '23:59:00',
                    remarks: '',
                    room_id: '',
                    start: '',
                    end: '',
                    room_name: ''
                }),

                //current page url
                currentUrl: '/room/booking',

                imagePath: '/images/room/',
                imagePathSm: '/images/room/small/',

                roomStatusShow: false,
                eventDataStoreModal: false,
                eventDetailsModal: false,
                // Overlay
                overlayCalanderShow: false,
                overlayRoomStatusShow: false,
                overlaydataStoreShow: false,

                freeRooms: {},
                bookings: {},

                currentSelectedRoom: '',




            }
        },
        methods: {

            // Fetch Data from DB
            async getDataAsync() {
                try {
                    const response = await axios.get(this.currentUrl + '/data');
                    // Data assign to calendar
                    this.calendarOptions.events = response.data
                    console.log(response.data);
                } catch (error) {
                    console.error(error);
                }
            },

            // Mouse hover data
            onEventRender: function (args) {
                //console.log(args.event.extendedProps.bookby.name, args.event.start )
                let titleStr = args.event.title
                let contentStr = this.$moment(args.event.start).format("MMM Do, h:mm:ss a") + " - " + this.$moment(args.event.start).format("MMM Do, h:mm:ss a");

                new BPopover({
                    propsData: {
                        title: titleStr,
                        content: contentStr,
                        placement: 'auto',
                        boundary: 'scrollParent',
                        boundaryPadding: 3,
                        delay: 50,
                        offset: 0,
                        triggers: 'hover',
                        html: true,
                        target: args.el,
                        variant: "info",
                        customClass: "custom-tooltrip"
                    }
                }).$mount()
            },

            // Single Event Data Show
            handleEventClick(clickInfo) {
                // Modal Show
                this.eventDetailsModal = true;
                // Asign Current event data
                this.clickCurrentEvetData = clickInfo.event;

                //console.log('clickInfo', this.clickCurrentEvetData.title, this.clickCurrentEvetData.extendedProps)

            },



            // singleBookedTimeShow For Table data
            singleBookedTimeShow(start, end) {

                // this.$moment(start).format("MMM Do , h:mm a")
                let finalOutput
                let startDate = this.$moment(start).format("DD-MM-YYYY")
                let startEnd = this.$moment(end).format("DD-MM-YYYY")

                if (startDate == startEnd) {
                    let startTime = this.$moment(start).format("h:mm a")
                    let endTime = this.$moment(end).format("h:mm a")
                    finalOutput = startDate + ", " + startTime + "- To " + endTime
                    //console.log(startDate)
                } else {
                    let startDateTime = this.$moment(start).format("MMM Do , h:mm a")
                    let endDateTime = this.$moment(end).format("MMM Do , h:mm a")
                    finalOutput = startDateTime + " - To - " + endDateTime
                }

                return finalOutput


            },



            // Data Select From Calendar
            async handleDateSelect(selectInfo) {
                // Overlay
                this.overlayCalanderShow = true

                //select Previous Date
                if (this.$moment().diff(selectInfo.startStr, 'days') > 0) {
                    //alert("Can Not Select Previous Date");
                    Swal.fire({
                        icon: 'error',
                        title: 'Can Not Select Previous Date',
                        customClass: 'text-danger'
                    });
                    // Overlay
                    this.overlayCalanderShow = false
                    return false;
                }

                // Generate a new date for manipulating in the next step
                let endDate = new Date(selectInfo.endStr.valueOf());
                endDate.setDate(endDate.getDate() - 1); // One days passed
                let newEndDate = new Date(endDate);
                //let actualEndDate =  this.$moment(newEndDate).format("Y-MM-DD")

                let strDate = JSON.stringify(newEndDate)
                let actualEndDate = strDate.slice(1, 11)

                // // Assign Data
                this.form.start_date = selectInfo.startStr;
                this.form.end_date = actualEndDate;

                try {
                    let selectData = {
                        start_date: selectInfo.startStr,
                        start_time: '00:01:00',
                        end_date: actualEndDate,
                        end_time: '23:59:00',
                    }

                    const response = await axios.post(this.currentUrl + '/room', {
                        selectData
                    });

                    console.log(response.data);

                    this.freeRooms = response.data.rooms
                    this.bookings = response.data.bookings

                    // Modal Show
                    this.roomStatusShow = true;

                    // Overlay
                    this.overlayCalanderShow = false

                    //console.log('selectInfo', selectInfo, selectInfo.startStr, selectInfo.endStr, newEndDate, actualEndDate)

                } catch (error) {
                    // Overlay
                    this.overlayCalanderShow = false
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!! Somthing Going Wrong',
                        customClass: 'text-danger'
                    });
                    console.error(error);
                }


            },


            // Show Booking Modal
            bookingModal(room) {
                // show Modal
                this.eventDataStoreModal = true
                this.form.room_id = room.id
                this.form.room_name = room.name
                this.currentSelectedRoom = room
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

                if (dateTimeIsAfter) {
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
                    // Overlay
                    this.overlaydataStoreShow = true
                    try {

                        const response = await this.form.post(this.currentUrl + '/store');
                        console.log(response.data)
                        // Overlay
                        this.overlaydataStoreShow = false
                        if (response.data.status == 'success') {

                            // Refresh Calendar
                            this.getDataAsync();
                            // Hide Booking Modal
                            this.eventDataStoreModal = false
                            // Hide Room Status Modal
                            this.roomStatusShow = false

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
                        this.overlaydataStoreShow = false
                        Swal.fire({
                            icon: 'error',
                            title: 'Sorry!! Somthing Going Wrong',
                            customClass: 'text-danger'
                        });
                        console.error(error);
                    }

                }





            },



        },




        created() {
            this.$Progress.start();
            // Data fetch from DB
            this.getDataAsync();
            this.$Progress.finish();
        }


    }

</script>




<style>
    .fc .fc-toolbar.fc-header-toolbar {
        font-size: .8em !important;
    }

    @media (max-width: 767.98px) {
        .fc .fc-toolbar.fc-header-toolbar {
            display: block;
            text-align: center;
        }

        .fc-header-toolbar .fc-toolbar-chunk {
            display: block;
        }
    }

    td .fc-day-fri {
        background-color: #f0c2be !important;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background-color: var(--fc-today-bg-color, rgba(251, 242, 107, 0.99));
    }

    .custom-tooltrip {
        font-weight: bold;
        color: black !important;
        /* font-size: 18px; */
    }

    .booking_table_border {
        border-bottom: 1px solid transparent !important;
        border-right: 1px solid transparent !important;
    }

    /* .a {
        color: #290cf0 !important;
    } */

</style>
