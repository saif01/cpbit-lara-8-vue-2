<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Zone Offices Table</h3>
                    </div>
                    <div class="col-6">
                        <b-button variant="outline-primary" size="sm" pill class="float-right" @click="addDataModel"><i
                                class="far fa-plus-square"></i>
                            Add</b-button>
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
                                    <div>
                                        <button v-if="singleData.status" @click="statusChange(singleData)" class="btn btn-success btn-sm m-1">
                                            <i class="far fa-check-circle"></i> Active
                                        </button>
                                        <button v-else @click="statusChange(singleData)" class="btn btn-warning btn-sm m-1">
                                            <i class="far fa-times-circle"></i> Inactive
                                        </button>
                                    </div>
                                    <button @click="editDataModel(singleData)" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit blue"></i> Edit
                                    </button>

                                    <button @click="deleteDataTemp(singleData.id)" class="btn btn-danger btn-sm m-1">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>    
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


        <b-modal ref="data-modal" :title="dataModelTitle" scrollable size="lg" hide-footer>
            <form @submit.prevent="editmode ? updateData() : createData()">

                <b-form-group label="All Zones"> 
                    <b-form-select v-model="form.name" required>
                        <option value="">Select Zone</option>
                        <option v-for="item in allZones" :key="item.id" :value="item.name" >{{ item.name }}</option>
                    </b-form-select>
                    <div class="small text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                </b-form-group>
                {{ form.offices }}
                <b-form-group label="All Offices"> <small>Select Multiple Offices by Pressing Shift or Ctrl Key</small>
                    <b-form-select v-model="form.offices" multiple :select-size="15" required>
                        <!-- <option value="">Select Multiple Offices by Pressing Shift Key</option> -->
                        <option v-for="item in allOffices" :key="item.id" :value="item.zone_office" >{{ item.zone_office }}</option>
                    </b-form-select>
                    <div class="small text-danger" v-if="form.errors.has('offices')" v-html="form.errors.get('offices')" />
                </b-form-group>

              
           
                <b-form-group v-if="!form.progress">
                    <b-button v-show="editmode" type="submit" class="btn-block" variant="primary"><i class="fa fa-edit"></i> Update</b-button>
                    <b-button v-show="!editmode" type="submit" class="btn-block" variant="primary"><i
                                class="far fa-plus-square"></i> Create</b-button>
                </b-form-group>


            </form>


        </b-modal>


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
                    console.log(response.data)
                    this.allZones = response.data
                }).catch(error=>{
                    console.log(error)
                })
            },

            // getAllOffices
            getAllOffices(){
                axios.get(this.currentUrl+ '/alloffices').then(response=>{
                    console.log(response.data)
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
                this.$refs['data-modal'].show();
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
