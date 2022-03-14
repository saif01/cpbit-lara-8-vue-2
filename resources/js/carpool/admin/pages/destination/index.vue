<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Destinations Name
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
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" small>
                            </v-select>
                        </v-col>

                        <v-col cols="10">
                            <v-text-field prepend-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                                placeholder="Search Input..."></v-text-field>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered">
                        <thead class="text-center">
                            <th>
                                <a href="#" @click.prevent="change_sort('name')">Destinations</a>
                                <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                            </th>
                            <th>
                                <a href="#" @click.prevent="change_sort('')">Created by</a>
                                <span v-if="sort_direction == 'desc' && sort_field == ''">&uarr;</span>
                                <span v-if="sort_direction == 'asc' && sort_field == ''">&darr;</span>
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
                                    <v-btn @click="deleteDataTemp(singleData.id)" color="error" depressed small>
                                        <v-icon small>mdi-delete-empty</v-icon> Delete
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
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </v-card-text>
        </v-card>





        <!-- Modal -->
        <v-dialog v-model="dataModalDialog" max-width="600px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            <span v-if="editmode">Update Destination</span>
                            <span v-else>Add New Destination</span>
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
                                    <v-text-field v-model="form.name" label="Enter Destinations Name" :rules="destinationRules" required></v-text-field>
                                </v-col>

                            </v-row>

                            <v-btn v-show="editmode" type="submit" block depressed :loading="addCarpoolLoader" color="primary"><v-icon>mdi-edit</v-icon> Update</v-btn>
                            <v-btn v-show="!editmode" type="submit" block depressed :loading="addCarpoolLoader" color="primary"><v-icon>mdi-save</v-icon> Create</v-btn>
                            

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
                addCarpoolLoader:false,

                destinationRules:[v => !!v || 'This field is required!'],


                //current page url

                currentUrl: '/carpool/admin/destination',

              
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