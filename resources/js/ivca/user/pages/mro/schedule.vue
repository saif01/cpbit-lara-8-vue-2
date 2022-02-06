<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                        <span class="card-title h3">MRO Audit Schedules</span> <span
                            class="text-muted">{{ new Date() | moment("dddd, MMMM Do YYYY") }}</span>
                            <span v-if="auth" class="float-right">{{ auth.name }} <span v-if="isAdmin()"> ( Admin )</span> <span v-else-if="isAuditor()"> ( Auditor )</span> <span v-else-if="isUser()">( User )</span></span>
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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>
                                        <a href="#" @click.prevent="change_sort('date')">Audit Date</a>
                                        <span v-if="sort_direction == 'desc' && sort_field == 'date'">&uarr;</span>
                                        <span v-if="sort_direction == 'asc' && sort_field == 'date'">&darr;</span>
                                    </th>

                                    <th>Vendor Number</th>
                                    <th>Suppier Name</th>
                                    <th>Address</th>
                                    <th>Telephone</th>
                                    <th>Auditor Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="singleData in allData.data" :key="singleData.id">
                                    <td class="text-center">

                                        <div class="mb-3">
                                            <!-- audited_manufacturer -->
                                            <span v-if="singleData.audited_manufacturer">
                                                <v-badge v-if="(singleData.audited_manufacturer.status == 1)" color="success" content="Manufacturer Audit Completed" inline></v-badge>
                                            </span>
                                            
                                            <!-- audited_importer -->
                                            <span v-else-if="singleData.audited_importer">
                                                <v-badge v-if="(singleData.audited_importer.status == 1)" color="success" content="Importer Audit Completed" inline></v-badge>
                                            </span>
                                            <!-- audited_retailer -->
                                            <span v-else-if="singleData.audited_retailer">
                                                <v-badge v-if="(singleData.audited_retailer.status == 1)" color="success" content="Retailer Audit Completed" inline></v-badge>
                                            </span>


                                            <span v-else>
                                                 <!-- Token Genrated -->
                                                <span v-if="singleData.activetoken && singleData.activetoken.token && !isAuditor()">
                                                    <v-badge color="info" content="Token Genrated" inline></v-badge>
                                                </span>
                                            </span>
                                           
                                        </div>
                                        

                                        <!-- v-if="isAuditor()" -->
                                        <div >
                                            <!-- Generated Token Part -->
                                            <span v-if="singleData.activetoken && singleData.activetoken.token">

                                                <b class="h3 rounded bg-primary p-2 text-light link-hobar spacing"
                                                    @click="goForAudit(singleData.activetoken.token)">{{ singleData.activetoken.token }}</b>

                                            </span>
                                            <!--Not Generated Token Part -->
                                            <span v-else>
                                                <!-- Schedule date not matched with current date -->
                                               
                                                <span v-if="checkGenerateTokenAccess(singleData)">
                                                    <button  @click="generateToken(singleData)"
                                                        class="btn btn-success btn-sm m-1 link-hobar"><i
                                                            class="far fa-check-circle"></i> Token Generate
                                                    </button>
                                                </span>
                                                <!-- Schedule date matched with current date -->
                                                <span v-else>
                                                    <button class="btn btn-success btn-sm m-1 link-hobar-disabled"
                                                        disabled><i class="far fa-check-circle"></i> Token Generate
                                                    </button>
                                                </span>

                                            </span>
                                        </div>

                                        <!-- v-if="isUser() && !isAuditor()" -->
                                        <div >
                                            <!-- Schedule date not matched with current date -->
                                            <span v-if="singleData.date == todayDate">

                                                <button @click="showModal(singleData)"
                                                    class="btn btn-success btn-sm m-1 link-hobar">
                                                    <i class="far fa-clipboard"></i> Put Token
                                                </button>

                                            </span>

                                            <span v-else>
                                                <button class="btn btn-success btn-sm m-1 link-hobar-disabled" disabled>
                                                    <i class="far fa-clipboard"></i> Put Token
                                                </button>

                                                <!-- {{ todayDate }} == {{ singleData.date }}  -->
                                            </span>



                                        </div>

                                    </td>
                                    <td>{{ singleData.date }}</td>
                                    <td><span v-if=" singleData.vendor">{{ singleData.vendor.vendor_number }}</span></td>
                                    <td><span v-if=" singleData.vendor">{{ singleData.vendor.suppier_name }}</span></td>
                                    <td><span v-if=" singleData.vendor">{{ singleData.vendor.address }}</span></td>
                                    <td><span v-if=" singleData.vendor">{{ singleData.vendor.telephone }}</span></td>
                                    <td><span v-if=" singleData.user">{{ singleData.user.name }}</span></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
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


        <!-- token_check_model -->
        <v-dialog v-model="token_check_model" max-width="500px">

            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Verify Token
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="token_check_model = false" color="red lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-form v-model="valid">
                        <form @submit.prevent="putTokenByUser()">
                            <v-text-field v-model="form.token" label="Enter role token"
                                :class="{ 'is-invalid': form.errors.has('token') }" :rules="[v => !!v || 'Token is required!']" required ></v-text-field>
                            <div class="small text-danger" v-if="form.errors.has('token')" v-html="form.errors.get('token')" />
                            <div>
                                <v-btn type="submit" block dense :loading="tokenCheckLoading" color="primary"><v-icon>mdi-card-search</v-icon> Verify Token</v-btn>
                            </div>
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

    import moment from 'moment'

    export default {

        data() {
            return {
                valid:false,
                // dialog
                token_check_model:false,
                tokenCheckLoading: false,

                // current page url
                currentUrl: '/ivca/mro',
                sort_direction: 'asc',
                sort_field: 'date',
                allVendors: {},

                todayDate: moment().format("Y-MM-DD"),


                // Form 
                form: new Form({
                    id: '',
                    token: '',
                    vendor_id: '',
                }),
            }
        },



        methods: {

            // Check Role 
            checkRole() {
                if (!this.isMro()) {
                    // Error alart
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Sorry !, You have no access',
                    })
                    // Redirect
                    this.$router.push({
                        name: "ivca_dashboard"
                    })
                }
            },

            // Get table data
            getDirectResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl + '/index?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field
                    )
                    .then(response => {
                        console.log(response.data.data);

                        this.allData = response.data;
                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;

                        // Loading Animation
                        this.dataLoading = false;

                    });
            },

            // checkGenerateTokenAccess
            checkGenerateTokenAccess(singleData){
                if(singleData.user_id == this.auth.id && singleData.date == this.todayDate){
                    return true;
                }
                return false;
            },

            // Generate token
            generateToken(singleData) {

                axios.post(this.currentUrl + '/token/create', {
                    scheduleId: singleData.id,
                    vendorId: singleData.vendor.id
                }).then(response => {
                    //console.log(response.data)

                    this.getResults();

                    Swal.fire(
                        response.data.status,
                        response.data.msg,
                        response.data.icon,
                    )


                }).catch(error => {
                    console.log(error)
                })

            },

            // goForAudit
            goForAudit(token) {
                this.$router.push({
                    name: 'ivca_mro_choose_template',
                    query: {
                        token: token
                    }
                })
            },

            // Put Token By User
            putTokenByUser() {
                // Loading
                this.tokenCheckLoading = true
                this.form.post(this.currentUrl + '/token/check_by_user').then(response => {
                    //console.log(response.data)
                    
                    // Loading
                    this.tokenCheckLoading = false

                    // Hide Model
                    this.hideModal()

                    Swal.fire({
                        icon: response.data.icon,
                        title: response.data.status,
                        text: response.data.msg,
                    })

                    if (response.data.status == 'Success') {

                        // Redirect
                        this.$router.push({
                            name: 'ivca_mro_audit_questions',
                            query: {
                                token: response.data.token,
                            }
                        })

                    }



                }).catch(error => {
                    // Loading
                    this.tokenCheckLoading = false
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Sorry! Somthing going wrong',
                    })
                    console.log(error)
                })

            },

            // Show Modal
            showModal(singleData) {
                console.log(singleData.vendor_id)
                //this.form.token = singleData.activetoken.token
                this.form.vendor_id = singleData.vendor_id
                // this.form.fill(singleData)
                //this.$refs['token_check_model'].show();
                this.token_check_model=true;
            },

            // Hide Modal
            hideModal() {
                //this.$refs['token_check_model'].hide();
                this.token_check_model=false;
            }





        },

        // computed: {
        //     // a computed getter
        //     checkRunAudit: function (data) {
        //         // `this` points to the vm instance
        //         console.log('computed'+data)

        //         return data
        //     }
        // },

        created() {
            this.$Progress.start();
            // Check access
            this.checkRole();

            // Fetch initial results
            this.getDirectResults();

            this.$Progress.finish();

            console.log('Today',  this.todayDate, this.auth )
        }

    }

</script>
