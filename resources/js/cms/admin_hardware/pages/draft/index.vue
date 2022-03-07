<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Draft List</h3>
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
                                    <a href="#" @click.prevent="change_sort('id')">ID</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'id'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'id'">&darr;</span>

                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('name')">Name</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('details')">Details</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'details'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'details'">&darr;</span>
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>{{ singleData.id }}</td>
                                <td>{{ singleData.name }}</td>
                                <td v-html="singleData.details" ></td>

                                <td class="text-center">
                                    <v-btn v-if="singleData.status" @click="statusChange(singleData)" small
                                        color="primary" elevation="10" class="mb-1">
                                        <v-icon left>mdi-check-decagram</v-icon> Active
                                    </v-btn>
                                    <v-btn v-else @click="statusChange(singleData)" small color="warning"
                                        elevation="10" class="mb-1">
                                        <v-icon left>mdi-close-octagon</v-icon> Inactive
                                    </v-btn>

                                    <v-btn @click="editDataModel(singleData)" small color="info" elevation="10" class="mb-1">
                                        <v-icon left>mdi-circle-edit-outline</v-icon> Edit
                                    </v-btn>

                                    <v-btn @click="deleteData(singleData.id)" small color="error" elevation="10" class="mb-1">
                                        <v-icon left>mdi-close-octagon</v-icon> Delete
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
                        <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </div>
        </div>

        <!-- Dilog  -->
        <v-dialog v-model="dataModalDialog" persistent >
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            {{ dataModelTitle }}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialog = false, resetForm()" color="red lighten-1" small text class="float-right">
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
                                    <v-text-field type="text" label="Draft Name:"
                                        :rules="nameRule" counter="50" v-model="form.name" required>
                                    </v-text-field>
                                    <div class="text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                                </v-col>

                                <!-- Details -->
                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('details')" v-html="form.errors.get('details')" />
                                   
                                    <label>Details :</label>
                                    <vue-editor :class="{ error_bg: (form.details && ( form.details.length <= 10 || form.details.length >= 20000 )) }" v-model="form.details" :editorToolbar="customToolbar"></vue-editor>
                                    <v-row>
                                        <v-col cols="10">
                                            <span v-if="(form.details && form.details.length <= 10)" class="small text-danger" >10 chars minimum or more.</span>
                                            <span v-if="(form.details && form.details.length >= 20000)" class="small text-danger" >Description must be 20,000 characters or less.</span>
                                        </v-col>
                                        <v-col cols="2" >
                                            <span class="float-right">{{ form.details.length }}/ 20,000</span>
                                        </v-col>
                                    </v-row>
                                    
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
    import {
        VueEditor
    } from "vue2-editor";
    import vue2EditorToolbar from "./../complain/action/js/vue2_editor_toolbar"



    export default {

        components: {
            VueEditor
        },

        data() {

            return {

                //current page url
                currentUrl: '/cms/h_admin/draft',

                // Custom Toolbar for vue2 text editor
                ...vue2EditorToolbar,

                nameRule: [v => !!v || 'Name is required!',
                 v => (v && v.length <= 50) || 'Name must be less than 50 characters'],

                remRules:[
                    v => (v || '' ).length <= 20000 || 'Description must be 20,000 characters or less',
                    v => (v || '' ).length >= 10 || '10 chars minimum or more',
                ],


                // Form
                form: new Form({
                    id: '',
                    name: '',
                    details: '',
                }),

            }


        },

        methods: {



        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
        },



    }

</script>
