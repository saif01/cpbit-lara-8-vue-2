<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">All Registered Users List</h3>
                    </div>

                </div>
            </div>

            <div class="card-body table-responsive">
                <div v-if="allData.data">
                    <v-row>
                        <v-col cols="2">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" small>
                            </v-select>
                        </v-col>


                        <v-col cols="2">
                            <!-- zone_office -->
                            <v-select v-model="zone_office" label="Zones:" :items="allZoneOffices" item-text="name"
                                item-value="offices" small>
                            </v-select>
                        </v-col>

                        <v-col cols="3">
                            <!-- Departments -->
                            <v-select v-model="department" label="Departments:" :items="allDepartments"
                                item-text="department" item-value="department" small>
                            </v-select>
                        </v-col>


                        <v-col cols="2">
                            <!-- search_field -->
                            <v-select v-model="search_field" label="Search By:" :items="searchByFields" item-text="name"
                                item-value="value" small>
                            </v-select>
                        </v-col>

                        <v-col cols="3">
                            <v-text-field prepend-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                                placeholder="Search Input..."></v-text-field>
                        </v-col>


                    </v-row>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('verify')">Verify</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'verify'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'verify'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('login')">Login</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'login'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'login'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('name')">Name</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('department')">Department</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'department'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'department'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('business_unit')">Business Unit</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'business_unit'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'business_unit'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('office_id')">Office ID</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'office_id'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'office_id'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('updated_at')">Completed</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'updated_at'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'updated_at'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('created_at')">Applied</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'created_at'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'created_at'">&darr;</span>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">

                                <td class="text-center">
                                    <!-- <button v-if="singleData.verify != 1" @click="editDataModelDirect(singleData)" class="btn btn-warning btn-sm"> 
                                        <i class="fa fa-edit blue"></i>Create
                                    </button>   -->


                                    <v-btn v-if="singleData.verify != 1" @click="editDataModelDirect(singleData)"
                                        elevation="10" small class="float-right" color="primary" outlined>
                                        <v-icon small>mdi-card-plus</v-icon> Create
                                    </v-btn>

                                    <span v-else class="text-success">Created</span>

                                </td>
                                <td>
                                    <span v-if="singleData.verify == 1" class="text-success">Verified</span> <span
                                        v-else class="text-danger">Not Verified</span>
                                    <span class="text-muted small float-right"
                                        v-if="singleData.verified">--{{ singleData.verified.name }}</span>
                                </td>
                                <td>{{ singleData.login  }}
                                    <img v-if="singleData.image" :src="imagePathSm + singleData.image" alt="image"
                                        class="img-fluid" height="50" width="80">
                                </td>
                                <td>{{ singleData.name }} </td>
                                <td>{{ singleData.department }} </td>
                                <td>{{ singleData.business_unit }} </td>
                                <td>{{ singleData.office_id }} </td>
                                <td>{{ singleData.updated_at | moment("MMM Do YYYY, h:mm a") }} </td>
                                <td>{{ singleData.created_at | moment("MMM Do YYYY, h:mm a") }} </td>

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

            </div>
        </div>



        <!-- Data Model -->
        <v-dialog v-model="dataModalDialogUserReg" fullscreen scrollable>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Create New
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialogUserReg = false" color="red lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <form @submit.prevent="createData()">

                        <v-row>
                            <v-col cols="12" md="4">
                                 
                                <v-text-field type="text" label="User AD ID" :rules="[v => !!v || 'AD ID is required!']" v-model="form.login" required>
                                </v-text-field>
                                <div class="text-danger" v-if="form.errors.has('login')" v-html="form.errors.get('login')" />
                               
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Name"
                                    :rules="[v => !!v || 'User Name is required!']" v-model="form.name" required>
                                </v-text-field>
                                <div class="text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                            </v-col>


                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Department"
                                    :rules="[v => !!v || 'Department is required!']" v-model="form.department" required>
                                </v-text-field>
                                <div class="text-danger" v-if="form.errors.has('department')" v-html="form.errors.get('department')" />
                            </v-col>


                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Office ID"
                                    :rules="[v => !!v || 'Office ID is required!']" v-model="form.office_id" required>
                                </v-text-field>
                                <div class="text-danger" v-if="form.errors.has('office_id')" v-html="form.errors.get('office_id')" />
                            </v-col>


                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Office Contact" v-model="form.office_contact">
                                </v-text-field>
                                <div class="text-danger" v-if="form.errors.has('office_contact')"
                                    v-html="form.errors.get('office_contact')" />
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Personal Contact" v-model="form.personal_contact">
                                </v-text-field>
                                <div class="text-danger" v-if="form.errors.has('personal_contact')"
                                    v-html="form.errors.get('personal_contact')" />
                            </v-col>


                            <v-col cols="12" md="4">
                                <v-text-field type="email" label="User Office Email"
                                    :rules="[v => /.+@.+/.test(v) || 'E-mail must be valid',]"
                                    v-model="form.office_email"></v-text-field>
                                <div class="text-danger" v-if="form.errors.has('office_email')" v-html="form.errors.get('office_email')" />
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field type="email" label="User Personal Email"
                                    :rules="[v => /.+@.+/.test(v) || 'E-mail must be valid',]"
                                    v-model="form.personal_email"></v-text-field>
                                <div class="text-danger" v-if="form.errors.has('personal_email')"
                                    v-html="form.errors.get('personal_email')" />
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Office Location"
                                    :rules="[v => !!v || 'Office Location is required!']" v-model="form.office"
                                    required></v-text-field>
                                <div class="text-danger" v-if="form.errors.has('office')" v-html="form.errors.get('office')" />
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Business Unit"
                                    :rules="[v => !!v || 'Business Unit is required!']" v-model="form.business_unit"
                                    required></v-text-field>
                                <div class="text-danger" v-if="form.errors.has('business_unit')"
                                    v-html="form.errors.get('business_unit')" />
                            </v-col>


                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Manager Name" v-model="manager_name" readonly>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field label="User Manager Email" v-model="manager_email" readonly>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User BU Head Name" v-model="bu_name" readonly>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field label="User BU Head Email" v-model="bu_email" required></v-text-field>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="Purpose of Access" v-model="remarks" readonly>
                                </v-text-field>
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-file-input :rules="imageRules" accept="image/png, image/jpeg, image/bmp"
                                    placeholder="Pick an image" prepend-icon="mdi-camera" label="Choose Image"
                                    @change="uploadImageByName($event, 'image')"></v-file-input>
                                <div color="red" v-if="form.errors.has('image')" v-html="form.errors.get('image')" />
                            </v-col>

                            <v-col cols="12" md="2">
                                <v-img :src="showImageByName('image')" class="rounded rounded-circle" height="100px"
                                    width="100px" alt="Image" />
                            </v-col>

                            <v-col cols="12" md="3">
                                <v-radio-group label="Account Status" v-model="form.status" row required>
                                    <v-radio label="Active" color="success" :value="1"></v-radio>
                                    <v-radio label="Blocked" color="red" :value="0"></v-radio>
                                </v-radio-group>
                            </v-col>

                            <v-col cols="12" md="3">
                                <label>User Type</label>
                                <div class="d-flex">
                                    <v-checkbox v-model="form.user" color="success" label="User" :value="1"
                                        class="mr-3">
                                    </v-checkbox>
                                    <v-checkbox v-model="form.admin" color="indigo" label="Admin" :value="1">
                                    </v-checkbox>
                                </div>

                            </v-col>

                        </v-row>

                        <!-- Start Manager Selection -->
                        <hr>
                        <v-row>
                            <div class="m-auto">
                                <v-radio-group row v-model="radioBtnSeelected" @change="managerSelectBy()">
                                    <v-radio label="Manager Select By ID" color="success" value="managerById"></v-radio>
                                    <v-radio label="Or Manul Input Email Address" color="indigo" value="managerByEmail">
                                    </v-radio>
                                </v-radio-group>
                            </div>

                            <div class="col-md-12 text-center mb-1" :class="{ hide: !managerByIdShow }">
                                <span v-if="selectedManagerName.length >0">
                                    <span v-for="item in selectedManagerName" :key="item">
                                        <span class="px-1 mx-1 info rounded text-white">{{ item }}</span>
                                    </span>
                                </span>
                                <span v-else class="text-danger">Not Selected</span>
                            </div>

                            <div class="col-md-12 text-center" :class="{ hide: !managerByIdShow }">
                                <v-btn @click="managerSelectComponent()" color="info">
                                    <v-icon left>mdi-select-search</v-icon> Select Manager
                                </v-btn>
                            </div>
                            <div class="col-md-12" id="managerByEmailShow" :class="{ hide: !managerByEmailShow }">
                                <v-text-field type="text" label="User Manager Emails" v-model="form.manager_emails">
                                </v-text-field>
                                <div class="text-danger" v-if="form.errors.has('manager_emails')"
                                    v-html="form.errors.get('manager_emails')" />
                            </div>


                        </v-row>
                        <hr>
                        <!-- End Manager Selection -->
                        <v-row>
                            <v-col class="pa-0" cols="3" v-for="(role, index) in allRoles" :key="index">
                                <v-checkbox v-model="currentRoles" :label="role.name" color="indigo" :value="role.id" hide-details></v-checkbox>
                            </v-col>
                        </v-row>
                        <hr>

                        <!-- Submit Btn -->
                        <v-btn block blockdepressed :loading="dataModalLoading" color="primary mt-3" type="submit">
                            <v-icon left dark>mdi-shape-polygon-plus </v-icon> Create
                        </v-btn>


                    </form>


                </v-card-text>
            </v-card>

        </v-dialog>





        <!-- manager-select-component -->
        <manager-select-component v-if="managerSelectComponentShow" :key="managerModalKey"
            :children-request="letParentResponse"></manager-select-component>


    </div>

</template>


<script>
    // vform
    import Form from 'vform';

    import allJsMethods from './indexMethods'

    import ManagerSelectComponent from '../users/manager_select.vue'
    import userMethods from './../users/js/methods'
    import userTblData from './../users/js/data'
    import userFormFields from './../users/js/userFormField'


    export default {

        components: {
            'manager-select-component': ManagerSelectComponent,
        },


        data() {

            return {

                //current page url
                currentUrl: '/super_admin/register',


                radioBtnSeelected: 'managerById',
                managerByIdShow: true,
                managerByEmailShow: false,
                // Manager Select 
                managerSelectDilog: false,

                // Manager Component
                managerSelectComponentShow: false,
                managerModalKey: '',
                selectedManager: [],
                selectedManagerName: [],


                allRoles: {},
                currentRoles: [],
               
                singleUserModalShow: false,
                singleUserModalData: {},

                manager_name: '',
                manager_email: '',
                bu_name: '',
                bu_email: '',
                remarks: '',

                // Show Reg dilog modal
                dataModalDialogUserReg: false,

                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid',
                ],
                imageRules: [
                    //v => !!v || 'Image is required',
                    v => !v || v.size < 2000000 || 'Image size should be less than 2 MB!',
                ],

                // userData
                ...userTblData,

                // userFormFields
                ...userFormFields,

            }


        },

        methods: {

            // All JS Methods
            ...allJsMethods,

            //userMethods
            ...userMethods,


            // Get all Role
            getRoles() {
                axios.get('/super_admin/user/roles_data').then(response => {
                    //console.log(response.data)
                    this.allRoles = response.data
                }).catch(error => {
                    console.log(error)
                })
            },


            //managerSelectComponentShow
            managerSelectComponent() {
                this.managerModalKey++
                this.managerSelectComponentShow = true
            },

            // letParentResponse()
            letParentResponse(request) {

                this.selectedManagerName = request.manager_name
                // this.selectedManager = request.manager_id
                this.form.manager_id = request.manager_id
                // this.setManager()
                console.log('parent Response', request.manager_name, request.manager_id, request, this.form.manager_id)
            },


        },


        mounted() {

            // All ZoneOffices
            this.getZoneOffices();
            //getDepartments
            this.getDepartments();
            // getRoles
            this.getRoles();
        },






        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
           
            this.$Progress.finish();
        },



    }

</script>


<style scoped>
    .hide {
        /* visibility: hidden !important; */
        display: none !important;
    }

    .image-thum-size {
        height: 50px;
        width: 100px;
    }

</style>
