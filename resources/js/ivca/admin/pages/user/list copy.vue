<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">User List</h3>
                    </div>
                    <div class="col-6">

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

                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th>
                                    <a href="#" @click.prevent="change_sort('login')">Login ID</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'login'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'login'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('name')">Name</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('office_id')">Office ID</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'office_id'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'office_id'">&darr;</span>
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
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td class="text-center">
                                    <div v-if="singleData.image">
                                        <v-avatar size="50">
                                            <img :src="'/images/users/small/'+singleData.image" alt="Image">
                                        </v-avatar>
                                        <!-- <img :src="'/images/user/small/'+singleData.image_small" alt="Image"> -->
                                    </div>
                                    <div v-else class="text-danger"> No Image</div>
                                    
                                    {{ singleData.login }}
                                </td>
                                <td>{{ singleData.name }}</td>
                                <td>{{ singleData.office_id }}</td>
                                <td>{{ singleData.department }}</td>
                                <td>{{ singleData.business_unit }}</td>
                                <td>
                                    <span v-if="singleData.ivca_roles.length">
                                        <span v-for="(role, index) in singleData.ivca_roles" :key="index">
                                            <span>{{ role.name }}, </span>
                                        </span>
                                    </span>
                                    <span v-else>
                                        <span class="text-danger">You have no roles</span>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <v-btn @click="editRoleModel(singleData)" color="info">
                                        <v-icon>mdi-alpha-r-circle</v-icon> Role
                                    </v-btn>
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

        <!-- Role Assign Dilog -->
        <v-dialog v-model="roleDialog" max-width="700px">

            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Assign Roles 
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="roleDialog = false" color="red lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
            

                <v-card-text>
                    <div class="pb-4">
                        <!-- {{ currentRoles }} -->
                        <div class="row">
                            <div class="col-3" v-for="(role, index) in allRoles" :key="index">
                                <v-checkbox v-model="currentRoles" :value="role.id" unchecked-value="" :label="role.name">
                                </v-checkbox>
                            </div>
                        </div>
                    </div>
                    <v-btn @click="updateUserRole()" block blockdepressed :loading="roleUpdating" color="primary mt-3" >
                        <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                    </v-btn>
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
                // roleDialog
                roleDialog:false,

                //current page url
                currentUrl: '/ivca/admin/user/list',

                allRoles: {},
                currentRoles: [],
                currentRoleId: null,
                roleUpdating: false,


            }


        },

        methods: {

            // Get all Role
            getRoles() {
                axios.get(this.currentUrl + '/roles_data').then(response => {
                    console.log(response.data)
                    this.allRoles = response.data
                }).catch(error => {
                    console.log(error)
                })
            },

            // Add Data Model
            addRoleModel() {
                // this.$refs['data-modal-role'].show();
                this.roleDialog = true;
            },

            // editRoleModel
            editRoleModel(roleData) {
                console.log(roleData)
                this.currentRoleId = roleData.id
                // Current role array empty
                this.currentRoles = []
                // role found then push in arry
                roleData.ivca_roles.forEach(element => {
                    // console.log('loop', element.id)
                    this.currentRoles.push(element.id)
                })

                // Role modal show
                // this.$refs['data-modal-role'].show();
                this.roleDialog = true;
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
                        console.log(response)
                        // Refetch
                        this.getResults();
                        // Modal closed
                        // this.$refs['data-modal-role'].hide();
                        this.roleDialog = false;
                        Toast.fire({
                            icon: response.data.icon,
                            title: response.data.msg
                        });
                    })
                    .catch(error => {
                        console.log(error)
                    })


            }

        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.getRoles();

            this.$Progress.finish();
        },



    }

</script>
