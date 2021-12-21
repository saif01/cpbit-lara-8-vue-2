<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">All Registered Users Table</h3>
                    </div>
                   
                </div>
            </div>

            <div class="card-body table-responsive">
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
                                    <button v-if="singleData.verify != 1" @click="editDataModelDirect(singleData)" class="btn btn-warning btn-sm"> 
                                        <i class="fa fa-edit blue"></i>Create
                                    </button>  
                                    <span v-else class="text-success">Created</span>

                                </td>
                                <td>
                                    <span v-if="singleData.verify == 1" class="text-success">Verified</span> <span v-else class="text-danger">Not Verified</span>
                                    <span class="text-muted small float-right" v-if="singleData.verified">--{{ singleData.verified.name }}</span>
                                </td>
                                <td>{{ singleData.login  }}
                                    <img v-if="singleData.image"
                                    :src="imagePathSm + singleData.image" alt="image" class="img-fluid" height="50" width="80">
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



        <!-- Data Model -->
        <b-modal ref="data-modal" scrollable :title="dataModelTitle" size="xl" hide-footer>

            <b-overlay :show="formProgressStatus" variant="white" rounded="sm"> 

                <form @submit.prevent="createDataDirect()"> 
                    <div class="row">
                        <div class="col-md-4">
                            <b-form-group label="User AD ID:">
                                <b-form-input v-model="form.login" placeholder="Enter user AD ID" size="sm" required :class="{ 'is-invalid': form.errors.has('login') }" ></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('login')" v-html="form.errors.get('login')" />
                            </b-form-group>
                        </div>
                        <div class="col-md-4">
                            <b-form-group label="User Name:">
                                <b-form-input v-model="form.name" placeholder="Enter User name" size="sm" required :class="{ 'is-invalid': form.errors.has('name') }" ></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                            </b-form-group>
                        </div>
                        <div class="col-md-4">
                            <b-form-group label="User Department:">
                                <b-form-input v-model="form.department" placeholder="Enter User department" size="sm" :class="{ 'is-invalid': form.errors.has('department') }"></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('department')" v-html="form.errors.get('department')" />
                            </b-form-group>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <b-form-group label="User Office ID:">
                                <b-form-input v-model="form.office_id" placeholder="Enter user office id" size="sm" :class="{ 'is-invalid': form.errors.has('office_id') }" ></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('office_id')" v-html="form.errors.get('office_id')" />
                            </b-form-group>
                        </div>
                        <div class="col-md-4">
                            <b-form-group label="User Office Contact:">
                                <b-form-input v-model="form.office_contact" placeholder="Enter User office contact" size="sm" :class="{ 'is-invalid': form.errors.has('office_contact') }" ></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('office_contact')" v-html="form.errors.get('office_contact')" />
                            </b-form-group>
                        </div>
                        <div class="col-md-4">
                            <b-form-group label="User Personal Contact:">
                                <b-form-input v-model="form.personal_contact" placeholder="Enter User personal contact" size="sm" :class="{ 'is-invalid': form.errors.has('personal_contact') }"></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('personal_contact')" v-html="form.errors.get('personal_contact')" />
                            </b-form-group>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <b-form-group label="User Office Email:">
                                <b-form-input type="email" v-model="form.office_email" placeholder="Enter user office email" size="sm" :class="{ 'is-invalid': form.errors.has('office_email') }" ></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('office_email')" v-html="form.errors.get('office_email')" />
                            </b-form-group>
                        </div>
                        <div class="col-md-4">
                            <b-form-group label="User Personal Email:">
                                <b-form-input v-model="form.personal_email" placeholder="Enter User personal email" size="sm" :class="{ 'is-invalid': form.errors.has('personal_email') }" required></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('personal_email')" v-html="form.errors.get('personal_email')" />
                            </b-form-group>
                        </div>
                        <div class="col-md-4">
                            <b-form-group label="User Office Location:">
                                <b-form-input v-model="form.office" placeholder="Enter User office location" size="sm" :class="{ 'is-invalid': form.errors.has('office') }"></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('office')" v-html="form.errors.get('office')" />
                            </b-form-group>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <b-form-group label="User Business Unit:">
                                <b-form-input v-model="form.business_unit" placeholder="Enter user business unit" size="sm" :class="{ 'is-invalid': form.errors.has('business_unit') }" ></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('business_unit')" v-html="form.errors.get('business_unit')" />
                            </b-form-group>
                        </div>
                    
                    </div>

                    <div class="bg-light p-2 rounded border border-warning">
                        <div class="row">
                            <div class="col-md-6">
                            <b>Manager Name :</b> {{ manager_name }}, <br>
                            <b>Manager Email :</b> {{ manager_email }}, 
                            </div>

                            <div class="col-md-6">
                                <b>B.U Name :</b> {{ bu_name }}, <br>
                                <b> B.U Email :</b> {{ bu_email }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <b>Remarks :</b> {{ remarks }}
                            </div>
                        </div>

                    </div>

                    <!-- Start Manager Selection -->
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                        <b-form-group label="" v-slot="{ ariaDescribedby }">
                            <b-form-radio-group
                                v-model="radioBtnSeelected"
                                :options="options"
                                :aria-describedby="ariaDescribedby"
                                @change="managerSelectBy()"
                            ></b-form-radio-group>
                        </b-form-group>
                        </div>
                        <div class="col-md-12 text-center mb-2" :class="{ hide: !managerByIdShow }">
                            <span v-if="selectedManagerName.length >0">
                                <span v-for="item in selectedManagerName" :key="item">
                                    <b-badge variant="primary" class="mx-1">{{ item }}</b-badge>
                                </span>
                            </span>
                            <span v-else class="text-danger">Not Selected</span>
                        </div>
                    </div>

                    <div class="row">
                    
                        <div class="col-md-12 text-center" :class="{ hide: !managerByIdShow }">
                            <b-button @click="modal2ndShow" size="sm" variant="info"><i class="fas fa-search-plus"></i> Select Manager</b-button>
                        </div>
                        <div class="col-md-12" id="managerByEmailShow" :class="{ hide: !managerByEmailShow }" >
                            <b-form-group label="User Business Unit:">
                                <b-form-input v-model="form.manager_emails" placeholder="Enter user business unit" size="sm" :class="{ 'is-invalid': form.errors.has('manager_emails') }" ></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('manager_emails')" v-html="form.errors.get('manager_emails')" />
                            </b-form-group>
                        </div>

                    </div>
                    <hr>
                    <!-- End Manager Selection -->

                    <!-- User tye and status -->
                <div class="row">
                        <div class="col-md-6">
                            <b-form-group label="Account Status" v-slot="{ ariaDescribedby2 }">
                                <b-form-radio-group  
                                    v-model="form.status"
                                    :options="activeOptions"
                                    :aria-describedby="ariaDescribedby2"
                                    @change="managerSelectBy()"
                                ></b-form-radio-group>
                            </b-form-group>
                        </div>
                        <div class="col-md-6">   
                            <label> User Type</label>
                            <div class="row"> 
                                <b-form-checkbox v-model="form.user" name="checkbuttonuser" class="mr-2" value="1" >
                                User </b-form-checkbox>
                                <b-form-checkbox v-model="form.admin" name="checkbuttonadmin" value="1" > Admin </b-form-checkbox>
                            </div>
                        </div>
                </div>

                
                    <!-- User Image -->
                    <b-form-group>
                    <div class="row">
                        <div class="col-md-6">
                            <b-form-file v-on:input="uploadImageByName($event, 'image')"
                                placeholder="Choose or drop Image here..." size="sm" accept=".jpg, .png, .jpeg">
                            </b-form-file>
                        </div>
                        <div class="col-md-6 mt-1">
                            <img :src="showImageByName('image')" class="rounded mx-auto d-block image-thum-size" />
                        </div>
                    </div>
                    </b-form-group>
                

                    <b-form-group v-if="!form.progress">
                        <b-button type="submit" class="btn-block" variant="primary"><i class="fas fa-plus"></i> Create</b-button>
                    </b-form-group>

                     
                </form>
            </b-overlay>
        
        </b-modal>


        <!-- Second Model for manager list-->
        <b-modal id="modal-multi-2" v-model="userModal2ndShowHide" title="All User List" hide-footer >

            <!-- {{ selectedManager }} -->

            <div class="card-body p-0 table-responsive">
                <div v-if="allData2.data">
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

                    <table class="table table-bordered table-hover table-sm ">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('login')">login</a>
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
                                    <a href="#" @click.prevent="change_sort('office_id')">Office ID</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'office_id'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'office_id'">&darr;</span>
                                </th>
                                 <th>
                                    <a href="#" @click.prevent="change_sort('business_unit')">business_unit</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'business_unit'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'business_unit'">&darr;</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData2.data" :key="singleData.id">
                                <td>
                                    <b-form-checkbox  v-model="selectedManager" :value="singleData.id" unchecked-value=""></b-form-checkbox>
                                </td>
                                <td>{{ singleData.login }}</td>
                                <td>{{ singleData.name }}</td>
                                <td>{{ singleData.department }}</td>
                                <td>{{ singleData.office_id }}</td>
                                <td>{{ singleData.business_unit }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span>Total Records: {{ totalValue2 }}</span>
                    </div>
                    <pagination :data="allData2" :limit="3" @pagination-change-page="usersData" class="justify-content-end">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-else>
                    <div v-if="dataLoading2" class="p-5 my-5">
                        <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
                    </div>
                </div>
                <h1 v-if="!totalValue2 && !dataLoading2" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </div>


            <b-button @click="setManager" size="sm" variant="success" class="btn-block"><i class="far fa-check-circle"></i> Selected</b-button>
           
        </b-modal>




    </div>

</template>


<script>
    // vform
    import Form from 'vform';

    import allJsMethods from './indexMethods'


    export default {

      
        data() {

            return {

                //current page url
                currentUrl: '/super_admin/register',

                selectedManager:[],
                selectedManagerName:[],

                radioBtnSeelected: 'managerById',
                options: [
                    { text: 'Manager Select By ID', value: 'managerById' },
                    { text: 'Or Manul Input Email Address', value: 'managerByEmail' },
                ],
                managerByIdShow:true,
                managerByEmailShow:false,

                userModal2ndShowHide:false,

        
                activeOptions: [
                    { text: 'Active', value: '1' },
                    { text: 'Blocked', value: '0' },
                ],
              


                allRoles: {},
                currentRoles: [],
                currentRoleId: null,
                roleUpdating: false,
                roleModelShow: false,

                allUsers:{},

               
              
                // Form
                form: new Form({
                    id: '',
                    login   : '',
                    user    : '1',
                    admin   : '',
                    name    : '',
                    image   : '',
                    department: '',
                    office_id: '',
                    office_contact: '',
                    personal_contact: '',
                    office_email:'',
                    personal_email:'',
                    office:'',
                    business_unit: '',
                    nid:'',
                    manager_id:[],
                    manager_emails:'',
                    status:'1'
                }),


                imageMaxSize: '5111775',
                imagePath: '/images/users/',
                imagePathSm: '/images/users/small/',


                singleUserModalShow:false,
                singleUserModalData:{},

                manager_name:'',
                manager_email:'',
                bu_name:'',
                bu_email:'',
                remarks:'',

                formProgressStatus: false,

                // Manager Selecting Issue 
                allData2: {},
                totalValue2: '',
                dataShowFrom2: '',
                dataShowTo2: '',
                // Loading Animation
                dataLoading2: false,

            }


        },

        methods: {

            // All JS Methods
            ...allJsMethods
           

        },

     

       


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            // Get Current Users 
            this.usersData();
            this.$Progress.finish();
        },



    }

</script>


<style scoped>
.hide {
    /* visibility: hidden !important; */
    display: none !important;
}
 .image-thum-size{
        height: 50px;
        width: 100px;
    }
</style>

