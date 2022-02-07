<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">All User List</h3>
                    </div>
                    <div class="col-6">
                      
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
                            <v-select v-model="zone_office" 
                            label="Zones:"
                            :items="allZoneOffices"
                            item-text="name"
                            item-value="offices"
                            small>
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

                                </td>

                                <td>
                                    <span v-if="singleData.sms_roles.length">
                                        <span v-for="(role, index) in singleData.sms_roles" :key="index">
                                            <span class="p-1 m-1 rounded-pill small">{{ role.name }}, </span> 
                                        </span>
                                    </span>
                                    <span v-else>
                                        <span class="text-danger">You have no roles</span>
                                    </span>
                                </td>



                                <td class="text-center">

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
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>


            </div>
        </div>








        <!--Role Dilog  -->
        <v-dialog v-model="roleModelShow" persistent>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Assign Roles
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
                            <v-checkbox  v-model="currentRoles" :label="role.name" color="indigo" :value="role.id"
                                hide-details></v-checkbox>
                        </v-col>


                        <v-btn @click="updateUserRole()" block blockdepressed :loading="roleUpdating"
                            color="primary mt-3">
                            <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                        </v-btn>

                    </v-row>
                </v-card-text>
            </v-card>


        </v-dialog>


        <!-- user-details -->
        <user-details v-if="CurrentUserData" :userData="CurrentUserData" :key="userDetailsDialogKey"></user-details>

    </div>

</template>


<script>
    // vform
    import Form from 'vform';

    import userTblData from './../../../../super_admin/pages/users/js/data'
    import userTblMethods from './../../../../super_admin/pages/users/js/methods'

    // User Details Show By Dialog
    import userDetails from './../../../../super_admin/pages/users/details/user_details.vue'
    import userDetailsData from './../../../../super_admin/pages/users/details/js/data'
    import userDetailsMethods from './../../../../super_admin/pages/users/details/js/methods'


    export default {

        components: {
            'user-details': userDetails,
        },


        data() {

            return {

                //current page url
                currentUrl: '/sms/admin/user',
            
               
                managerByIdShow: true,
                managerByEmailShow: false,

                userModal2ndShowHide: false,



                allRoles: {},
                currentRoles: [],
                currentRoleId: null,
                roleUpdating: false,
                roleModelShow: false,


                // userTblData
                ...userTblData,

                // Current User Show By Dilog
                ...userDetailsData,

            }


        },

        methods: {

            // userTblMethods
            ...userTblMethods,


            // Get all Role
            getRoles() {
                axios.get(this.currentUrl + '/roles_data').then(response => {
                    //console.log(response.data)
                    this.allRoles = response.data
                }).catch(error => {
                    console.log(error)
                })
            },


            // editRoleModel
            editRoleModel(roleData) {
                console.log(roleData.id)
                this.currentRoleId = roleData.id
                // Current role array empty
                this.currentRoles = []
                // role found then push in arry
                roleData.sms_roles.forEach(element => {
                    // console.log('loop', element.id)
                    this.currentRoles.push(element.id)
                })

                // Role modal show
                this.roleModelShow = true;
            },

            // update user role
            updateUserRole() {

                this.roleUpdating = true
                axios.post(this.currentUrl + '/roles_update', {
                        currentRoleId: this.currentRoleId,
                        roles: this.currentRoles,
                    })
                    .then(response => {
                        this.roleUpdating = false
                        //console.log(response)
                        // Refetch
                        this.getResults();
                        // Modal closed
                        this.roleModelShow = false;

                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.msg,
                            customClass: 'text-success'
                        });
                    })
                    .catch(error => {
                        // Modal closed
                        this.roleModelShow = false;
                        this.roleUpdating = false
                        Swal.fire({
                            icon: 'error',
                            title: 'Somthing Going Wrong',
                            customClass: 'text-danger'
                        });
                        console.log(error)
                    })


            },


            // CurrentUserData
            ...userDetailsMethods,

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

        created(){
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
