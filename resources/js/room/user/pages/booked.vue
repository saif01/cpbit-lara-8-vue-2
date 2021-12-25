<template>
    <div>

        <div v-if="allData">

            <div v-if="allData.length > 0">
                <!-- card -->
                <div class="booking_card_details my-3">
                    <b-card v-for="item in allData" :key="item.id">
                        <b-row>
                            <div class="col-md-6">
                                <div style="height:230px;">
                                    <b-card-img v-if="item.room.image" :src="imagePath+item.room.image" alt="Image"
                                        class="img-fluid h-100 w-100"></b-card-img>
                                    <b-card-img v-else src="/all-assets/common/img/no-image.png"
                                        class="img-fluid h-100 w-100" alt="Image"></b-card-img>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <b-card-text class="mt-3">
                                    <div class="d-flex justify-content-between">
                                        <div class="h3">
                                            Booking Details
                                        </div>
                                        <div style="color: #001F61">
                                            Booking Duration: {{ item.duration }}
                                        </div>
                                    </div>
                                    <table>
                                        <tr>
                                            <th>Name</th>
                                            <td class="pl-4"><span v-if="item.room">{{ item.room.name }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Purpose</th>
                                            <td class="pl-4 py-2">{{ item.purpose }}</td>
                                        </tr>
                                        <tr>
                                            <th>Booked</th>
                                            <td class="pl-4">{{ item.start | moment("MMM Do YYYY, h:mm a") }} - To -
                                                {{ item.end | moment("MMM Do YYYY, h:mm a") }}</td>
                                        </tr>
                                    </table>


                                    <div class="float-right mt-5">
                                        <b-button v-if="cancelBtnShow(item.start)" @click="cancelBooking(item.id)"
                                            size="sm" variant="danger" class="rounded-pill px-4"><i
                                                class="far fa-trash-alt"></i> Cancel</b-button>
                                        <b-button @click="modifyBooking(item)" size="sm" variant="warning"
                                            class="rounded-pill px-4"><i class="far fa-edit"></i> Modify</b-button>
                                    </div>

                                </b-card-text>
                            </div>
                        </b-row>
                    </b-card>

                </div>
            </div>
            <div v-else>
                <div class="p-5 my-5">
                    <p class="text-center text-info h1">Sorry !! You have no current booking. </p>
                </div>
            </div>

        </div>
        <div v-else>
            <div v-if="dataLoading" class="p-5 my-5">
                <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
            </div>
        </div>





        <!-- Booking Data Modify Modal -->
        <b-modal v-model="eventDataStoreModal" title="Modify Booking" size="md" scrollable hide-footer ok-only>
            <b-overlay :show="overlaydataStoreShow" spinner-variant="success" rounded="sm">

                <div v-if="selectedForModify.room" class="text-center rounded mb-2">
                    Room: <b>{{ selectedForModify.room.name }}</b>, Booked:
                    <b>{{ selectedForModify.start | moment("MMM Do YYYY, h:mm a") }} - To -
                        {{ selectedForModify.end | moment("MMM Do YYYY, h:mm a") }}</b>
                </div>

                <div class="mb-2">
                    <b-button v-b-toggle.collapse-1 variant="primary" class="btn-block btn-sm"><span
                            v-if="selectedForModify.room">{{ selectedForModify.room.name }}</span> Related Bookings <i
                            class="far fa-eye"></i></b-button>
                    <b-collapse id="collapse-1" class="mt-2">
                        <b-card>
                            <div v-if="relatedBookings.length > 0">
                                <b-card-text v-for="item in relatedBookings" :key="item.id" class="bg-info">
                                    <table class="table table-sm text-center">
                                        <tr>
                                            <th>Purpose:</th>
                                            <td>{{ item.purpose }}</td>
                                        </tr>
                                        <tr>
                                            <th>Booked:</th>
                                            <td>{{ item.start | moment("MMM Do YYYY, h:mm a") }} - To -
                                                {{ item.end | moment("MMM Do YYYY, h:mm a") }}</td>
                                        </tr>
                                    </table>
                                </b-card-text>
                            </div>
                        </b-card>
                    </b-collapse>
                </div>

                <form @submit.prevent="storeCurrentEventData()">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <b-form-datepicker v-model="form.start_date" today-button reset-button close-button
                                    locale="en" placeholder="YYYY-MM-DD" autocomplete="off" size="sm"
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
                                    locale="en" placeholder="YYYY-MM-DD" autocomplete="off" size="sm"
                                    :hide-header="datePickerHeader"
                                    :date-format-options="{ year: 'numeric', month: 'long', day: 'numeric' }"
                                    :class="{ 'is-invalid': form.errors.has('end_date') }" required>
                                </b-form-datepicker>
                                <div class="small text-danger" v-if="form.errors.has('end_date')"
                                    v-html="form.errors.get('end_date')" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Start_Time">Start Time</label>
                                <b-form-timepicker id="Start_Time" v-model="form.start_time" now-button reset-button
                                    locale="en" size="sm" :class="{ 'is-invalid': form.errors.has('start_time') }"
                                    required>
                                </b-form-timepicker>
                                <div class="small text-danger" v-if="form.errors.has('start_time')"
                                    v-html="form.errors.get('start_time')" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="End_Time">End Time</label>
                                <b-form-timepicker id="End_Time" v-model="form.end_time" now-button reset-button
                                    locale="en" size="sm" :class="{ 'is-invalid': form.errors.has('end_time') }"
                                    required>
                                </b-form-timepicker>
                                <div class="small text-danger" v-if="form.errors.has('end_time')"
                                    v-html="form.errors.get('end_time')" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="purpose">Booking Purpose</label>
                                <b-form-textarea id="purpose" v-model="form.purpose" size="sm"
                                    placeholder="Enter booking purpose in details"
                                    :class="{ 'is-invalid': form.errors.has('purpose') }" required></b-form-textarea>
                                <div class="small text-danger" v-if="form.errors.has('purpose')"
                                    v-html="form.errors.get('purpose')" />
                            </div>
                        </div>
                    </div>

                    <b-form-group v-if="!form.progress">
                        <b-button type="submit" class="btn-block" variant="success"><i class="fas fa-plus-circle"></i>
                            Modify</b-button>
                    </b-form-group>

                </form>

            </b-overlay>
        </b-modal>


    </div>
</template>

<script>
    // vform
    import Form from 'vform';

    export default {
        data() {
            return {

                //current page url
                currentUrl: '/room/booked',

                imagePath: '/images/room/',
                imagePathSm: '/images/room/small/',

                eventDataStoreModal: false,
                datePickerHeader: true,
                // Overlay
                overlayModifyShow: false,
                overlaydataStoreShow: false,

                selectedForModify: '',


                allData: '',
                dataLoading: false,

                relatedBookings: '',

                // Form
                form: new Form({
                    id: '',
                    purpose: '',
                    start_date: '',
                    start_time: '00:01:00',
                    end_date: '',
                    end_time: '23:59:00',
                    room_id: '',
                    start: '',
                    end: '',
                    room_name: ''
                }),



            }
        },

        methods: {

            // Booked Data
            getBookedData() {
                // Loading
                this.dataLoading = true
                axios.get(this.currentUrl + '/data').then(response => {
                   // console.log(response.data)
                    this.allData = response.data
                    // Loading
                    this.dataLoading = false
                }).catch(error => {
                    console.log(error)
                })
            },


            // Modify Btn Clicked
            modifyBooking(item) {
                // Overlay
                this.overlayModifyShow = true
                // Current Data 
                this.selectedForModify = item

                axios.post(this.currentUrl + '/byroom', {
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
                    this.form.room_id = item.room_id
                    this.form.room_name = item.room.name
                    this.form.id = item.id

                    // Overlay
                    this.overlayModifyShow = false
                    // Modal
                    this.eventDataStoreModal = true

                }).catch(error => {
                    // Overlay
                    this.overlayModifyShow = false
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
                    // Overlay
                    this.overlaydataStoreShow = true
                    try {

                        const response = await this.form.post(this.currentUrl + '/store');
                        console.log(response.data)
                        // Overlay
                        this.overlaydataStoreShow = false
                        if (response.data.status == 'success') {

                            // Refresh Calendar
                            this.getBookedData();
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
                var btnText = "Cancel"

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

        },

        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getBookedData();
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

</style>
