<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Software Module List
                    </v-col>
                    <v-col cols="2">
                        <v-btn @click="addDataModel()" color="primary" elevation="10" small outlined class="float-right">
                            <v-icon left>mdi-card-plus</v-icon> Add
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text class="table-responsive">
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
                            <tr>
                                <th>Software</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('name')">Module</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                               
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">

                                <td><span v-if="singleData.category">{{ singleData.category.name }}</span></td>
                                <td>{{ singleData.name }}</td>
                               
                                <td class="text-center">
                                    <v-btn @click="editDataModel(singleData)" color="info" depressed small>
                                        <v-icon left>mdi-circle-edit-outline</v-icon> Edit
                                    </v-btn>

                                    <v-btn @click="deleteData(singleData.id)" color="error" depressed small>
                                        <v-icon left>mdi-delete-empty</v-icon> Delete
                                    </v-btn>
                                    <br>
                                    <span v-if="singleData.makby" class="small text-muted">Create By--
                                        {{ singleData.makby.name }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span>Total Records: {{ totalValue }}</span>
                    </div>
                    <pagination :data="allData" :limit="3" @pagination-change-page="getResults"
                        class="justify-content-end">
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
        <v-dialog v-model="dataModalDialog" max-width="700px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            {{dataModelTitle}}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialog = false" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-form v-model="valid" ref="form">
                        <form @submit.prevent="editmode ? updateData() : createData()">

                            <v-row align-content="center">
                                <v-col md="12">
                                    <div class="small text-danger" v-if="form.errors.has('cat_id')" v-html="form.errors.get('cat_id')" />
                                    <v-autocomplete dense solo :items="allCategory" v-model="form.cat_id" label="Select Software" :rules="[v => !!v || 'Software name is required!']" required></v-autocomplete>
                                </v-col>
                                <v-col md="12">
                                    <div class="text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                                    <v-text-field v-model="form.name" label="Enter Module Name" :rules="[ v=> !!v || 'Module name is required!']"
                                        required></v-text-field>
                                </v-col>
                            </v-row>

                           
                            <v-btn v-show="editmode" type="submit" block depressed :loading="dataModalLoading"
                                color="primary">
                                <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                            </v-btn>
                            <v-btn v-show="!editmode" type="submit" block depressed :loading="dataModalLoading"
                                color="primary">
                                <v-icon left dark>mdi-shape-polygon-plus</v-icon> Create
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

                reqRules:[v => !!v || 'This field is required!'],
                codeRules: [v => !!v || 'This field is required!',
                            v => (v && v.length == 2) || 'Code must be less than 2 numbers'
                            ],

               
                //current page url
                currentUrl: '/cms/a_admin/subcategory',

                allCategory:[],


                // Form
                form: new Form({
                    id: '',
                    cat_id: '',
                    name: '',
                }),

            }


        },

        methods: {

            getAllCategory(){
                axios.get( this.currentUrl + '/category').then( response=>{
                    //this.allCategory = response.data
                    //console.log(response.data)
                    for (let i = 0; i < response.data.length; i++) {
                        this.allCategory.push(response.data[i]);
                        this.allCategory[i] = {value: response.data[i].id, text: response.data[i].name };
                    }
                }).catch(error=>{
                    console.log(error)
                })
            }



        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();

            this.getAllCategory();
        },



    }

</script>


