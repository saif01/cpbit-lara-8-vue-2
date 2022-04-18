<template>
    <div>

        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        My Hardware Complain List
                    </v-col>
                    <v-col cols="2">

                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text class="table-responsive">
                <div v-if="allData.data">
                    <v-row>
                        <v-col cols="2">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" small>
                            </v-select>
                        </v-col>

                        <v-col cols="2">
                            <v-select :items="reportType" label="Select Type" v-model="sort_by_day"></v-select>
                        </v-col>

                        <v-col cols="2">
                            <v-menu v-model="menu" min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="sort_by_startDate" label="Start Date"
                                        prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
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

                        <v-col>
                            <v-text-field prepend-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                                placeholder="Search Input..."></v-text-field>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>
                                    <a href="#" @click.prevent="change_sort('id')">Number</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'id'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'id'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('process')">Process</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'process'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'process'">&darr;</span>
                                </th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('created_at')">Complain At</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'created_at'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'created_at'">&darr;</span>
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>
                                    <div class="pa-1 info rounded-pill h4 text-white text-center">
                                        {{ singleData.id }}
                                    </div>
                                </td>
                                <td>
                                    <div v-if="(singleData.process == 'Damaged')"
                                        class="pa-1 error rounded-pill h6 text-white text-center">
                                        {{ singleData.process }}
                                    </div>

                                    <div v-else class="pa-1 info rounded-pill h6 text-white text-center">
                                        {{ singleData.process }}
                                    </div>
                                    <!-- damagedReplace -->
                                    <div v-if="singleData.dam_apply && singleData.dam_apply.rec_name"
                                        class="text-center">
                                        <v-btn @click="damagedReplaceMethod(singleData.dam_apply)" color="success"
                                            x-small>
                                            <v-icon left>mdi-eye-arrow-left </v-icon> Damaged Replaced
                                        </v-btn>
                                    </div>

                                </td>
                                <td class="text-center">
                                    <span v-if="singleData.category">{{ singleData.category.name }}</span>
                                </td>
                                <td class="text-center">
                                    <span v-if="singleData.subcategory">{{ singleData.subcategory.name }}</span>
                                </td>
                                <td class="text-center">
                                    <span
                                        v-if="singleData.created_at">{{ singleData.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                </td>
                                <td class="text-center">
                                   
                                    <span v-if="singleData.process == 'Not Process' && !singleData.remarks.length">
                                        <v-btn v-if="singleData.process == 'Not Process' && singleData.status == 1"
                                            @click="complainCancel(singleData.id)" color="error" depressed
                                            elevation="20">
                                            <v-icon left>mdi-close-octagon-outline</v-icon> Cancel
                                        </v-btn>
                                        <span v-else class="error--text">Canceled</span>
                                    </span>
                                   
                                   
                                    <v-btn v-if="singleData.remarks.length" @click="remarksDetailsShow(singleData)" color="success" depressed
                                         elevation="20">
                                        <v-icon left>mdi-eye-arrow-left </v-icon> View
                                    </v-btn>

                                    <!-- Damaged Replace -->
                                    <span v-if="singleData.dam_apply && singleData.dam_apply.apply_by">
                                        <div class="m-1 info rounded-pill h6 text-white text-center">
                                            Replace Applied <br>
                                            <span class="small text-warning"
                                                v-if="singleData.dam_apply.apply_at">{{ singleData.dam_apply.apply_at | moment("MMMM Do YYYY") }}</span>
                                        </div>
                                    </span>
                                    <span v-else>
                                        <v-btn
                                            v-if="singleData.dam_apply && (singleData.dam_apply.applicable_type == 'Applicable')"
                                            @click="damagedReplace(singleData.dam_apply.id)" success depressed small
                                            elevation="20">
                                            <v-icon small>mdi-file-replace </v-icon> Replace Apply
                                        </v-btn>
                                    </span>

                                    <!-- Damaged Quation -->
                                    <div v-if="singleData.dam_apply && singleData.dam_apply.apply_quotation"
                                        class="text-center">
                                        <v-btn @click="damagedQuationMethod(singleData.dam_apply)" color="success"
                                            small>
                                            <v-icon left>mdi-eye-arrow-left </v-icon> Damaged Quotation
                                        </v-btn>
                                    </div>

                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span>Total Records: {{ totalValue }}</span>
                    </div>
                    <pagination :data="allData" :limit="3" @pagination-change-page="getResults"
                        class="justify-content-end">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-else>
                    <div v-if="dataLoading" class="p-5 my-5">
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin
                            </v-icon>
                        </p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </v-card-text>
        </v-card>


        <!-- Remarks infomation -->
        <v-dialog v-if="allRemarks" v-model="remarksDialog">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Remarks Details
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="remarksDialog = false" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>

                    <!-- All Remarks -->
                    <div v-if="allRemarks.remarks" class="mb-2">
                        <div v-for="(item, index) in  allRemarks.remarks" :key="index">
                            <!--Start remarks -->
                            <table class="table mb-1 bg-secondary text-white rounded border-bottom border-danger">
                                <!-- remarks -->
                                <tr>
                                    <th>Process: ({{ index + 1 }})</th>
                                    <td>
                                        <span v-if="(item.process == 'Damaged')"
                                            class="text-danger bg-white rounded">Damaged</span>
                                        <span v-else-if="(item.process == 'Closed')"
                                            class="text-danger bg-white rounded">Closed</span>
                                        <span v-else>{{ item.process }}</span>
                                    </td>
                                    <th>Document:</th>
                                    <td>
                                        <span v-if="item.document">
                                            <a v-if="item.document" :href="docPath+item.document"
                                                class="btn btn-info btn-sm text-white" download>
                                                <v-icon color="white" small>mdi-paperclip</v-icon> Document
                                            </a>
                                        </span>
                                        <span v-else class="text-warning">No Document's Send</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>By:</th>
                                    <td>
                                        {{ item.makby.name }}

                                    </td>
                                    <th>Action At:</th>
                                    <td><span
                                            v-if="item.created_at">{{ item.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Remarks:</th>
                                    <td colspan="3" v-html="item.details"></td>
                                </tr>


                            </table>
                            <!--End remarks -->




                            <!--Start ho_remarks -->
                            <div v-if="(item.process == 'HO Service')">
                                <div v-for="(item, index) in  allRemarks.ho_remarks" :key="index">
                                    <table class="table mb-0 bg-info text-white rounded">

                                        <tr>

                                            <th>HO Process: ({{ index+1 }})</th>
                                            <td>
                                                <span v-if="(item.process == 'Damaged')"
                                                    class="text-danger bg-white rounded">Damaged</span>
                                                <span v-else-if="(item.process == 'Closed')"
                                                    class="text-danger bg-white rounded">Closed</span>
                                                <span v-else>{{ item.process }}</span>
                                            </td>
                                            <th>Document:</th>
                                            <td>
                                                <span v-if="item.document">
                                                    <a v-if="item.document" :href="docPath+item.document"
                                                        class="btn btn-info btn-sm text-white" download>
                                                        <v-icon color="white" small>mdi-paperclip</v-icon>
                                                        Document
                                                    </a>
                                                </span>
                                                <span v-else class="text-warning">No Document's Send</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>By:</th>
                                            <td>
                                                <button class="btn btn-secondary btn-sm" v-if="item.makby"
                                                    @click="currentUserView(item.makby)">
                                                    <v-avatar size="20">
                                                        <img v-if="item.makby.image"
                                                            :src="'/images/users/small/' + item.makby.image"
                                                            alt="image">
                                                    </v-avatar> {{ item.makby.name }}
                                                </button>
                                            </td>
                                            <th>Action At:</th>
                                            <td><span
                                                    v-if="item.created_at">{{ item.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Remarks:</th>
                                            <td colspan="3" v-html="item.details"></td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                            <!--End ho_remarks -->
                        </div>
                    </div>


                    <!-- Start Damaged Replaced received -->
                    <table class="table mb-1 bg-secondary text-white rounded border-bottom border-danger"
                        v-if="allRemarks.damage && allRemarks.damage.rep_pro_id ">
                        <!-- {{ allRemarks.damage }} -->

                        <tr>
                            <td colspan="8" class="text-center h3 text-success">Damaged Replaced</td>
                        </tr>
                        <tr>
                            <th>By:</th>
                            <td colspan="3"> {{ allRemarks.damage.makby.name }} </td>
                            <th>Action At:</th>
                            <td colspan="3"><span
                                    v-if="allRemarks.damage.created_at">{{ allRemarks.damage.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                            </td>
                        </tr>
                        <tr class="bg-info">
                            <th>Receiver Name:</th>
                            <td> {{ allRemarks.damage.rec_name }} </td>
                            <th>Receiver Contact:</th>
                            <td> {{ allRemarks.damage.rec_contact }} </td>
                            <th>Receiver Position:</th>
                            <td> {{ allRemarks.damage.rec_position }} </td>
                            <th>Received At:</th>
                            <td><span v-if="allRemarks.damage.updated_at"
                                    class="text-warning">{{ allRemarks.damage.updated_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                            </td>
                        </tr>
                    </table>
                    <!-- Start Damaged Replaced received -->



                    <!-- Start Delivered -->
                    <table class="table mb-1 bg-success text-white rounded border-bottom border-danger"
                        v-if="allRemarks.delivery">
                        <!-- {{ allRemarks.delivery }} -->

                        <tr>
                            <td colspan="8" class="text-center h3">----- Delivered -----</td>
                        </tr>
                        <tr>
                            <th>By:</th>
                            <td colspan="3"> {{ allRemarks.delivery.makby.name }} </td>
                            <th>Action At:</th>
                            <td colspan="3"><span
                                    v-if="allRemarks.delivery.created_at">{{ allRemarks.delivery.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                            </td>
                        </tr>


                        <tr>
                            <th>Receiver Name:</th>
                            <td> {{ allRemarks.delivery.rec_name }} </td>
                            <th>Receiver Contact:</th>
                            <td> {{ allRemarks.delivery.rec_contact }} </td>
                            <th>Receiver Position:</th>
                            <td> {{ allRemarks.delivery.rec_position }} </td>
                            <th>Received At:</th>
                            <td><span v-if="allRemarks.delivery.updated_at"
                                    class="text-warning">{{ allRemarks.delivery.updated_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Remarks:</th>
                            <td colspan="7" v-html="allRemarks.delivery.details"> </td>
                        </tr>
                    </table>
                    <!-- Start Delivered -->



                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog max-width="500px" v-model="damQuotationModal">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Damage Replace
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="damQuotationModal = false" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <div v-if="allRemarks.dam_apply && allRemarks.dam_apply.rep_pro_id">

                        <div>
                            <b>Receiver Name</b> {{allRemarks.dam_apply.rec_name}}
                        </div>
                        <div>
                            <b>Receiver Contact</b> {{allRemarks.dam_apply.rec_contact}}
                        </div>
                        <div>
                            <b>Receiver Position</b> {{allRemarks.dam_apply.rec_position}}
                        </div>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>

        <!-- Damage Replace Receiver details -->
        <v-dialog max-width="700px" v-model="damagedReplaceDialog">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Replace Receiver Details
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="damagedReplaceDialog = false" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>

                    <table class="table">
                        <tr>
                            <th>Receiver Name</th>
                            <td> <span
                                    v-if="currentDamagedReplaceData.rec_name">{{currentDamagedReplaceData.rec_name}}</span>
                                <span v-else class="error--text">N/A</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Receiver Contact</th>
                            <td> <span
                                    v-if="currentDamagedReplaceData.rec_contact">{{currentDamagedReplaceData.rec_contact}}</span>
                                <span v-else class="error--text">N/A</span></td>
                        </tr>
                        <tr>
                            <th>Receiver Position</th>
                            <td> <span
                                    v-if="currentDamagedReplaceData.rec_position">{{currentDamagedReplaceData.rec_position}}</span>
                                <span v-else class="error--text">N/A</span></td>
                        </tr>
                        <tr>
                            <th>Delivery By</th>
                            <td> <span
                                    v-if="currentDamagedReplaceData.makby">{{currentDamagedReplaceData.makby.name  }}</span>
                                <span v-else class="error--text">N/A</span></td>
                        </tr>
                        <tr>
                            <th>Receiver Date</th>
                            <td> <span
                                    v-if="currentDamagedReplaceData.created_at">{{currentDamagedReplaceData.created_at | moment("dddd, MMMM Do YYYY, h:mm:ss a")  }}</span>
                                <span v-else class="error--text">N/A</span></td>
                        </tr>

                    </table>

                </v-card-text>
            </v-card>
        </v-dialog>


        <!-- Damage Quation details -->
        <v-dialog v-model="damagedQuotationDialog">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Quotation Details
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="damagedQuotationDialog = false" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>

                    <table class="table">
                        <tr>
                            <th>Quotation</th>
                            <td> <span v-if="currentDamagedReplaceData.apply_quotation"
                                    v-html="currentDamagedReplaceData.apply_quotation"></span>
                                <span v-else class="error--text">N/A</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Document</th>
                            <td> <span v-if="currentDamagedReplaceData.document">
                                    <a v-if="currentDamagedReplaceData.document"
                                        :href="docPath+currentDamagedReplaceData.document"
                                        class="btn btn-info btn-sm text-white" download>
                                        <v-icon color="white" small>mdi-paperclip</v-icon> Document
                                    </a>
                                </span>
                                <span v-else class="error--text">N/A</span></td>
                        </tr>

                    </table>

                </v-card-text>
            </v-card>
        </v-dialog>


    </div>

</template>


<script>
    import axios from 'axios';
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
                currentUrl: '/cms/hard',


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

                remarksDialog: false,
                allRemarks: [],
                docPath: '/images/hardware/',

                // damQuotationModal
                damQuotationModal: false,

                damagedReplaceDialog: false,
                currentDamagedReplaceData: '',
                damagedQuotationDialog: false,

            }


        },

        methods: {

            // Get table data
            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl + '/history?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field +
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



            // remarksDetailsShow
            remarksDetailsShow(val) {
                this.allRemarks = []
                this.allRemarks = val
                this.remarksDialog = true
                console.log('remarksDetail', val.remarks, val.ho_remarks)
            },

            // damagedReplace
            damagedReplace(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Apply for a damaged replacement",
                    showCancelButton: true,
                    confirmButtonColor: 'green',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Apply'
                }).then((result) => {

                    // Send request to the server
                    if (result.value) {
                        //console.log(id);
                        this.$Progress.start();
                        axios(this.currentUrl + '/damage_apply?id=' + id).then((response) => {
                            //console.log(response);
                            Swal.fire({
                                icon: response.data.icon,
                                title: response.data.msg,
                            });
                            // Refresh Tbl Data with current page
                            this.getResults(this.currentPageNumber);
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


            // damagedReplaceMethod
            damagedReplaceMethod(val) {
                this.currentDamagedReplaceData = val
                this.damagedReplaceDialog = true
            },

            // damagedQuationMethod
            damagedQuationMethod(val) {
                this.currentDamagedReplaceData = val
                this.damagedQuotationDialog = true
            },

            // complainCancel
            complainCancel(val) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to cancel this complain !',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes!',
                }).then((result) => {

                    // Send request to the server
                    if (result.value) {
                        //console.log(id);
                        this.$Progress.start();
                        axios.post(this.currentUrl + '/complain_cancel', {
                            id: val
                        }).then((response) => {
                            //console.log(response);
                            Swal.fire(
                                'Changed!',
                                'Status has been Changed.',
                                'success'
                            );
                            // Refresh Tbl Data with current page
                            this.getResults(this.currentPageNumber);
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


        watch: {

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
