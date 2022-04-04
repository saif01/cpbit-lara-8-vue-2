<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Zone Offices List</h3>
                    </div>
                    <div class="col-6">
                        <v-btn @click="addDataModel" elevation="10" small class="float-right" color="primary" outlined>
                            <v-icon small>mdi-card-plus</v-icon> Add
                        </v-btn>
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
                        <thead class="text-center">
                            <tr>
                                <th>
                                    <a href="#" @click.prevent="change_sort('id')">ID</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'id'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'id'">&darr;</span>

                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('name')">Name</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                                <th>Offices</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>{{ singleData.id }}</td>
                                <td>{{ singleData.name }}</td>
                                <td>{{ singleData.offices }}
                                   
                                </td>
                                <td><span v-if="singleData.makby">{{ singleData.makby.name }}</span></td>
                        
                                <td class="text-center">
                                    <v-btn v-if="singleData.status" @click="statusChange(singleData)" small color="primary" elevation="10" class="mb-1">
                                        <v-icon left>mdi-check-decagram</v-icon> Active
                                    </v-btn>
                                    <v-btn v-else @click="statusChange(singleData)" small color="warning" elevation="10" class="mb-1">
                                        <v-icon left>mdi-close-octagon</v-icon> Inactive
                                    </v-btn>
                                    
                                    <v-btn @click="editDataModel(singleData)" small color="info"  elevation="10" class="mb-1">
                                        <v-icon left>mdi-circle-edit-outline</v-icon> Edit
                                    </v-btn>

                                    <v-btn @click="deleteData(singleData.id)" small color="error" elevation="10" class="mb-1">
                                       <v-icon left>mdi-delete-empty</v-icon> Delete
                                    </v-btn>    
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
                        <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </div>
        </div>



        <!-- Dilog  -->
        <v-dialog v-model="dataModalDialog" persistent max-width="1000px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            {{ dataModelTitle }}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialog = false" color="red lighten-1" small text class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
            
                <v-card-text>
                    <v-form v-model="valid">
                        <form @submit.prevent="editmode ? updateData() : createData()">

                            <v-row>
                                <v-col cols="12">
                                    <div class="text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                                    <v-select
                                    label="Select Zone"
                                    outlined
                                    v-model="form.name"
                                    :items="allZones"
                                    item-text="name"
                                    item-value="name"
                                    >
                                    </v-select>
                                </v-col>

                                <v-col cols="12">
                                    <v-select
                                    label="Select Offices"
                                    outlined
                                     v-model="form.offices"
                                     :items="allOffices"
                                     item-text="zone_office"
                                     item-value="zone_office"
                                     attach
                                     chips
                                     multiple
                                    >
                                    </v-select>
                                </v-col>

                               

                                <v-btn block blockdepressed :loading="dataModalLoading" color="primary mt-3"
                                    type="submit">
                                    <span v-if="editmode">
                                        <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                                    </span>
                                    <span v-else>
                                        <v-icon left dark>mdi-shape-polygon-plus </v-icon> Create
                                    </span>
                                </v-btn>

                            </v-row>
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
   

    export default {
      
        data() {

            return {

                //current page url
                currentUrl: '/super_admin/zone/offices',

                allZones: '',
                allOffices: '',
              
                // Form
                form: new Form({
                    id: '',
                    name: '',
                    offices: [],
                }),

               
                   
                

            }


        },

        methods: {

            // getAllZons
            getAllZons(){
                axios.get(this.currentUrl+ '/allzones').then(response=>{
                   // console.log('ZoneName: ', response.data, response.data)
                    this.allZones = response.data
                }).catch(error=>{
                    console.log(error)
                })
            },

            // getAllOffices
            getAllOffices(){
                axios.get(this.currentUrl+ '/alloffices').then(response=>{
                    //console.log(response.data)
                    this.allOffices = response.data
                }).catch(error=>{
                    console.log(error)
                })
            },


            // offices str to pill 
            // officesStrToPill(val){
              
            // },


            // Edit Data Modal
            editDataModel(singleData){
                this.editmode = true;
                this.dataModelTitle = 'Update Data'

                this.form.reset();
                
                this.form.id = singleData.id
                this.form.name    = singleData.name

                let officeArr = singleData.offices.split(",")
                this.form.offices = officeArr

                //console.log(officeArr, singleData)
                
                //this.form.fill(singleData);
                this.dataModalDialog = true;
            },


        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();

            this.getAllZons();
            this.getAllOffices();

            this.$Progress.finish();
        },





    }

</script>
