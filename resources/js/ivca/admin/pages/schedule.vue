<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Schedule Table</h3>
                    </div>
                    <div class="col-6">
                        <v-btn @click="addDataModel" elevation="10" small class="float-right" color="primary" outlined>
                            <v-icon small>mdi-card-plus</v-icon> Add
                        </v-btn>
                    </div>

                </div>
            </div>

            <div class="card-body">
                <div v-if="allData.data">
                    <div class="row mb-2">
                        <div class="col form-inline small">
                            <select v-model="paginate" class="form-control form-control-sm">
                                <option value="10">10</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="col">
                            <input v-model="search" class="form-control form-control-sm" type="text"
                                placeholder="Search by any data at the table...">
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>
                                    <a href="#" @click.prevent="change_sort('id')">ID</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'id'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'id'">&darr;</span>

                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('date')">Audit Date</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'date'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'date'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('remarks')">Remarks</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'remarks'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'remarks'">&darr;</span>

                                </th>
                                <th> Vendor Number</th>
                                <th>Suppier Name</th>
                                <th>Address</th>
                                <th>Telephone</th>
                                <th>Auditor Name</th>
                                <th>Auditor Office</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>{{ singleData.id }}</td>
                                <td>{{ singleData.date }}</td>
                                <td>{{ singleData.remarks }}</td>
                                <td>{{ singleData.vendor.vendor_number }}</td>
                                <td>{{ singleData.vendor.suppier_name }}</td>
                                <td>{{ singleData.vendor.address }}</td>
                                <td>{{ singleData.vendor.telephone }}</td>
                                <td>{{ singleData.user.name }}</td>
                                <td>{{ singleData.user.office }}</td>

                                <td class="text-center">
                                    <div v-if="isAdmin()">
                                        <button v-if="singleData.status" @click="statusChange(singleData)"
                                            class="btn btn-success btn-sm m-1">
                                            <i class="far fa-check-circle"></i> Active
                                        </button>
                                        <button v-else @click="statusChange(singleData)"
                                            class="btn btn-warning btn-sm m-1">
                                            <i class="far fa-times-circle"></i> Inactive
                                        </button>
                                    </div>
                                    <button @click="editDataModel(singleData)" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit blue"></i> Edit
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span>Total Records: {{ totalValue }}</span>
                    </div>
                    <pagination :data="allData" @pagination-change-page="getResults" class="justify-content-end">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-else>
                    <div v-if="dataLoading" class="p-5 my-5">
                        <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </div>
        </div>


        <b-modal ref="data-modal" :title="dataModelTitle" size="lg" hide-footer>
            <form @submit.prevent="editmode ? updateData() : createData()">

                <div>
                    <!-- {{ currentRoles }} -->
                    <b-form-group label="Vendor List:">
                        <b-form-select v-model="form.vendor_id" size="sm">
                            <b-form-select-option value="">Please select a vendor</b-form-select-option>
                            <b-form-select-option v-for="vendor in allVendors" :key="vendor.id" :value="vendor.id">
                                {{ vendor.vendor_number }} || {{ vendor.suppier_name }} || {{ vendor.contact_name }}
                            </b-form-select-option>
                        </b-form-select>
                        <div class="small text-danger" v-if="form.errors.has('vendor_id')"
                            v-html="form.errors.get('vendor_id')" />
                    </b-form-group>

                </div>

                <b-row>
                    <b-col>
                        <b-form-group label="User List:">
                            <b-form-select v-model="form.user_id" size="sm">
                                <b-form-select-option value="">Please select auditor</b-form-select-option>
                                <b-form-select-option v-for="users in allUsers" :key="users.id" :value="users.id">
                                    {{ users.name }} || {{ users.office }} || {{ users.business_unit }}
                                </b-form-select-option>
                            </b-form-select>
                            <div class="small text-danger" v-if="form.errors.has('user_id')"
                                v-html="form.errors.get('user_id')" />
                        </b-form-group>
                    </b-col>

                    <b-col>
                        <b-form-group label="Audit Start Date:">
                            <b-form-datepicker v-model="form.date" today-button reset-button close-button locale="en"
                                placeholder="YYYY-MM-DD" autocomplete="off" size="sm" :hide-header="datePickerHeader"
                                :date-format-options="{ year: 'numeric', month: 'long', day: 'numeric' }"
                                :class="{ 'is-invalid': form.errors.has('date') }">
                            </b-form-datepicker>
                            <div class="small text-danger" v-if="form.errors.has('date')"
                                v-html="form.errors.get('date')" />
                        </b-form-group>
                    </b-col>

                </b-row>

                <b-row>
                    <b-col>
                        <b-form-group label="Remarks:">
                            <b-form-textarea v-model="form.remarks" placeholder="Enter audit schedule remarks" rows="2"
                                :class="{ 'is-invalid': form.errors.has('remarks') }">
                            </b-form-textarea>
                            <div class="small text-danger" v-if="form.errors.has('remarks')"
                                v-html="form.errors.get('remarks')" />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-form-group v-if="form.progress">
                    <b-progress :value="form.progress.percentage" variant="success" striped animated>
                    </b-progress>
                </b-form-group>

                <b-form-group v-if="!form.progress">
                    <b-button v-show="editmode" type="submit" class="btn-block" variant="primary">Update</b-button>
                    <b-button v-show="!editmode" type="submit" class="btn-block" variant="primary">Create</b-button>
                </b-form-group>

            </form>


        </b-modal>


    </div>

</template>


<script>
    // vform
    import Form from 'vform';


    export default {

        data() {

            return {

                // current page url
                currentUrl: '/admin/ivca/schedule',

                allVendors: {},
                allUsers: {},

                selected: null,
                datePickerHeader: true,

                // Form
                form: new Form({
                    id: '',
                    vendor_id: '',
                    user_id: '',
                    date: '',
                    remarks: '',
                }),

            }


        },

        methods: {
            // vendorList
            vendorList() {
                axios.get(this.currentUrl + '/vendor_list').then(response => {
                    //console.log(response.data)
                    this.allVendors = response.data
                }).catch(error => {
                    console.log(error)
                })
            },

            // vendorList
            userList() {
                axios.get(this.currentUrl + '/user_list').then(response => {
                    //console.log(response.data)
                    this.allUsers = response.data
                }).catch(error => {
                    console.log(error)
                })
            },

            // Show Model
            // showModel() {
            //     this.$refs['data_modal_schedule'].show();
            // },

            // // Store Data
            // auditScheduleStore(){
            //     this.form.post(this.currentUrl +'/vendor_list_blacklist').then(response=>{

            //         console.log(response);

            //         this.form.reset();
            //         this.form.errors.clear();
            //         // Hide model
            //         this.$refs['data_modal_schedule'].hide();
            //         // Refresh Tbl Data with current page
            //         this.getResults(this.currentPageNumber);
            //         this.$Progress.finish();

            //         Toast.fire({
            //             icon: response.data.icon,
            //             title: response.data.msg
            //         });

            //     }).catch(error=>{
            //         console.log(error)
            //     })
            // },



        },


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.vendorList();
            this.userList();
            this.$Progress.finish();
        },



    }

</script>
