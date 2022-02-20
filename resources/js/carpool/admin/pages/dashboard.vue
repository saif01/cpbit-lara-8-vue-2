<template>
    <div>
        <h1>Carpool Admin</h1>

        Current ID: {{ auth.login }}

        <div>
            <FullCalendar :options='calendarOptions'></FullCalendar>
        </div>



        <!-- Single Event data Show Modal -->
        <v-dialog v-model="eventDetailsModal" max-width="600px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Booked Details
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="eventDetailsModal = false" color="red lighten-1" small text
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
                                        <span v-if="clickCurrentEvetData.extendedProps"><img
                                                :src="'/images/users/small/' +clickCurrentEvetData.extendedProps.bookby.image"
                                                alt="image" class="img-fluid img-thumbnail" height="80" width="60">
                                        </span>
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
                    </table>
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

import { BPopover } from 'bootstrap-vue'

export default {
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data(){
        return{
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

            //current page url
            currentUrl: '/carpool/booking',


            eventDetailsModal: false,
        }
    },

    methods:{

        // Fetch Data from DB
        async getDataAsync() {
            try {
                const response = await axios.get(this.currentUrl + '/data');
                // Data assign to calendar
                this.calendarOptions.events = response.data
                // console.log(response.data);
            } catch (error) {
                console.error(error);
            }
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

        },

        // Single Event Data Show
        handleEventClick(clickInfo) {
            // Modal Show
            this.eventDetailsModal = true;
            // Asign Current event data
            this.clickCurrentEvetData = clickInfo.event;


        },
    },

    created(){
        this.getDataAsync();
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