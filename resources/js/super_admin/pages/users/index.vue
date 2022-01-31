<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">All User Table</h3>
                    </div>
                    <div class="col-6">
                        <v-btn @click="addDataModel" elevation="10" small class="float-right" color="primary"
                            outlined>
                            <v-icon small>mdi-card-plus</v-icon> Add
                        </v-btn>
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
                                <th>
                                    <a href="#" @click.prevent="change_sort('login')">login</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'login'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'login'">&darr;</span>
                                </th>
                                <th>Details</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>{{ singleData.login  }}<br>
                                    <img v-if="singleData.image" :src="imagePathSm + singleData.image" alt="image"
                                        class="img-fluid" height="50" width="80">
                                </td>
                                <td>
                                    <b>Name: </b> {{ singleData.name }} <br>
                                    <b>Department: </b> {{ singleData.department }} <br>
                                    <b>Office ID: </b> {{ singleData.office_id }} <br>
                                    <b>Office: </b> {{ singleData.office }} <br>
                                    <b>Business Unit: </b> {{ singleData.business_unit }} <br>
                                    <!-- Manager ID Selected -->
                                    <span v-if="singleData.manager_id">
                                        <b>Manager: </b>
                                        <!-- {{ singleData.manager_id }}  -->
                                        <span>
                                            <span v-for="item in manegerData(singleData.manager_id)" :key="item.id">
                                                <v-btn @click="showSingleUserDetails(item)" small outlined class="mx-1">
                                                    {{ item.name }}</v-btn>
                                            </span>
                                        </span>
                                    </span>
                                    <!-- Manager Email have -->
                                    <span v-else-if="singleData.manager_emails">
                                        <b>Manager Emails: </b> {{ singleData.manager_emails }}
                                    </span>
                                    <!-- Manager Not selected -->
                                    <span v-else>
                                        <b>Manager:</b> <span class="text-danger">Not Selected</span>
                                    </span>
                                </td>

                                <td>
                                    <span v-if="singleData.roles.length">
                                        <span v-for="(role, index) in singleData.roles" :key="index">
                                            <span class="pa-1 m-1 rounded-pill small">{{ role.name }}, </span>
                                        </span>
                                    </span>
                                    <span v-else>
                                        <span class="text-danger">You have no roles</span>
                                    </span>
                                </td>

                                <td>
                                    <!-- Admin Access -->
                                    <div class="m-1">
                                        <v-btn v-if="singleData.admin == 1" @click="statusChangeAdmin(singleData)"
                                            outlined elevation="10" color="green darken-2">
                                            <v-icon left>mdi-check-decagram</v-icon> Admin
                                        </v-btn>
                                        <v-btn v-else @click="statusChangeAdmin(singleData)" outlined elevation="10"
                                            color="red accent-2">
                                            <v-icon left>mdi-close-octagon</v-icon> Admin
                                        </v-btn>
                                    </div>
                                    <!-- User Access -->
                                    <div class="m-1">
                                        <v-btn v-if="singleData.user == 1" @click="statusChangeUser(singleData)"
                                            outlined elevation="10" color="green darken-2">
                                            <v-icon left>mdi-check-decagram</v-icon> User
                                        </v-btn>
                                        <v-btn v-else @click="statusChangeUser(singleData)" outlined elevation="10"
                                            color="red accent-2">
                                            <v-icon left>mdi-close-octagon</v-icon> User
                                        </v-btn>
                                    </div>


                                    <hr>
                                    <div>
                                        <span v-if="singleData.status == 1" class="text-success">Active</span> <span
                                            v-else class="text-danger">Blocked</span>
                                        <span class="text-muted small float-right"
                                            v-if="singleData.status_by">--{{ userNameByID(singleData.status_by) }}</span>
                                    </div>

                                    <div>
                                        <span v-if="singleData.verify == 1" class="text-success">Verified</span> <span
                                            v-else class="text-danger">Not Verified</span>
                                        <span class="text-muted small float-right"
                                            v-if="singleData.verify_by">--{{ userNameByID(singleData.verify_by) }}</span>
                                    </div>

                                </td>

                                <td class="text-center">
                                    <v-btn v-if="singleData.status" @click="statusChange(singleData)" small
                                        color="primary" elevation="10" class="mb-1">
                                        <v-icon left>mdi-check-decagram</v-icon> Active
                                    </v-btn>
                                    <v-btn v-else @click="statusChange(singleData)" small color="warning" elevation="10"
                                        class="mb-1">
                                        <v-icon left>mdi-close-octagon</v-icon> Inactive
                                    </v-btn>

                                    <v-btn @click="editDataModelDirect(singleData)" small color="info" elevation="10"
                                        class="mb-1">
                                        <v-icon left>mdi-circle-edit-outline</v-icon> Edit
                                    </v-btn>



                                    <v-btn @click="editRoleModel(singleData)" small elevation="10" class="mb-1">
                                        <v-icon>mdi-alpha-r-circle-outline</v-icon> Role
                                    </v-btn>

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

            </div>
        </div>









        <!--Role Assign Dilog  Modal -->
        <v-dialog v-model="roleModelShow" persistent scrollable>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Assign Global Roles
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="roleModelShow = false" color="red lighten-1" small text class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>

                <v-card-text>
                    <v-row>
                        <!-- {{ currentRoles }} -->
                        <v-col class="pa-0" cols="3" v-for="(role, index) in allRoles" :key="index">
                            <v-checkbox v-model="currentRoles" :label="role.name" color="indigo" :value="role.id"
                                hide-details></v-checkbox>
                        </v-col>

                        <v-btn @click="updateUserRole()" block blockdepressed :loading="roleUpdating"
                            color="primary mt-10">
                            <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                        </v-btn>

                    </v-row>
                </v-card-text>
            </v-card>


        </v-dialog>


        <!-- Single User Details  -->
        <v-dialog v-model="singleUserModalShow" fullscreen>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Manager Details
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="singleUserModalShow = false" color="red lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    {{ singleUserModalData }}
                </v-card-text>
            </v-card>

        </v-dialog>




        <!-- user-create-compoment -->
        <!-- Single User Details  -->
        <v-dialog v-model="dataModalDialog" fullscreen scrollable>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            {{ dataModelTitle }}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialog = false" color="red lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <form @submit.prevent="editmode ? updateDataDirect() : createDataDirect()">

                        <v-row>
                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User AD ID"
                                        :rules="[v => !!v || 'AD ID is required!']" v-model="form.login" required>
                                    </v-text-field>
                                    <div v-if="form.errors.has('login')" v-html="form.errors.get('login')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Name"
                                        :rules="[v => !!v || 'User Name is required!']" v-model="form.name" required>
                                    </v-text-field>
                                    <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                                </v-col>


                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Department"
                                        :rules="[v => !!v || 'Department is required!']" v-model="form.department"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('department')" v-html="form.errors.get('department')" />
                                </v-col>


                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Office ID"
                                        :rules="[v => !!v || 'Office ID is required!']" v-model="form.office_id"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('office_id')" v-html="form.errors.get('office_id')" />
                                </v-col>


                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Office Contact" v-model="form.office_contact">
                                    </v-text-field>
                                    <div v-if="form.errors.has('office_contact')"
                                        v-html="form.errors.get('office_contact')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Personal Contact"
                                        v-model="form.personal_contact"></v-text-field>
                                    <div v-if="form.errors.has('personal_contact')"
                                        v-html="form.errors.get('personal_contact')" />
                                </v-col>


                                <v-col cols="12" md="4">
                                    <v-text-field type="email" label="User Office Email"
                                        :rules="[v => /.+@.+/.test(v) || 'E-mail must be valid',]"
                                        v-model="form.office_email"></v-text-field>
                                    <div v-if="form.errors.has('office_email')"
                                        v-html="form.errors.get('office_email')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="email" label="User Personal Email"
                                        :rules="[v => /.+@.+/.test(v) || 'E-mail must be valid',]"
                                        v-model="form.personal_email"></v-text-field>
                                    <div v-if="form.errors.has('personal_email')"
                                        v-html="form.errors.get('personal_email')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Office Location"
                                        :rules="[v => !!v || 'Office Location is required!']" v-model="form.office"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('office')" v-html="form.errors.get('office')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Business Unit"
                                        :rules="[v => !!v || 'Business Unit is required!']" v-model="form.business_unit"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('business_unit')"
                                        v-html="form.errors.get('business_unit')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Manager Name"
                                        :rules="[v => !!v || 'Manager Name is required!']" v-model="form.manager_name"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('manager_name')"
                                        v-html="form.errors.get('manager_name')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="email" label="User Manager Email" :rules="emailRules"
                                        v-model="form.manager_email" required></v-text-field>
                                    <div v-if="form.errors.has('manager_email')"
                                        v-html="form.errors.get('manager_email')" />
                                </v-col>


                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User BU Head Name"
                                        :rules="[v => !!v || 'BU Head Name is required!']" v-model="form.bu_name"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('bu_name')" v-html="form.errors.get('bu_name')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="email" label="User BU Head Email" :rules="emailRules"
                                        v-model="form.bu_email" required></v-text-field>
                                    <div v-if="form.errors.has('bu_email')" v-html="form.errors.get('bu_email')" />
                                </v-col>


                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="Purpose of Access"
                                        :rules="[v => !!v || 'Purpose of Access is required!']" v-model="form.remarks"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('remarks')" v-html="form.errors.get('remarks')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-file-input :rules="imageRules" accept="image/png, image/jpeg, image/bmp"  placeholder="Pick an image" prepend-icon="mdi-camera" label="Choose Image"
                                        @change="uploadImageByName($event, 'image')" required></v-file-input>
                                    <div v-if="form.errors.has('image')" v-html="form.errors.get('image')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-img :src="showImageByName('image')" class="rounded rounded-circle" height="100px" width="100px"
                                        alt="Image" />

                                </v-col>

                            </v-row>

                        <!-- Start Manager Selection -->
                        <hr>
                       
                        
                        <hr>
                        <!-- End Manager Selection -->

                     





                        <v-btn block blockdepressed :loading="dataModalLoading" color="primary mt-3"
                                    type="submit">
                            <span v-if="editmode">
                                <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                            </span>
                            <span v-else>
                                <v-icon left dark>mdi-shape-polygon-plus </v-icon> Create
                            </span>
                        </v-btn>


                    </form>


                </v-card-text>
            </v-card>

        </v-dialog>









    </div>

</template>


<script>
    // vform
    import Form from 'vform';

    import allJsMethods from './indexMethods'

    //import userCreateCompoment from './user_create.vue'


    export default {
        // components:{
        //   'user-create-compoment' : userCreateCompoment
        // },

        data() {

            return {

                //current page url
                currentUrl: '/super_admin/user',

                selectedManager: [],
                selectedManagerName: [],

                radioBtnSeelected: 'managerById',
                options: [{
                        text: 'Manager Select By ID',
                        value: 'managerById'
                    },
                    {
                        text: 'Or Manul Input Email Address',
                        value: 'managerByEmail'
                    },
                ],
                managerByIdShow: true,
                managerByEmailShow: false,

                userModal2ndShowHide: false,


                activeOptions: [{
                        text: 'Active',
                        value: '1'
                    },
                    {
                        text: 'Blocked',
                        value: '0'
                    },
                ],


                searchByFields: [{
                        value: 'login',
                        name: 'Login ID'
                    },
                    {
                        value: 'name',
                        name: 'User Name'
                    },
                    {
                        value: 'department',
                        name: 'Department'
                    },
                    {
                        value: 'office_id',
                        name: 'Office ID'
                    },
                    {
                        value: 'office_contact',
                        name: 'Office Contact'
                    },
                    {
                        value: 'personal_contact',
                        name: 'Personal Contact'
                    },
                    {
                        value: 'office_email',
                        name: 'Office Email'
                    },
                    {
                        value: 'personal_email',
                        name: 'Personal Email'
                    },
                    {
                        value: 'office',
                        name: 'Office'
                    },
                    {
                        value: 'business_unit',
                        name: 'Business Unit'
                    },
                    {
                        value: 'nid',
                        name: 'NID'
                    },
                    {
                        value: 'status',
                        name: 'Status Active'
                    },
                    {
                        value: 'admin',
                        name: 'Admin Access'
                    },
                    {
                        value: 'user',
                        name: 'User Access'
                    },
                ],



                allRoles: {},
                currentRoles: [],
                currentRoleId: null,
                roleUpdating: false,
                roleModelShow: false,



                // Form
                form: new Form({
                    id: '',
                    login: '',
                    user: '1',
                    admin: '',
                    name: '',
                    image: '',
                    department: '',
                    office_id: '',
                    office_contact: '',
                    personal_contact: '',
                    office_email: '',
                    personal_email: '',
                    office: '',
                    business_unit: '',
                    nid: '',
                    manager_id: [],
                    manager_emails: '',
                    status: '1'
                }),


                imageMaxSize: '5111775',
                imagePath: '/images/users/',
                imagePathSm: '/images/users/small/',


                singleUserModalShow: false,
                singleUserModalData: {},

                allZoneOffices: [],
                zone_office: '',
                allDepartments: [],
                department: '',

                

                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid',
                ],
                imageRules: [
                    v => !!v || 'Image is required',
                    v => !v || v.size < 2000000 || 'Image size should be less than 2 MB!',
                ],



            }


        },

        methods: {

            // All JS Methods
            ...allJsMethods,

            //addDataModelUser
            addDataModelUser() {

            },

            // // Add Data Model
            // addDataModel(){
            //     this.editmode = false;
            //     // this.dataModalDialog=true
            // },

            // // Edit Data Modal
            // editDataModel(singleData){
            //     this.editmode = true;
            //     this.dataModelTitle = 'Update Data'
            //     this.form.reset();
            //     this.form.fill(singleData);
            //     // this.dataModalDialog=true
            // },


        },



        watch: {

            //Excuted When make change value 
            zone_office: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },

            //Excuted When make change value 
            department: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            }

        },


        mounted() {
            // Get Roles 
            this.getRoles();
            // All ZoneOffices
            this.getZoneOffices();
            //getDepartments
            this.getDepartments();
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
    .hide {
        /* visibility: hidden !important; */
        display: none !important;
    }

    .image-thum-size {
        height: 50px;
        width: 100px;
    }

</style>
