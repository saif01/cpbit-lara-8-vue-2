<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Category List
                    </v-col>
                    <v-col cols="2">
                        <v-btn @click="addDataModel()" color="primary" small outlined class="float-right">
                            <v-icon left dark>mdi-plus-circle-outline </v-icon> Add
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
                                <th>
                                    <a href="#" @click.prevent="change_sort('name')">Name</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('label')">Label</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'label'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'label'">&darr;</span>
                                </th>
                                <th>Accessories</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">

                                <td>{{ singleData.name }}</td>
                                <td>
                                    <span v-if="singleData.label">{{ singleData.label }}</span>
                                    <span v-else class="error--text">Not Mentioned</span>
                                </td>

                                <td>
                                    <span v-if="singleData.acsosoris.length">
                                        <span v-for="(item, index) in singleData.acsosoris" :key="index">
                                            <span class="p-1 m-1 rounded-pill small">{{ item.name }}, </span>
                                        </span>
                                    </span>
                                    <span v-else>
                                        <span class="text-danger">Not Mentioned</span>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <v-btn @click="editDataModel(singleData)" color="info" depressed small>
                                        <v-icon small>mdi-pencil-box-multiple-outline</v-icon> Edit
                                    </v-btn>

                                    <v-btn @click="deleteData(singleData.id)" color="error" depressed small>
                                        <v-icon small>mdi-delete-empty</v-icon> Delete
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
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin
                            </v-icon>
                        </p>
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
                    <v-form ref="form"
      v-model="valid"
      lazy-validation
       @submit.prevent="editmode ? updateData() : createData()">
                        <!-- <form @submit.prevent="editmode ? updateData() : createData()"> -->

                            <v-row align-content="center">
                                <v-col md="12">
                                    <v-text-field v-model="form.name" label="Enter Category Name" :rules="namRules"
                                        counter="100" placeholder="Enter Category Name" required></v-text-field>
                                    <div class="text-danger" v-if="form.errors.has('name')"
                                        v-html="form.errors.get('name')" />
                                </v-col>
                                <v-col md="12">
                                    <v-text-field v-model="form.label" label="Dependent label Name" :rules="namRules"
                                        counter="100" placeholder="Enter category dependent label Name"></v-text-field>
                                    <div class="text-danger" v-if="form.errors.has('label')"
                                        v-html="form.errors.get('label')" />
                                </v-col>

                            </v-row>

                            <v-col cols="12">
                                <v-input hide-details>Accessories :</v-input>
                                <div class="d-flex flex-wrap align-center">
                                    <div v-for="(item, index) in allAcsosoris" :key="index">
                                        <v-checkbox class="mr-5" :value="item.id" :label="item.name"
                                            v-model="currentAcsosoris" color="indigo" hide-details></v-checkbox>
                                    </div>
                                </div>
                            </v-col>

                            <v-row class="mt-5">
                                <v-btn v-show="editmode" type="submit" block depressed :loading="dataModalLoading"
                                    color="primary">
                                    <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                                </v-btn>
                                <v-btn v-show="!editmode" type="submit" block depressed :loading="dataModalLoading"
                                    color="primary">
                                    <v-icon left dark>mdi-shape-polygon-plus</v-icon> Create
                                </v-btn>
                            </v-row>


                        <!-- </form> -->
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
                currentUrl: '/cms/h_admin/category',

                reqRules: [v => !!v || 'This field is required!'],
                codeRules: [v => !!v || 'This field is required!',
                    v => (v && v.length <= 2) || 'Code must be less than 2 numbers'
                ],
                namRules: [
                    v => (v || '').length <= 100 || 'Description must be 100 characters or less',
                    v => (v || '').length >= 2 || '2 chars minimum or more',
                ],

                allAcsosoris: [],
                currentAcsosoris: [],

                // Form
                form: new Form({
                    id: '',
                    name: '',
                    label: '',
                    acsosoris: '',
                }),

                valid: false,

            }


        },

        methods: {

            // getAllAcsosoris
            getAllAcsosoris() {
                axios.get(this.currentUrl + '/acsosoris').then(response => {
                    this.allAcsosoris = response.data
                    //console.log(response.data)
                    // for (let i = 0; i < response.data.length; i++) {
                    //     this.allAcsosoris.push(response.data[i]);
                    //     this.allAcsosoris[i] = {value: response.data[i].id, text: response.data[i].name };
                    // }
                }).catch(error => {
                    console.log(error)
                })
            },

            // Create Data
            async createData() {

                this.form.acsosoris = this.currentAcsosoris

                //console.log('Form submited');
                this.$Progress.start()
                // request send and get response
                const response = await this.form.post(this.currentUrl + '/store' + '');
                // Input field make empty
                this.form.reset();
                this.form.errors.clear();
                this.$refs.form.reset()
                this.$refs.form.resetValidation()
                
                // Hide model
                //this.$refs['data-modal'].hide();
                this.dataModalDialog = false;
                // Refresh Tbl Data with current page
                this.getResults(this.currentPageNumber);
                this.$Progress.finish();

                if (response.status == 200) {
                    Toast.fire({
                        icon: response.data.icon,
                        title: response.data.msg
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong<br>' + data.message,
                        customClass: 'text-danger'
                    });
                    // Swal.fire("Failed!", data.message, "warning");
                    console.log(response);
                }

            },


            // Edit Data Modal
            editDataModel(singleData) {
                this.editmode = true;
                this.dataModelTitle = 'Update Data'
                this.form.reset();
                this.form.errors.clear();
                //this.$refs.form.reset()
                //this.form.resetValidation()
                this.form.fill(singleData);

                this.currentAcsosoris = []
                // role found then push in arry
                singleData.acsosoris.forEach(element => {
                    // console.log('loop', element.id)
                    this.currentAcsosoris.push(element.id)
                })

                this.dataModalDialog = true;
            },


            // Update data
            async updateData() {

                this.form.acsosoris = ''
                this.form.acsosoris = this.currentAcsosoris
                //console.log('Edit Form submited', this.form.id);
                this.$Progress.start();
                // request send and get response
                const response = await this.form.put(this.currentUrl + '/update/' + this.form.id);
                // Input field make empty
                this.form.reset();
                this.$refs.form.resetValidation()

                this.addRoomsLoader = false
                // Hide model
                //this.$refs['data-modal'].hide();
                this.dataModalDialog = false;
                // Refresh Tbl Data with current page
                this.getResults(this.currentPageNumber);
                this.$Progress.finish();

                if (response.status == 200) {
                    Toast.fire({
                        icon: response.data.icon,
                        title: response.data.msg
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong<br>' + data.message,
                        customClass: 'text-danger'
                    });
                    // Swal.fire("Failed!", data.message, "warning");
                    console.log(response);
                }

            },


            

        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.getAllAcsosoris();
            this.$Progress.finish();
        },



    }

</script>
