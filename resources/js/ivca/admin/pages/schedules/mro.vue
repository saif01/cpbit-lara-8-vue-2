<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">MRO Audit Schedule List</h3>
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
                                <th>Action</th>
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
                                <th>Vendor Number</th>
                                <th>Suppier Name</th>
                                <th>Address</th>
                                <th>Telephone</th>
                                <th>Auditor Name</th>
                                <th>Auditor Office</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td class="text-center">
                                    <!-- v-if="isAdmin()" -->
                                    <div >
                                         <v-btn v-if="singleData.status" @click="statusChange(singleData)" small
                                        color="success" elevation="10" class="mb-1">
                                        <v-icon left>mdi-check-decagram</v-icon> Approved
                                    </v-btn>
                                    <v-btn v-else @click="statusChange(singleData)" small color="warning"
                                        elevation="10" class="mb-1">
                                        <v-icon left>mdi-close-octagon</v-icon> Not Approved
                                    </v-btn>
                                    </div>
                                     <v-btn @click="editDataModel(singleData)" small color="info" elevation="10" class="mb-1">
                                        <v-icon left>mdi-circle-edit-outline</v-icon> Modify
                                    </v-btn>
                                    <!-- v-if="!isAdmin()" -->
                                    <div >
                                        <div v-if="singleData.status" small class="pa-1  text-no-wrap rounded-pill success"><v-icon small>mdi-clock-time-eight-outline</v-icon> Approved</div> 
                                        <div v-if="!singleData.status" small color="warning" class="pa-1  text-no-wrap warning rounded-pill"><v-icon small>mdi-clock-time-eight-outline</v-icon> Waiting</div>
                                    </div>
                                  
                                </td>

                                <td>{{ singleData.date }}</td>
                                <td>{{ singleData.remarks }}</td>
                                <td>{{ singleData.vendor.vendor_number }}</td>
                                <td>{{ singleData.vendor.suppier_name }}</td>
                                <td>{{ singleData.vendor.address }}</td>
                                <td>{{ singleData.vendor.telephone }}</td>
                                <td><span v-if="singleData.user">{{singleData.user.name }}</span></td>
                                <td><span v-if="singleData.user">{{ singleData.user.office }}</span></td>
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


        <v-dialog v-model="dataModalDilog">

            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            {{dataModelTitle}}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDilog = false" color="red lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>

                <v-card-text>
                    
                    <v-form v-model="valid">
                        <form @submit.prevent="editmode ? updateData() : createData()">


                            <v-autocomplete dense solo :items="allVendors" v-model="form.vendor_id" label="Select a Vendor" :rules="[v => !!v || 'Vendor Details is required!']" required></v-autocomplete>
                            <div class="small text-danger" v-if="form.errors.has('vendor_id')" v-html="form.errors.get('vendor_id')" />


                            <v-row>
                                <v-col>
                                    <v-autocomplete dense solo :items="allUsers" v-model="form.user_id" label="Select an Auditor" :rules="[v => !!v || 'Auditor Details is required!']" required></v-autocomplete>
                                    <div class="small text-danger" v-if="form.errors.has('user_id')" v-html="form.errors.get('user_id')" />
                                </v-col>
                                <!-- Date Picker -->
                                <v-col>
                                    <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :return-value.sync="date"
                                    offset-y
                                    min-width="auto"
                                    >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                        v-model="form.date"
                                        label="Audit Start Date"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        required
                                        :rules="[v => !!v || 'Audit Start Date is required!']"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="form.date" scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="menu = false">
                                        Cancel</v-btn>
                                        <v-btn text color="primary" @click="$refs.menu.save(date)" >
                                        OK </v-btn>
                                    </v-date-picker>
                                    <div class="small text-danger" v-if="form.errors.has('date')"
                                            v-html="form.errors.get('date')" />
                                    </v-menu>
                                </v-col>
                            </v-row>
                            

                            <v-row>
                                <v-col>
                                    <v-textarea outlined v-model="form.remarks" label="Enter audit schedule remarks" rows="2"
                                        :class="{ 'is-invalid': form.errors.has('remarks') }" :rules="[v => !!v || 'Remarks is required!']" required>
                                    </v-textarea >
                                    <div class="small text-danger" v-if="form.errors.has('remarks')"
                                        v-html="form.errors.get('remarks')" />
                                </v-col>
                            </v-row>

                           <v-btn block blockdepressed :loading="modalBtnLoading" color="primary mt-3"
                                        type="submit">
                                    <span v-if="editmode">
                                        <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                                    </span>
                                    <span v-else>
                                        <v-icon left dark>mdi-shape-polygon-plus </v-icon> Create
                                    </span>
                                </v-btn>


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

                // timepicker
                menu: false,
                date: '',

               

                // current page url
                currentUrl: '/ivca/admin/schedule/mro',

                allVendors: [],
                allUsers: [],

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
                    for (let i = 0; i < response.data.length; i++) {
                        this.allVendors.push(response.data[i]);
                        this.allVendors[i] = {value: response.data[i].id, text: response.data[i].vendor_number + ' || ' + response.data[i].suppier_name + ' || ' + response.data[i].contact_name};
                    
                    }
                    //this.allVendors = response.data
                }).catch(error => {
                    console.log(error)
                })
            },

            // vendorList
            userList() {
                axios.get(this.currentUrl + '/user_list').then(response => {
                    
                    console.log(response.data)
                    for (let i = 0; i < response.data.length; i++) {
                        this.allUsers.push(response.data[i]);
                        this.allUsers[i] = {value: response.data[i].id, text: response.data[i].name + ' || ' + response.data[i].office + ' || ' + response.data[i].business_unit};
                    
                    }

                    //this.allUsers = response.data
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
