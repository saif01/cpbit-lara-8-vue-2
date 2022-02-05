<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Vendor Blocked List</h3>
                    </div>
                    <div class="col-6">
                        <v-btn @click="showModel" elevation="10" small class="float-right" color="primary" outlined>
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
                                    <a href="#" @click.prevent="change_sort('start')">Start</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'start'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'start'">&darr;</span>

                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('end')">End</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'end'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'end'">&darr;</span>

                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('remarks')">Remarks</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'remarks'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'remarks'">&darr;</span>

                                </th>
                                <th>Vendor Number</th>
                                <th>Suppier Name</th>
                                <th>Address</th>
                                <th>Contact Name</th>
                                <th>Email</th>
                                <th>Telephone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td class="text-center">
                                    <!-- v-if="isAdmin()" -->
                                    <div >
                                        <v-btn v-if="singleData.status" @click="vendorBlockStoreStatus(singleData)" small
                                            color="success" elevation="10" class="mb-1">
                                            <v-icon left>mdi-check-decagram</v-icon> Activated
                                        </v-btn>
                                        <v-btn v-else @click="vendorBlockStoreStatus(singleData)" small color="warning"
                                            elevation="10" class="mb-1">
                                            <v-icon left>mdi-close-octagon</v-icon> Inactive
                                        </v-btn>
                                    </div>
                                </td>
                                <td>{{ singleData.start }}</td>
                                <td>{{ singleData.end }}</td>
                                <td>{{ singleData.remarks }}</td>
                                <td>{{ singleData.vendor.vendor_number }}</td>
                                <td>{{ singleData.vendor.suppier_name }}</td>
                                <td>{{ singleData.vendor.address }}</td>
                                <td>{{ singleData.vendor.contact_name }}</td>
                                <td>{{ singleData.vendor.email }}</td>
                                <td>{{ singleData.vendor.telephone }}</td>
                            </tr>
                        </tbody>
                    </table>
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
                        <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </div>
        </div>


        <!-- Dilog -->
        <v-dialog v-model="vendorBlockDialog" max-width="700px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Vendor Block
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="vendorBlockDialog = false" color="red lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>

                <v-card-text>

                    <v-form v-model="valid">
                        <form @submit.prevent="vendorBlockStore()">

                            <!-- {{ currentRoles }} -->
                            <v-autocomplete dense solo :items="allVendors" v-model="form.vendor_id" label="Select a Vendor" :rules="[v => !!v || 'Vendor Details is required!']" required></v-autocomplete>

                            <v-row>
                                <v-col cols="12" md="6">

                                    <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :return-value.sync="date"
                                    min-width="auto"
                                    >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                        v-model="form.start"
                                        label="Effective Start Date"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        required
                                        :rules="[v => !!v || 'Start Date is required!']"
                                        ></v-text-field>
                                    </template>
                                   <v-date-picker v-model="form.start" scrollable >
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="menu = false" > Cancel </v-btn>
                                        <v-btn text color="primary" @click="$refs.menu2.save(date2)"> OK </v-btn>
                                    </v-date-picker>
                                    <div class="small text-danger" v-if="form.errors.has('start')"
                                            v-html="form.errors.get('start')" />
                                    </v-menu>
                                </v-col>
                                
                                <v-col cols="12" md="6">
                                    <v-menu
                                    ref="menu2"
                                    v-model="menu2"
                                    :close-on-content-click="false"
                                    :return-value.sync="date2"
                                    min-width="auto"
                                    >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                        v-model="form.end"
                                        label="Effective End Date"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        required
                                        :rules="[v => !!v || 'End Date is required!']"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="form.end" scrollable >
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="menu = false" > Cancel </v-btn>
                                        <v-btn text color="primary" @click="$refs.menu2.save(date2)"> OK </v-btn>
                                    </v-date-picker>
                                    <div class="small text-danger" v-if="form.errors.has('end')"
                                            v-html="form.errors.get('end')" />
                                    </v-menu>
                                    
                                </v-col>

                        
                            </v-row>

                            <v-row>
                                <v-col cols="12">
                                    <v-textarea outlined rows="3" label="Enter Remarks" v-model="form.remarks" :rules="[v => !!v || 'Remarks is required!']" required>
                                        <div class="small text-danger" v-if="form.errors.has('remarks')"
                                            v-html="form.errors.get('remarks')" />

                                    </v-textarea>
                                </v-col>
                            </v-row>

                            <v-btn block blockdepressed :loading="modalBtnLoading" color="primary mt-3"
                                        type="submit">
                                <v-icon left dark>mdi-shape-polygon-plus </v-icon> Blocked
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
                // dialog
                vendorBlockDialog:false,

                // timepicker
                menu: false,
                menu2: false,
                date: '',
                date2: '',

                //current page url
                currentUrl: '/ivca/admin/vendor/black_list',

                allVendors:[],

                selected:null,
                datePickerHeader:true,

                // Form
                form: new Form({
                    id: '',
                    vendor_id: '',
                    start: '',
                    end: '',
                    remarks: '', 
                }),

            }


        },

        methods: {

            vendorList(){
                axios.get( this.currentUrl+'/vendor_list').then(response=>{
                    //console.log(response.data)
                    for (let i = 0; i < response.data.length; i++) {
                        this.allVendors.push(response.data[i]);
                        this.allVendors[i] = {value: response.data[i].id, text: response.data[i].vendor_number + ' || ' + response.data[i].suppier_name + ' || ' + response.data[i].contact_name};
                    
                    }
                    //this.allVendors = response.data
                }).catch(error=>{
                    console.log(error)
                })
            },

            // Show Model
            showModel() {
                //this.$refs['data-modal-vendor-block'].show();
                this.vendorBlockDialog=true
            },

            // Store Data
            vendorBlockStore(){
                this.form.post(this.currentUrl +'/vendor_list_blacklist').then(response=>{

                    console.log(response);

                    this.form.reset();
                    this.form.errors.clear();
                    // Hide model
                    //this.$refs['data-modal-vendor-block'].hide();
                    this.vendorBlockDialog=false
                    // Refresh Tbl Data with current page
                    this.getResults(this.currentPageNumber);
                    this.$Progress.finish();

                    Toast.fire({
                        icon: response.data.icon,
                        title: response.data.msg
                    });

                }).catch(error=>{
                    console.log(error)
                })
            },

            

            // Change Status
            vendorBlockStoreStatus(data){
                console.log('status', data.status)
                if(data.status == 1){
                    var text = "Are you want to inactive ?"
                    var btnText = "Inactive"
                
                }else{
                    var text = "Are you want to active ?"
                    var btnText = "Active"
                }

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
                        axios.post(this.currentUrl + '/vendor_list_status',{ id: data.id, vendorId: data.vendor_id  }).then((response) => {
                            // console.log(response);
                            Swal.fire(
                                response.data.status,
                                response.data.msg,
                                response.data.icon
                            );
                            // Refresh Tbl Data with current page
                            this.getResults(this.currentPageNumber);
                            this.$Progress.finish();

                        }).catch((data) => {
                            Swal.fire("Failed!", data.message, "warning");
                        });
                    }
                })
            },





        },


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.vendorList();
            this.$Progress.finish();
        },



    }

</script>
