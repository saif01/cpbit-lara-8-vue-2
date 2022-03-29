<template>
    <div>
        <v-card>
            
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Main Ip List
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
                        <v-col lg="2" cols="4">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="8" cols="6">
                            <v-text-field
                                v-model="newsearch"
                                append-icon="mdi-magnify"
                                label="Search"
                                hide-details
                                class="mb-5"
                                outlined
                                dense
                            >
                            </v-text-field>
                        </v-col>

                        <v-col cols="2">
                            <v-btn @click="pingAll()" color="info" 
                                    class="float-right">
                                <v-icon >mdi-access-point-network</v-icon> Ping All
                                </v-btn>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>IP</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Ping Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>
                                    <span v-if="singleData.ip">
                                        {{singleData.ip}}
                                    </span>
                                    <div class="text-center">
                                        <v-btn v-if="(singleData.id != checkID)" @click="clipboard(singleData)" x-small color="orange">Copy</v-btn>
                                        <v-btn v-else-if="(singleData.id == checkID)" x-small color="teal">Copied</v-btn>
                                    </div>
                                    
                                </td>
                                <td>
                                    <span v-if="singleData.name">
                                        {{singleData.name}}
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
                                    <span v-if="singleData.start">
                                        {{ singleData.start }} -- {{singleData.end }} 
                                        <div class="text-center indigo--text" v-if="singleData.pingType">
                                            ({{singleData.pingType}})
                                        </div>
                                    </span>
                                </td>
                               
                        
                                <td>
                                    
                                    <v-btn @click="ping(singleData.ip)" color="indigo white--text" depressed small class="m-1">
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
                                    <v-text-field v-model="form.ip" label="Enter IP" placeholder="10.20.30.40" :rules="networkRules" required dense outlined></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                                    <v-text-field v-model="form.name" label="Enter IP Address Name" :rules="networkRules" required dense outlined></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('pingType')" v-html="form.errors.get('pingType')" />
                                    <v-select label="Select Ping Time" v-model="form.pingType" :items="pingOptions" :rules="networkRules" required dense outlined>
                                    </v-select>
                                </v-col>

                                <v-col cols="6">
                                    <!-- start_time -->
                                    <v-menu ref="menu3" v-model="menu3" :close-on-content-click="false"
                                        :return-value.sync="time" max-width="290px" min-width="290px" :disabled="form.pingType != 0">
                                        <template v-slot:activator="{ on, attrs }">
                                            <div class="small text-danger" v-if="form.errors.has('start')"
                                                v-html="form.errors.get('start')" />
                                            <v-text-field v-model="form.start" label="Start Ping"
                                                prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"
                                                 :class="{ 'is-invalid': form.errors.has('start') }"
                                                required outlined dense></v-text-field>
                                            
                                        </template>
                                        <v-time-picker v-if="menu3" v-model="form.start" full-width
                                            @click:minute="$refs.menu3.save(time)" ></v-time-picker>
                                    </v-menu>
                                </v-col>
                                <v-col cols="6">
                                    <v-menu ref="menu4" v-model="menu4" :close-on-content-click="false"
                                        :return-value.sync="time" max-width="290px" min-width="290px" :disabled="form.pingType != 0">
                                        <template v-slot:activator="{ on, attrs }">
                                            <div class="small text-danger" v-if="form.errors.has('end')"
                                                v-html="form.errors.get('end')" />
                                            <v-text-field v-model="form.end" label="End Ping"
                                                prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" required outlined dense></v-text-field>
                                            
                                        </template>
                                        <v-time-picker v-if="menu4" v-model="form.end" full-width
                                            @click:minute="$refs.menu4.save(time)"></v-time-picker>
                                    </v-menu>
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

                menu3: '',
                menu4: '',
                time: '',
                // v-form
                valid:false,
                // dialog
                dataModalDialog:false,

                // loader
                addNetworkLoader:false,

                networkRules:[v => !!v || 'This field is required!'],


                //current page url
                currentUrl: '/network/admin/main-ip',


              
                // Form
                form: new Form({
                    id: '',
                    ip: '',
                    name: '',
                    status: '',
                    pingType: 0,
                    start: '',
                    end: '',
                }),


                // pingOptions
                pingOptions: [
                    {
                        value: 0,
                        text: 'Select One Ping Time'
                    },
                    {
                        value: 'OfficeTime',
                        text: 'Office Time (9.00 AM - 6.00 PM)'
                    },
                    {
                        value: 'fullDay',
                        text: 'Full Day (6.00 AM - 6.00 PM)'
                    },
                    {
                        value: 'fullNight',
                        text: 'Full Night (6.00 PM - 6.00 AM)'
                    },
                    {
                        value: 'dayNight',
                        text: 'Full Day Night (1.00 AM - 11.59 PM)'
                    },
                ],

                checkID: '',


            }

           


        },

        components:{
            "custom-overlay":overlay
        },

        methods: {

        },


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();

        },



    }

</script>
