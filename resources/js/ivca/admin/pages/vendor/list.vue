<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Vendor List</h3>
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
                                <th>Action</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('vendor_number')">Vendor number</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'Vendor Number'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'vendor_number'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('suppier_name')">Vendor Name</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'suppier_name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'suppier_name'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('address')">Address</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'address'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'address'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('contact_name')">Contact Name</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'contact_name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'contact_name'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('email')">Email</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'email'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'email'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('telephone')">Telephone</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'telephone'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'telephone'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('blocked')">Status</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'blocked'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'blocked'">&darr;</span>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td class="text-center">
                                    <!-- v-if="isAdmin()" -->
                                    <div >
                                        <v-btn v-if="singleData.status" @click="statusChange(singleData)" small
                                            color="success" elevation="10" class="mb-1">
                                            <v-icon left>mdi-check-decagram</v-icon> Activated
                                        </v-btn>
                                        <v-btn v-else @click="statusChange(singleData)" small color="warning"
                                            elevation="10" class="mb-1">
                                            <v-icon left>mdi-close-octagon</v-icon> Inactive
                                        </v-btn>
                                    </div>
                                    <v-btn @click="editDataModel(singleData)" small color="info" elevation="10"
                                        class="mb-1">
                                        <v-icon left>mdi-circle-edit-outline</v-icon> Modify
                                    </v-btn>
                                </td>
                                <td>{{ singleData.vendor_number }}</td>
                                <td>{{ singleData.suppier_name }}</td>
                                <td>{{ singleData.address }}</td>
                                <td>{{ singleData.contact_name }}</td>
                                <td>{{ singleData.email }}</td>
                                <td>{{ singleData.telephone }}</td>
                                <td><span v-if="singleData.blocked == 1" class="text-danger">Blocked</span> <span v-else
                                        class="text-success">Active</span></td>

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
                        <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </div>
        </div>


        <v-dialog v-model="dataModalDilog">

            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            {{dataModelTitle}}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDilog = false" color="red lighten-1" small text class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>

                <v-card-text>

                    <v-form v-model="valid">
                        <form @submit.prevent="editmode ? updateData() : createData()">

                            <v-text-field v-model="form.vendor_number" label="Enter vendor number"
                                :rules="[v => !!v || 'Vendor Number is required!']" required :readonly="editmode">
                            </v-text-field>
                            <div class="small text-danger" v-if="form.errors.has('vendor_number')"
                                v-html="form.errors.get('vendor_number')" />

                            <v-text-field v-model="form.suppier_name" label="Enter Supplier Name"
                                :rules="[v => !!v || 'Supplier Name is required!']" required>
                            </v-text-field>
                            <div class="small text-danger" v-if="form.errors.has('suppier_name')"
                                v-html="form.errors.get('suppier_name')" />

                            <v-textarea v-model="form.address" outlined rows="3" label="Enter Vendor Address"
                                :rules="[v => !!v || 'Vendor Address is required!']" required>
                            </v-textarea>
                            <div class="small text-danger" v-if="form.errors.has('address')"
                                v-html="form.errors.get('address')" />

                            <v-text-field v-model="form.contact_name" label="Enter Conatct Name"
                                :rules="[v => !!v || 'Contact Name is required!']" required>
                            </v-text-field>
                            <div class="small text-danger" v-if="form.errors.has('contact_name')"
                                v-html="form.errors.get('contact_name')" />

                            <v-text-field v-model="form.email" label="Enter Email">
                            </v-text-field>
                            <div class="small text-danger" v-if="form.errors.has('email')"
                                v-html="form.errors.get('email')" />

                            <v-text-field v-model="form.telephone" label="Telephone / Contact:"
                                :rules="[v => !!v || 'Telephone / Contact is required!']" required>
                            </v-text-field>
                            <div class="small text-danger" v-if="form.errors.has('telephone')"
                                v-html="form.errors.get('telephone')" />


                            <v-btn block blockdepressed :loading="modalBtnLoading" color="primary mt-3" type="submit">
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

                //current page url
                currentUrl: '/ivca/admin/vendor/list',


                // Form
                form: new Form({
                    id: '',
                    vendor_number: '',
                    suppier_name: '',
                    address: '',
                    contact_name: '',
                    email: '',
                    telephone: '',
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
