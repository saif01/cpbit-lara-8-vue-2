<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Role Table</h3>
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
                        <thead>
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
                               
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>{{ singleData.id }}</td>
                                <td>{{ singleData.name }}</td>
                                
                                <td class="text-center">
                                    <!-- v-if="isAdministrator()" -->
                                    <v-btn  @click="editDataModel(singleData)" small color="info" elevation="10" class="mb-1">
                                        <v-icon left>mdi-circle-edit-outline</v-icon> Edit
                                    </v-btn>
                                    
                                    <!-- v-if="isAdministrator()" -->
                                    <v-btn  @click="deleteData(singleData.id)" small color="error" elevation="10" class="mb-1">
                                        <v-icon left>mdi-close-octagon</v-icon> Delete
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


        <v-dialog v-model="dataModalDilog" max-width="700px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            {{dataModelTitle}}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDilog = false" color="red lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>

                <v-card-text>

                    <v-form v-model="valid">
                        <form @submit.prevent="editmode ? updateData() : createData()">

                                <v-text-field v-model="form.name" label="Enter role name" 
                                            :rules="[v => !!v || 'Role Name is required!']" required>
                                </v-text-field>
                                <div class="small text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                                

                                <v-btn block blockdepressed :loading="modalBtnLoading" color="primary mt-3"
                                        type="submit">
                                    <span v-if="editmode">
                                        <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                                    </span>
                                    <span v-else>
                                        <v-icon left dark>mdi-shape-polygon-plus </v-icon> Create
                                    </span>
                                </v-btn>

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
                // current page url
                currentUrl: '/ivca/admin/user/role',
              
                // Form
                form: new Form({
                    id: '',
                    name: '',
                }),

            }


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
