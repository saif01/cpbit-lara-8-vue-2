<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Operations Name
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

                        <v-col lg="10" cols="8">
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search"
                                hide-details
                                class="mb-5"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <th>
                                    <a href="#" @click.prevent="change_sort('name')">Operation Name</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                                <th>
                                    Created By
                                </th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr v-for="singleData in allData.data" :key="singleData.id">
                                    <td>{{ singleData.name }}</td>
                                    <td v-if="singleData.makby">{{ singleData.makby.name }}</td>
                                    <td v-else><span class="error--text"> Not Found </span></td>
                            
                                    <td class="text-center">
                                        <v-btn @click="editDataModel(singleData)" color="info" depressed small>
                                            <v-icon small>mdi-pencil-box-multiple-outline</v-icon> Edit
                                        </v-btn>
                                        <v-btn @click="deleteData(singleData.id)" color="error" depressed small>
                                            <v-icon small>mdi-delete-empty</v-icon> Delete
                                        </v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                            <v-btn @click="dataModalDialog = false,resetForm()" color="red lighten-1 white--text" small
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
                                    <v-text-field v-model="form.name" label="Enter Operation Name" :rules="operationRules" required></v-text-field>
                                </v-col>

                            </v-row>

                            <v-btn v-show="editmode" type="submit" block depressed :loading="addNetworklLoader" color="primary"><v-icon>mdi-edit</v-icon> Update</v-btn>
                            <v-btn v-show="!editmode" type="submit" block depressed :loading="addNetworklLoader" color="primary"><v-icon>mdi-save</v-icon> Create</v-btn>
                            

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

                // v-form
                valid:false,
                // dialog
                dataModalDialog:false,

                // loader
                addNetworklLoader:false,

                operationRules:[v => !!v || 'This field is required!'],


                //current page url

                currentUrl: '/inventory/admin/operation',

              
                // Form
                form: new Form({
                    id: '',
                    name: ''

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