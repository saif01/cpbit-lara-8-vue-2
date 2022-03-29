<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Sub Ip List
                    </v-col>
                    <v-col cols="2">
                        <v-btn @click="addDataModel()" color="primary" small outlined
                            class="float-right">
                            <v-icon left dark>mdi-plus-circle-outline </v-icon> Add
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text>
                <div v-if="allData.data">
                    <v-row>
                        <v-col cols="2">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col cols="4">
                            <v-text-field
                                v-model="newsearch"
                                append-icon="mdi-magnify"
                                label="Search"
                                hide-details
                                class="mb-5"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>

                        

                        <v-col cols="4">
                            <v-select label="Search By Group Name" v-model="sort_by_name" :items="group_names" item-text="name" item-value="name" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col cols="2">
                            <v-btn @click="pingAll()" color="info" small
                                    class="float-right">
                                <v-icon small>mdi-access-point-network</v-icon> Ping All
                                </v-btn>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>IP</th>
                                <th>Name</th>
                                <th>Group</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>
                                    <span v-if="singleData.ip">
                                        {{singleData.ip}}
                                    </span>
                                </td>
                                <td>
                                    <span v-if="singleData.name">
                                        {{singleData.name}}
                                    </span>
                                </td>
                                <td>
                                    <span v-if="singleData.group_name">
                                        {{singleData.group_name}}
                                    </span>
                                </td>
                                <td>
                                    <span v-if="singleData.status == 1">
                                        <span class="success--text">Active</span>
                                    </span>
                                    <span v-else>
                                        <span class="warning--text">Inactive</span>
                                    </span>
                                </td>
                               
                        
                                <td>
                                    <v-btn @click="ping(singleData.id)" color="indigo white--text" depressed small class="m-1">
                                        <v-icon small>mdi-access-point-network</v-icon> Ping
                                    </v-btn>
                                    
                                    <v-btn v-if="singleData.status" @click="statusChange(singleData)" color="success" depressed small class="m-1">
                                        <v-icon small>mdi-check-circle-outline</v-icon> Active
                                    </v-btn>
                                    <v-btn v-else @click="statusChange(singleData)" color="warning" depressed small class="m-1">
                                        <v-icon small>mdi-alert-circle-outline </v-icon> Inactive
                                    </v-btn>
                                    
                                    <v-btn @click="editDataModel(singleData)" color="info" depressed small class="m-1">
                                        <v-icon small>mdi-pencil-box-multiple-outline</v-icon> Edit
                                    </v-btn>

                                    <v-btn @click="deleteData(singleData.id)" color="error" depressed small class="m-1">
                                        <v-icon small>mdi-delete-empty</v-icon> Delete
                                    </v-btn>

                                    <br>
                                    <span v-if="singleData.makby" class="small text-muted">Create By-- {{ singleData.makby.name }}</span>
                                </td>
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
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </v-card-text>
        </v-card>


        <!-- Modal -->
        <v-dialog v-model="dataModalDialog" max-width="600px" persistent>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            {{dataModelTitle}}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialog = false, resetForm()" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-form v-model="valid" ref="form">
                        <form @submit.prevent="editmode ? updateData() : createData()">

                            <v-row>
                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('ip')" v-html="form.errors.get('ip')" />
                                    <v-text-field v-model="form.ip" label="Enter IP" placeholder="10.20.30.40" :rules="networkRules" required></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                                    <v-text-field v-model="form.name" label="Enter IP Address Name" :rules="networkRules" required></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('group_name')" v-html="form.errors.get('group_name')" />
                                    <v-select label="Select Group Name" v-model="form.group_name" :items="group_names" item-text="name" item-value="name" :rules="networkRules" required>
                                    </v-select>
                                </v-col>

                            </v-row>

                            <v-btn v-show="editmode" type="submit" block depressed :loading="addNetworkLoader" color="primary"><v-icon>mdi-edit</v-icon> Update</v-btn>
                            <v-btn v-show="!editmode" type="submit" block depressed :loading="addNetworkLoader" color="primary"><v-icon>mdi-save</v-icon> Create</v-btn>
                            

                        </form>
                    </v-form>

                </v-card-text>
            </v-card>
        </v-dialog>


        <!-- overlay -->
        <custom-overlay v-if="overlay == true"></custom-overlay>
    </div>
</template>



<script>
    // vform
    import Form from 'vform';
    import overlay from '../customoOverlay.vue'
   

    export default {
      
        data() {

            return {
                // overlay
                overlay: false,

                // v-form
                valid:false,
                // dialog
                dataModalDialog:false,

                // loader
                addNetworkLoader:false,

                networkRules:[v => !!v || 'This field is required!'],


                //current page url
                currentUrl: '/network/admin/sub-ip',


              
                // Form
                form: new Form({
                    id: '',
                    ip: '',
                    name: '',
                    group_name: '',
                    status: '',
                }),


                group_names:[],
                
                // sort
                sort_by_name: '',


            }


        },

        components:{
            "custom-overlay":overlay
        },

        methods: {
            // all group name
            getAllGroupName() {
                axios.get(this.currentUrl + '/group_name').then((response) => {
                    this.group_names = response.data;
                }).catch((data) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong<br>'+data.message,
                        customClass: 'text-danger'
                    });
                    
                });

            },


            // Get table data
            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl+'/index?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.newsearch +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_by_name=' + this.sort_by_name +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field
                    )
                    .then(response => {
                        //console.log(response.data.data);
                        //console.log(response.data.from, response.data.to);
                        this.allData = response.data;
                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;
                        
                        // stick into current page
                        this.currentPageNumber  = response.data.current_page

                        //console.log('currentPageNumber: ', this.currentPageNumber)
                    
                        // Loading Animation
                        this.dataLoading = false;

                    });
                },
            

        },


        watch: {

            //Excuted When make change value 
            sort_by_name: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },
        },


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
            this.getAllGroupName();
        },



    }

</script>