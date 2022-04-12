<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">All User List</h3>
                    </div>
                    <div class="col-6">
                        <v-btn @click="addDataModel" elevation="10" small class="float-right" color="primary" outlined>
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
                                <td class="text-center">
                                    {{ singleData.login  }}<br>
                                    <v-avatar size="100" @click="currentUserView(singleData)">
                                            <img v-if="singleData.image" :src="imagePathSm + singleData.image" alt="image">
                                    </v-avatar>
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
                                                <v-btn @click="currentUserView(item)" small outlined class="mx-1">
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

                                    <v-btn @click="editDataModel(singleData)" small color="info" elevation="10"
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
                    <form @submit.prevent="editmode ? updateData() : createData()">

                        <v-row>
                            <v-col cols="12" md="4">

                                <v-text-field type="text" label="User AD ID" :rules="[v => !!v || 'AD ID is required!']"
                                    v-model="form.login" required>
                                </v-text-field>
                                <div class="text-danger" v-if="form.errors.has('login')"
                                    v-html="form.errors.get('login')" />

                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Name"
                                    :rules="[v => !!v || 'User Name is required!']" v-model="form.name" required>
                                </v-text-field>
                                <div class="text-danger" v-if="form.errors.has('name')"
                                    v-html="form.errors.get('name')" />
                            </v-col>


                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Department"
                                    :rules="[v => !!v || 'Department is required!']" v-model="form.department">
                                </v-text-field>
                                <div class="text-danger" v-if="form.errors.has('department')"
                                    v-html="form.errors.get('department')" />
                            </v-col>


                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Office ID" v-model="form.office_id">
                                </v-text-field>
                                <div class="text-danger" v-if="form.errors.has('office_id')"
                                    v-html="form.errors.get('office_id')" />
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
                                <div class="text-danger" v-if="form.errors.has('office_email')"
                                    v-html="form.errors.get('office_email')" />
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field type="email" label="User Personal Email"
                                    :rules="[v => /.+@.+/.test(v) || 'E-mail must be valid',]"
                                    v-model="form.personal_email" required></v-text-field>
                                <div class="text-danger" v-if="form.errors.has('personal_email')"
                                    v-html="form.errors.get('personal_email')" />
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Office Location"
                                    :rules="[v => !!v || 'Office Location is required!']" v-model="form.office"
                                    required></v-text-field>
                                <div class="text-danger" v-if="form.errors.has('office')"
                                    v-html="form.errors.get('office')" />
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field type="text" label="User Business Unit"
                                    :rules="[v => !!v || 'Business Unit is required!']" v-model="form.business_unit"
                                    required></v-text-field>
                                <div class="text-danger" v-if="form.errors.has('business_unit')"
                                    v-html="form.errors.get('business_unit')" />
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
                                <v-checkbox v-model="currentRoles" :label="role.name" color="indigo" :value="role.id"
                                    hide-details></v-checkbox>
                            </v-col>
                        </v-row>
                        <hr>






                        <v-btn block blockdepressed :loading="dataModalLoading" color="primary mt-3" type="submit">
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





        <!-- manager-select -->
        <manager-select v-if="managerSelectComponentShow" :key="managerModalKey" :children-request="letParentResponse"
            :selected_id="form.manager_id"></manager-select>

        <!-- user-details -->
        <user-details v-if="CurrentUserData" :userData="CurrentUserData" :key="userDetailsDialogKey"></user-details>

    </div>

</template>


<script>
    // vform
    import Form from 'vform';

    import allJsMethods from './indexMethods'

    import ManagerSelec from './manager_select.vue'
    import userMethods from './js/methods'
    import userTblData from './js/data'
    import userFormFields from './js/userFormField'

    // User Details Show By Dialog
    import userDetails from './details/user_details.vue'
    import userDetailsData from './details/js/data'
    import userDetailsMethods from './details/js/methods'


    export default {
        components: {
            'manager-select': ManagerSelec,
            'user-details': userDetails,
        },

        data() {

            return {

                //current page url
                currentUrl: '/super_admin/user',



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
                currentRoleId: null,
                roleUpdating: false,
                roleModelShow: false,



                // userData
                ...userTblData,

                // userFormFields
                ...userFormFields,




                singleUserModalShow: false,
                singleUserModalData: {},




                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid',
                ],
                imageRules: [
                    v => !!v || 'Image is required',
                    v => !v || v.size < 2000000 || 'Image size should be less than 2 MB!',
                ],

                // Current User Show By Dilog
                ...userDetailsData,
               
                fullUserList:'',

            }


        },

        methods: {

            // All JS Methods
            ...allJsMethods,

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
                //console.log('parent Response', request.manager_name, request.manager_id, request, this.form.manager_id)
            },

            // CurrentUserData
            ...userDetailsMethods,
           


        },



      


        mounted() {
            setTimeout(()=>{
                // Get Roles 
                this.getRoles();
                // All ZoneOffices
                this.getZoneOffices();
                //getDepartments
                this.getDepartments();
            }, 1000)
        },

        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.getFullList();
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
