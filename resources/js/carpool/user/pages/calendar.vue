<template>
    <div class='container py-5'>

        <div>
            <FullCalendar :options='calendarOptions'></FullCalendar>
        </div>



        <!-- Single Event data Show Modal -->
        <v-dialog persistent v-model="eventDetailsModal" max-width="800px" scrollable>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Booked Details
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="eventDetailsModal = false" color="red lighten-1" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <table class="table">
                        <tr>
                            <th>Purpose : </th>
                            <td v-if="clickCurrentEvetData.extendedProps">
                                {{ clickCurrentEvetData.extendedProps.purpose }}</td>
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
                                        <v-avatar size="50" >
                                            <v-img v-if="clickCurrentEvetData.extendedProps"><img
                                                :src="'/images/users/small/' +clickCurrentEvetData.extendedProps.bookby.image" alt="image">
                                            </v-img>
                                        </v-avatar>
                                       
                                    </div>
                                    <div class="col-9">
                                        <span v-if="clickCurrentEvetData.extendedProps">
                                            <b>Name: </b>{{ clickCurrentEvetData.extendedProps.bookby.name }} <br>
                                            <b>Department:
                                            </b>{{ clickCurrentEvetData.extendedProps.bookby.department }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <!-- {{ clickCurrentEvetData }} -->
                        <!-- Car and Driver -->
                        <tr>
                            <th>Car and Driver Details :</th>
                            <td>
                                <span>
                                    <v-row>

                                            <v-col cols="12" lg="3">
                                                 <v-avatar size="60">
                                                    <v-img v-if="clickCurrentEvetData.extendedProps"><img
                                                        :src="'/images/carpool/driver/small/' +clickCurrentEvetData.extendedProps.driver.image" alt="image">
                                                    </v-img>
                                                </v-avatar>
                                            </v-col>
                                       
                                            <v-col  cols="12" lg="9">
                                                <div>
                                                <b>Car: </b> <span v-if="clickCurrentEvetData.extendedProps">{{ clickCurrentEvetData.extendedProps.car.number }} </span> 
                                                <span v-else class="error--text">N/A</span>
                                            </div>

                                            <div>
                                                <b>Driver: </b>
                                                <span v-if="clickCurrentEvetData.extendedProps">{{clickCurrentEvetData.extendedProps.driver.name}}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            <div>
                                                <b>Contact: </b><a v-if="clickCurrentEvetData.extendedProps" :href="'tel:'+clickCurrentEvetData.extendedProps.driver.contact" >{{clickCurrentEvetData.extendedProps.driver.contact}}</a>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            </v-col>

                                       
                                    </v-row>
                                </span>
                            </td>
                        </tr>
                        
                        <!-- Comment Details -->
                        <tr>
                            <th>Comment Details :</th>
                            <td>
                                <span v-if="clickCurrentEvetData.extendedProps">
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <div>
                                            <div>
                                                <b>Mileage: </b> <span v-if="clickCurrentEvetData.extendedProps.start_mileage">{{ clickCurrentEvetData.extendedProps.start_mileage }} </span> 
                                                <span v-if="clickCurrentEvetData.extendedProps.end_mileage"> -- {{ clickCurrentEvetData.extendedProps.end_mileage }} </span> 

                                                <span v-if="clickCurrentEvetData.extendedProps.start_mileage && clickCurrentEvetData.extendedProps.end_mileage">( {{clickCurrentEvetData.extendedProps.end_mileage - clickCurrentEvetData.extendedProps.start_mileage}} KM )</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>

                                            <div>
                                                <b>Total Bill: </b><span v-if="clickCurrentEvetData.extendedProps.cost !== null">{{clickCurrentEvetData.extendedProps.cost}}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>

                                            <div>
                                                <b>Driver Rating: </b><span v-if="clickCurrentEvetData.extendedProps.driver_rating">{{clickCurrentEvetData.extendedProps.driver_rating}}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            
                                        </div>

                                        <div>
                                            <div>
                                                <b>Gasoline: </b><span v-if="clickCurrentEvetData.extendedProps.gas !== null">{{clickCurrentEvetData.extendedProps.gas}}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>

                                            <div>
                                                <b>Octane: </b><span v-if="clickCurrentEvetData.extendedProps.octane !== null">{{clickCurrentEvetData.extendedProps.octane}}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>

                                            <div>
                                                <b>Toll: </b><span v-if="clickCurrentEvetData.extendedProps.toll !== null">{{clickCurrentEvetData.extendedProps.toll}}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </span>
                            </td>
                        </tr>


                    </table>
                </v-card-text>
            </v-card>
        </v-dialog>


        <!-- Booking Data Store Modal -->
        <v-dialog persistent v-model="eventDataStoreModal" max-width="700px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Conform Booking
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="eventDataStoreModal = false, resetForm() " color="red lighten-1" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>

                    <div v-if="currentSelectedCar" class="bg-info text-center rounded mb-2">
                        Selected Car: <b>{{ currentSelectedCar.name }}</b>, Capacity:
                        <b>{{ currentSelectedCar.capacity }}</b>
                    </div>

                    <v-form ref="form">
                        <form @submit.prevent="storeCurrentEventData()">

                            <v-row>
                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('destination')" v-html="form.errors.get('destination')" />
                                    <v-autocomplete dense solo :items="allDestinations" v-model="form.destination" label="Select a destination" :rules="[v => !!v || 'Destination  is required!']" required></v-autocomplete>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12" md="6">
                                    <!-- start_date -->
                                    <v-menu v-model="menu" min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.start_date" label="Start Date"
                                                prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" required>
                                            </v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('start_date')"
                                                v-html="form.errors.get('start_date')" />
                                        </template>

                                        <v-date-picker v-model="form.start_date" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                                            <v-btn text color="success"> Set Today</v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <!-- end_date -->
                                    <v-menu v-model="menu2" min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.end_date" label="End Date"
                                                prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" required>
                                            </v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('end_date')"
                                                v-html="form.errors.get('end_date')" />
                                        </template>
                                        <v-date-picker v-model="form.end_date" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu2 = false"> Cancel</v-btn>
                                            <v-btn text color="success">Set Today</v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>


                                <v-col cols="12" md="6">
                                    <!-- start_time -->
                                    <v-menu ref="menu3" v-model="menu3" :close-on-content-click="false"
                                        :return-value.sync="time" max-width="290px" min-width="290px">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.start_time" label="Start Time"
                                                prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"
                                                id="Start_Time" required></v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('start_time')"
                                                v-html="form.errors.get('start_time')" />
                                        </template>
                                        <v-time-picker v-if="menu3" v-model="form.start_time" full-width
                                            @click:minute="$refs.menu3.save(time)" ampm-in-title scrollable :min="minTime1" :max="maxTime1"></v-time-picker>
                                    </v-menu>
                                </v-col>


                                <v-col cols="12" md="6">
                                    <!-- end_time -->
                                    <v-menu ref="menu4" v-model="menu4" :close-on-content-click="false"
                                        :return-value.sync="time" max-width="290px" min-width="290px">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.end_time" label="End Time"
                                                prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"
                                                required></v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('end_time')"
                                                v-html="form.errors.get('end_time')" />
                                        </template>
                                        <v-time-picker v-if="menu4" v-model="form.end_time" full-width
                                            @click:minute="$refs.menu4.save(time)" ampm-in-title scrollable :min="minTime2" :max="maxTime2"></v-time-picker>
                                    </v-menu>
                                </v-col>

                            </v-row>

                            <v-row>
                                <!-- purpose -->
                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('purpose')" v-html="form.errors.get('purpose')" />
                                    <v-textarea label="Booking Purpose" rows="2" outlined v-model="form.purpose"
                                        placeholder="Enter booking purpose in details" :rules="remRules" counter="500" required></v-textarea>
                                </v-col>

                                <!-- submit -->
                                <v-btn type="submit" block blockdepressed :loading="loadingdataStoreShow"
                                    color="primary">
                                    <v-icon left dark>mdi-plus-circle-outline</v-icon> Submit
                                </v-btn>

                            </v-row>

                        </form>
                    </v-form>


                </v-card-text>
            </v-card>
        </v-dialog>



        <!-- Car and driver Details for Booking -->
        <v-dialog persistent v-model="carStatusShow" scrollable max-width="1000px">
            <v-card>
                <!-- Dialog Title -->
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Car Booking
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="carStatusShow = false" color="red lighten-1 white--text" small class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>

                <v-card-text>
                    <!-- All Free Cars -->
                    <div class="teal--text pa-4 text-center font-weight-black text-overline"> Current Available Cars </div>


                    <div v-if="freeCars.length > 0">
                        <v-card v-for="singleData in freeCars" :key="singleData.id" class="mb-5">
                            <v-card-text>
                                <v-row class="align-items-center">
                                    <v-col cols="12" lg="6" md="6" class="border-right-success position-relative">
                                        <v-col lg="11">
                                            <v-img v-if="singleData.image" :src="imagePathSm + singleData.image" max-width="400"  class="rounded-lg"></v-img>
                                        </v-col>

                                        <div class="driver_image_position">
                                            <img v-if="singleData.driver" :src="imagePathSmDriver + singleData.driver.image" alt="" class="size_avatar">
                                        </div>
                                    </v-col>

                                    
                                    <v-col cols="12" lg="6" md="6" class="detail_space_in_mobile">
                                        <div class="d-flex justify-content-around">
                                        
                                            <div v-if="singleData.driver">
                                                <div>Driver Name: {{ singleData.driver.name }}</div>
                                                <div>Driver Number: {{ singleData.driver.contact }} </div>
                                            </div>

                                            <div class="line"></div>

                                            <div>
                                                <div>Car Name: {{ singleData.name }} </div>
                                                <div>Car Number: {{ singleData.number }} </div>
                                                <div>Capacity: {{ singleData.capacity }}</div>
                                            </div>

                                        </div>
                                        <!-- Driver Leave -->
                                        <div v-for="leave in singleData.car_leave" :key="leave.id" class="text-center">
                                            <v-badge :content="leaveVal(leave)" inline></v-badge>
                                        </div>

                                        <v-btn @click="bookingModal(singleData)" color="teal white--text" class="mt-8" block>
                                            <v-icon left>mdi-plus-circle-outline</v-icon>
                                            Book
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </div>


                    <!-- All Partial Free cars -->
                    <div v-if="bookings.length > 0">
                        <div class="orange--text pa-4 text-center font-weight-black text-overline"> Partially Available Cars </div>


                        <v-card v-for="singleData in bookings" :key="singleData.id">
                            <v-card-text>
                                <v-row class="align-items-center">
                                    <v-col cols="12" lg="6" md="6" class="border-right-success position-relative">
                                        <v-col lg="11">
                                            <v-img v-if="singleData.car.image" :src="imagePathSm + singleData.car.image" max-width="400" class="rounded-lg"></v-img>
                                        </v-col>

                                        <div class="driver_image_position">
                                            <img v-if="singleData.driver" :src="imagePathSmDriver + singleData.driver.image" alt="" class="size_avatar">
                                        </div>
                                    </v-col>

                                    
                                    <v-col cols="12" lg="6" md="6" class="detail_space_in_mobile">
                                        <div class="d-flex justify-content-around">
                                        
                                            <div v-if="singleData.driver">
                                                <div>Driver Name: {{ singleData.driver.name }}</div>
                                                <div>Driver Number: {{ singleData.driver.contact }} </div>
                                            </div>

                                            <div class="line"></div>

                                            <div>
                                                <div>Car Name: {{ singleData.car.name }} </div>
                                                <div>Car Number: {{ singleData.car.number }} </div>
                                                <div>Capacity: {{ singleData.car.capacity }}</div>
                                            </div>

                                        </div>

                                        <div class="mt-3 text-center">
                                            <v-badge :content="`Booked: ` + singleBookedTimeShow(singleData.start, singleData.end) " inline color="orange"></v-badge>
                                        </div>
                                        

                                        <v-btn @click="bookingModal(singleData.car)" color="orange white--text" class="mt-8" block>
                                            <v-icon left>mdi-plus-circle-outline</v-icon>
                                            Book
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>

                    </div>



                    <!-- All temporary Cars -->
                    <div v-if="temporaryCars.length > 0">
                        <div class="indigo--text pa-4 text-center font-weight-black text-overline"> All Temporary Cars </div>


                        <v-card v-for="singleData in temporaryCars" :key="singleData.id" class="mb-5">
                            <v-card-text>
                                <v-row class="align-items-center">
                                    <v-col cols="12" lg="6" md="6" class="border-right-success position-relative">
                                        <v-col lg="11">
                                            <v-img v-if="singleData.image" :src="imagePathSm + singleData.image" max-width="400" class="rounded-lg"></v-img>
                                        </v-col>

                                        <div class="driver_image_position">
                                            <img v-if="singleData.driver" :src="imagePathSmDriver + singleData.driver.image" alt="" class="size_avatar">
                                        </div>
                                    </v-col>

                                    
                                    <v-col cols="12" lg="6" md="6" class="detail_space_in_mobile">
                                        <div class="d-flex justify-content-around">
                                        
                                            <div v-if="singleData.driver">
                                                <div>Driver Name: {{ singleData.driver.name }}</div>
                                                <div>Driver Number: {{ singleData.driver.contact }} </div>
                                            </div>

                                            <div class="line"></div>

                                            <div>
                                                <div>Car Name: {{ singleData.name }} </div>
                                                <div>Car Number: {{ singleData.number }} </div>
                                                <div>Capacity: {{ singleData.capacity }}</div>
                                            </div>

                                        </div>

                                        <!-- Driver Leave -->
                                        <div v-for="leave in singleData.car_leave" :key="leave.id" class="text-center">
                                            <v-badge :content="leaveVal(leave)" inline></v-badge>
                                        </div>


                                        <v-btn @click="bookingModal(singleData),temporaryCarTime()" color="indigo white--text" class="mt-8" block>
                                            <v-icon left>mdi-plus-circle-outline</v-icon>
                                            Book
                                        </v-btn>
                                        
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </div>

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
            FullCalendar ,// make the <FullCalendar> tag available
        },

        data: function () {
            return {
                // time and date picker
                menu: false,
                menu2: false,
                menu3: false,
                menu4: false,
                time: '',
                minTime1:'',
                maxTime1:'',
                minTime2:'',
                maxTime2:'',

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
                    editable: false,
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
                    destination: '',
                    purpose: '',
                    start_date: '',
                    start_time: '00:01:00',
                    end_date: '',
                    end_time: '23:59:00',
                    remarks: '',
                    car_id: '',
                    start: '',
                    end: '',
                    car_name: ''
                }),

                //current page url
                currentUrl: '/carpool/booking',

                imagePath: '/images/carpool/car/',
                imagePathSm: '/images/carpool/car/small/',

                imagePathDriver: '/images/carpool/driver/',
                imagePathSmDriver: '/images/carpool/driver/small/',

                carStatusShow: false,
                eventDataStoreModal: false,
                eventDetailsModal: false,
                // Overlay
                overlayCalanderShow: true,
                overlaycarStatusShow: false,
                loadingdataStoreShow: false,

                freeCars: {},
                bookings: {},
                leaveCars: {},
                temporaryCars: {},

                currentSelectedCar: '',



                // not-comment component modal
                
                notCommentModal: true,

                allDestinations:[],
                remRules:[
                    v => (v || '' ).length <= 500 || 'Purpose must be 500 characters or less',
                    v => (v || '' ).length >= 5 || '5 characters minimum or more',
                ],


            }
        },

        methods: {
            // Leave title
            leaveVal(val){
                //console.log(val)
                let levType = ''
                if(val.type == 'lev'){
                    levType = 'Personal Leave'
                }else if(val.type == 'req'){
                    levType = 'Police Requisition'
                }
                else if(val.type == 'mant'){
                    levType = 'Car Maintenances'
                }
                return levType +': ' + this.$moment(val.start).format('MMM Do YYYY, h:mm a') + ' -- ' + this.$moment(val.end).format('MMM Do YYYY, h:mm a');
            },

           
            // Fetch Data from DB
            async getDataAsync() {
                try {
                    const response = await axios.get(this.currentUrl + '/data');
                    // Data assign to calendar
                    this.calendarOptions.events = response.data
                    //console.log(response.data);
                } catch (error) {
                    console.error(error);
                }
            },

            // getDastination
            getDastination(){
                axios.get( '/carpool/booked/destinations').then(response=>{
                    // console.log(response.data)
                    for ( let i = 0; i < response.data.length; i++ ) {
                        this.allDestinations.push(response.data[i]);
                        this.allDestinations[i] = { value: response.data[i].name, text: response.data[i].name  };
                    }
                }).catch(error=>{
                    console.log(error)
                })
            },

            // Mouse hover data
            onEventRender: function (args) {
                //console.log(args.event.extendedProps.bookby.name, args.event.start )
                let titleStr = args.event.title
                let contentStr = this.$moment(args.event.start).format("MMM Do, h:mm:ss a") + " - " + this.$moment(
                    args.event.start).format("MMM Do, h:mm:ss a");

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

                console.log('clickInfo', this.clickCurrentEvetData.extendedProps, this.clickCurrentEvetData.extendedProps.car )

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
                // loading    
                this.$Progress.start();

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

                    const response = await axios.post(this.currentUrl + '/car', {
                        selectData
                    });

                    // console.log(response.data.cars);

                    this.freeCars = response.data.cars
                    //console.log(response.data.cars);
                    this.bookings = response.data.bookings
                    //this.leaveCars = response.data.leave
                    this.temporaryCars = response.data.temporary,

                    //console.log(response.data.leave);

                    // Modal Show
                    this.carStatusShow = true;

                    // Loading
                    this.$Progress.finish();

                    //console.log('selectInfo', selectInfo, selectInfo.startStr, selectInfo.endStr, newEndDate, actualEndDate)

                } catch (error) {
                    // loading
                    this.$Progress.finish();
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!! Somthing Going Wrong',
                        customClass: 'text-danger'
                    });
                    console.error(error);
                }


            },


            // Show Booking Modal
            bookingModal(car) {
                // temporary car time make empty
                this.temporaryCarTimeEmpty();
                // show Modal
                this.eventDataStoreModal = true
                this.form.car_id = car.id
                this.form.car_name = car.name
                this.currentSelectedCar = car
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
                    this.loadingdataStoreShow = true
                    try {

                        const response = await this.form.post(this.currentUrl + '/store');
                        //console.log(response.data)
                        // Overlay
                        this.loadingdataStoreShow = false
                        if (response.data.status == 'success') {

                            // Refresh Calendar
                            this.getDataAsync();
                            // Hide Booking Modal
                            this.eventDataStoreModal = false
                            // Hide car Status Modal
                            this.carStatusShow = false

                            this.resetForm()

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


            // temporay car time min-max
            temporaryCarTime(){
                this.minTime1 = '9:00'
                this.maxTime1 = '17:00'

                this.minTime2 = '9:00'
                this.maxTime2 = '17:00'
            },

            // temporay car time min-max empty
            temporaryCarTimeEmpty(){
                this.minTime1 = ''
                this.maxTime1 = ''

                this.minTime2 = ''
                this.maxTime2 = ''
            },


            resetForm(){
                this.form.reset()
                this.$refs.form.resetValidation()
            }




        },




        created() {
            this.$Progress.start();
            // Data fetch from DB
            this.getDataAsync();
            this.getDastination();
            
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
    
    .line{
        background-color: #ddd;
        width: 2px;
    }

    .size_avatar{
        height: 150px;
        width: 150px;
        border-radius: 50%;
        padding: 0.2rem;
        background-color: white;
    }

    .driver_image_position{
        position: absolute;
        right: 0%;
        top: 22%;
    }


    @media all and (max-width: 900px) and (min-width: 500px) {
        .size_avatar{
            height: 100px;
            width: 100px;
        }

        .driver_image_position{
            top: 29%;
            right: -4%;
        }
    }


    @media all and (max-width: 450px) and (min-width: 350px) {

        .size_avatar{
            height: 115px;
            width: 115px;
        }

        .driver_image_position{
            top: 61%;
            left: 31%
        }

        .detail_space_in_mobile{
            margin-top: 2rem;
        }
    }

</style>
