<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <span class="card-title h3">MRO Audit Schedules</span> <span class="text-muted">{{ new Date() | moment("dddd, MMMM Do YYYY") }}</span>
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
                    
                    <table class="table table-bordered table-responsive">
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

                                  
                                   <p v-if="singleData.activetoken && singleData.activetoken.token"><b-badge pill variant="info">Token Generated</b-badge></p> 
                                       
                                    <div v-if="isAuditor()" >
                                        <!-- Generated Token Part -->
                                        <span v-if="singleData.activetoken && singleData.activetoken.token">
                                           
                                            <b class="h3 rounded bg-primary p-2 text-light link-hobar spacing" @click="goForAudit(singleData.activetoken.token)" >{{ singleData.activetoken.token }}</b>
                                    
                                        </span>
                                        <!--Not Generated Token Part -->
                                        <span v-else>
                                            <!-- Schedule date not matched with current date -->
                                            <span v-if="singleData.date == todayDate">
                                                <button @click="generateToken(singleData)" class="btn btn-success btn-sm m-1 link-hobar"><i class="far fa-check-circle"></i> Token Generate
                                                </button>
                                            </span>
                                            <!-- Schedule date matched with current date -->
                                            <span v-else>
                                                <button class="btn btn-success btn-sm m-1 link-hobar-disabled" disabled><i class="far fa-check-circle"></i> Token Generate
                                                </button>
                                            </span>
                                           
                                        </span>
                                    </div>

                                    <div v-if="isUser() && !isAuditor()">
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
                                <td>{{ singleData.vendor.vendor_number }}</td>
                                <td>{{ singleData.vendor.suppier_name }}</td>
                                <td>{{ singleData.vendor.address }}</td>
                                <td>{{ singleData.vendor.telephone }}</td>
                                <td>{{ singleData.user.name }}</td>
                               
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
        
        <b-modal ref="token_check_model" title="Check Token and Start Audit" size="sm" hide-footer>
            <form @submit.prevent="putTokenByUser()">

                <b-form-group label="Check Token:">
                    <b-form-input v-model="form.token" placeholder="Enter role token"
                         :class="{ 'is-invalid': form.errors.has('token') }"></b-form-input>
                    <div class="small text-danger" v-if="form.errors.has('token')" v-html="form.errors.get('token')" />
                </b-form-group>

                <b-form-group v-if="form.progress">
                    <b-progress :value="form.progress.percentage" variant="success" striped animated>
                    </b-progress>
                </b-form-group>

                <b-form-group v-if="!form.progress">
                    <b-button type="submit" class="btn-block" variant="primary">Check And Start Audit</b-button>
                </b-form-group>


            </form>


        </b-modal>

       isUser: {{ isUser() }}, isAuditor: {{ isAuditor() }}
    </div>
</template>

<script>
    // vform
    import Form from 'vform';

    import moment from 'moment'

    export default {

        data(){

            return {

                // current page url
                currentUrl     : '/ivca/audit/mro',
                sort_direction : 'asc',
                sort_field     : 'date',
                allVendors     : {},

                todayDate: moment().format("Y-MM-DD"),


                // Form 
                form: new Form({
                    id: '',
                    token: '',
                    vendor_id: '',
                }),
            }

        },



        methods:{

            // Generate token
            generateToken(singleData){

                axios.post( this.currentUrl+'/token/create', {
                    scheduleId: singleData.id,
                    vendorId: singleData.vendor.id
                }).then( response=>{
                    //console.log(response.data)

                    this.getResults();
                   
                    Swal.fire(
                        response.data.status,
                        response.data.msg,
                        response.data.icon,
                    )
                   

                }).catch(error=>{
                    console.log(error)
                })
                
            },

            // goForAudit
            goForAudit(token){
                 this.$router.push({name:'ivca_audit_choose_template', query: { token: token } })
                //this.$router.push({name:'ivca_audit_start', params: { token: token } })
            },

            // Put Token By User
            putTokenByUser(){

                this.form.post( this.currentUrl+'/token/check_by_user').then(response=>{
                    console.log(response.data)

                    // Hide Model
                    this.hideModal()

                    Swal.fire({
                        icon: response.data.icon,
                        title: response.data.status,
                        text: response.data.msg,  
                    })

                    if(response.data.status == 'Success'){

                        // Redirect
                        this.$router.push({
                            name:'ivca_audit_questions', 
                            query: { 
                                token: response.data.token, 
                            } 
                        })
                        
                    }

                    

                }).catch(error=>{
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
                this.$refs['token_check_model'].show();
            },

            // Hide Modal
            hideModal(){
                this.$refs['token_check_model'].hide();
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

        created(){
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            // this.generateToken();
            // this.userList();
            this.$Progress.finish();

            console.log('Today',  this.todayDate )
        }
        
    }
</script>


