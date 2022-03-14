<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        New Product List
                    </v-col>
                    <v-col cols="2">
                        <v-btn @click="addDataModel()" color="primary" elevation="20" small outlined class="float-right">
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
                            <tr>
                                <th>
                                    Action
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('name')">Name/Model</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('serial')">Serial</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'serial'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'serial'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('remarks')">Remarks</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'remarks'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'remarks'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('document')">Document</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'document'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'document'">&darr;</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td class="text-center">

                                    <v-btn @click="editDataModel(singleData)" color="info" elevation="20" small>
                                        <v-icon small>mdi-circle-edit-outline</v-icon> Edit
                                    </v-btn>

                                    <v-btn @click="deleteDataTemp(singleData.id)" color="error" elevation="20" small>
                                        <v-icon small>mdi-delete-empty</v-icon> Delete
                                    </v-btn>
                                    <br>
                                    <span v-if="singleData.makby" class="small text-muted">Create By--
                                        {{ singleData.makby.name }}</span>
                                </td>
                                <td>{{ singleData.name }}</td>
                                <td><span v-if="singleData.category">{{ singleData.category.name }}</span></td>
                                <td><span v-if="singleData.subcategory">{{ singleData.subcategory.name }}</span></td>
                                <td>{{ singleData.serial }}</td>
                                <td v-html="singleData.remarks"></td>
                                <td>
                                    <a v-if="singleData.document" :href="'/images/inventory/'+singleData.document"
                                        class="btn btn-info btn-sm text-white" download>
                                        <v-icon color="white">mdi-download-network-outline</v-icon> Document
                                    </a>
                                    <span v-else class="text-danger">Not Attached</span>
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
        <v-dialog persistent v-model="dataModalDialog" >
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
                    <v-form v-model="valid" ref="form" >
                        <form @submit.prevent="editmode ? updateData() : createData()">

                            <v-row align-content="center">

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('cat_id')"
                                        v-html="form.errors.get('cat_id')" />
                                    <v-autocomplete :items="allCategory" @change="getSubcategory
                                    ()" v-model="form.cat_id" label="Select Category"
                                        :rules="[v => !!v || 'Category is required!']" dense required>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('subcat_id')"
                                        v-html="form.errors.get('subcat_id')" />
                                    <v-autocomplete :items="allSubcategory" v-model="form.subcat_id"
                                        label="Select Subcategory" :rules="[v => !!v || 'Subcategory is required!']"
                                        dense  required></v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('name')"
                                        v-html="form.errors.get('name')" />
                                    <v-text-field v-model="form.name" label="Product Name or Model"
                                        :rules="[v => !!v || 'Product Name or Model is required!']"
                                        placeholder="Enter Product Product Name or Model" dense  required>
                                    </v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('po_number')"
                                        v-html="form.errors.get('po_number')" />
                                    <v-text-field v-model="form.po_number" label="Product order (P.O.) number"
                                        :rules="[v => !!v || 'P.O. is required!']"
                                        placeholder="Enter Product order (P.O.) number" dense required>
                                    </v-text-field>
                                </v-col>


                                <!-- Document -->
                                <v-col cols="12" lg="4">
                                    <v-file-input @change="uploadDocByName($event, 'document')" show-size 
                                        label="Document" accept="image/*, .pdf, .xlsx, .docx" :rules="docRules"  
                                        dense>
                                        <template slot="append" v-if="editmode">
                                            <span v-if="form.document" class="success"><v-icon color="success">mdi-folder-check-outline</v-icon> Yes</span>
                                            <span v-else class="text-danger"><v-icon color="error">mdi-close-octagon</v-icon> No</span>
                                        </template>
                                        </v-file-input>
                                </v-col>

                                <!-- <v-col cols="12" lg="4">
                                    <v-file-input @change="uploadDocByName($event, 'document')" show-size 
                                        label="Document" accept="image/*, .pdf, .xlsx, .docx" :rules="docRules"
                                        dense>
                                    </v-file-input>
                                </v-col> -->

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('purchase')"
                                        v-html="form.errors.get('purchase')" />
                                    <!-- Date Picker -->
                                    <v-menu ref="menu" v-model="menu" :close-on-content-click="false"
                                        :return-value.sync="date" offset-y min-width="auto"  dense>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.purchase" label="Report Date"
                                                prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" required
                                                 dense :rules="[v => !!v || 'Report Date is required!']">
                                            </v-text-field>
                                        </template>
                                        <v-date-picker v-model="form.purchase" scrollable  dense>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu = false">
                                                Cancel</v-btn>
                                            <v-btn text color="primary" @click="$refs.menu.save(date)">
                                                OK </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('serial')"
                                        v-html="form.errors.get('serial')" />
                                    <v-text-field v-model="form.serial" label="Serial Number"
                                        :rules="[v => !!v || 'Serial number is required!']"
                                        placeholder="Enter Product Serial number" dense  required>
                                    </v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <!-- {{ warranty }} -->
                                    <v-radio-group label="Warranty Status" v-model="warranty" row
                                        :rules="[v => !!v || 'Warranty is required!']" dense required>
                                        <v-radio label="Yes" value="y" color="success"></v-radio>
                                        <v-radio label="No" value="n" color="error"></v-radio>
                                    </v-radio-group>
                                </v-col>

                                <v-col cols="12" lg="4" v-if="warranty == 'y'">
                                    <v-row>
                                        <v-col cols="6">
                                            <v-select v-model="warranty_type" :items="[{text:'Month', value: 'month'}, {text:'Year', value: 'year'}]"
                                                label="Select Month or Year" dense ></v-select>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-text-field type="number" v-model="warranty_type_data" label="Number Month or Year"
                                                :rules="[v => !!v || 'Number is required!']"
                                                placeholder="Number Month or Year" dense  >
                                            </v-text-field>
                                        </v-col>
                                    </v-row>

                                </v-col>




                                <!-- Details -->
                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('remarks')"
                                        v-html="form.errors.get('remarks')" />
                                    <label>Details :</label>
                                    <vue-editor
                                        :class="{ error_bg: (form.remarks && ( form.remarks.length <= 10 || form.remarks.length >= 20000 )) }"
                                        v-model="form.remarks" :editorToolbar="customToolbar"></vue-editor>
                                    <v-row>
                                        <v-col cols="10">
                                            <span v-if="(form.remarks && form.remarks.length <= 10)"
                                                class="small text-danger">10 chars minimum or more.</span>
                                            <span v-if="(form.remarks && form.remarks.length >= 20000)"
                                                class="small text-danger">Description must be 20,000 characters or
                                                less.</span>
                                        </v-col>
                                        <v-col cols="2">
                                            <span class="float-right">{{ form.remarks.length }}/ 20,000</span>
                                        </v-col>
                                    </v-row>

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

    import {
        VueEditor
    } from "vue2-editor";
    import vue2EditorToolbar from "./../../pages/common/js/vue2_editor_toolbar"



    export default {

        components: {
            VueEditor
        },

        data() {

            return {

                //current page url
                currentUrl: '/inventory/admin/new_product',


                // timepicker
                menu: false,
                date: '',


                roomRules: [v => !!v || 'This field is required!'],

                docRules: [
                    value => !value || value.size < 2000000 || 'Document size should be less than 2 MB!',
                ],

                remRules: [
                    v => (v || '').length <= 20000 || 'Description must be 20,000 characters or less',
                    v => (v || '').length >= 10 || '10 chars minimum or more',
                ],

                // Custom Toolbar for vue2 text editor
                ...vue2EditorToolbar,

                // warranty
                warranty: 'n',
                warranty_type: 'month',
                warranty_type_data: '',

                documentAppend: '',
               

                allCategory: [],
                allSubcategory: [],
                allCatData: '',


                // Form
                form: new Form({
                    id: '',
                    cat_id: '',
                    subcat_id: '',
                    serial: '',
                    name: '',
                    remarks: '',
                    document: '',
                    purchase: '',
                    warranty: '',
                    po_number: '',

                }),

                

            }


        },

        methods: {

            // getAllCategory
            getAllCategory() {
                axios.get('/inventory/admin/category').then(response => {
                    this.allCatData = response.data
                    console.log(response.data)
                    for (let i = 0; i < response.data.length; i++) {
                        this.allCategory.push(response.data[i]);
                        this.allCategory[i] = {
                            value: response.data[i].id,
                            text: response.data[i].name
                        };
                    }
                }).catch(error => {
                    console.log(error)
                })
            },

            // getSubcategory
            getSubcategory() {
                // console.log('cat id', this.form.cat_id)

                this.allCatData.forEach(element => {
                    //console.log(element.id)

                    if (element.id == this.form.cat_id) {
                        //console.log(element)
                        this.allSubcategory = []
                        if (element.subcat.length > 0) {
                            for (let i = 0; i < element.subcat.length; i++) {
                                this.allSubcategory.push(element.subcat[i]);
                                this.allSubcategory[i] = {
                                    value: element.subcat[i].id,
                                    text: element.subcat[i].name
                                };
                            }

                        }
                    }
                })


            },

            // Create Data
            createData() {
                this.dataModalLoading = true;
                //console.log('Form submited');
                this.$Progress.start()

                // warranty Data
                if( this.warranty_type == 'month' ){
                    if( this.warranty_type_data && this.form.purchase ){
                        this.form.warranty = this.$moment(this.form.purchase).add(this.warranty_type_data, 'M').format('YYYY-MM-DD')
                        console.log('warranty-month: ', this.form.warranty )
                    }
                }
                if( this.warranty_type == 'year' ){
                    if( this.warranty_type_data && this.form.purchase ){
                        this.form.warranty = this.$moment(this.form.purchase).add(this.warranty_type_data*12, 'M').format('YYYY-MM-DD')
                        console.log('warranty-year: ', this.form.warranty )
                    }
                }

                // request send and get response
                this.form.post(this.currentUrl +'/store'+ '').then(response=>{

                    // Input field make empty
                    this.form.reset();
                    this.form.errors.clear();
                    this.resetForm();
                    this.dataModalLoading = false;
                    // Hide model
                    this.dataModalDialog = false;
                    // Refresh Tbl Data with current page
                    this.getResults(this.currentPageNumber);
                    this.$Progress.finish();

                    Toast.fire({
                        icon: response.data.icon,
                        title: response.data.msg
                    });

                }).catch(error=>{
                    this.dataModalLoading = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong',
                        customClass: 'text-danger'
                    });
                    console.log(response);
                });




                // Input field make empty
                // this.form.reset();
                // this.form.errors.clear();
                // this.resetForm();
                // this.dataModalLoading = false;
                // // Hide model
                // this.dataModalDialog = false;
                // // Refresh Tbl Data with current page
                // this.getResults(this.currentPageNumber);
                // this.$Progress.finish();

                // if (response.status == 200) {
                //     Toast.fire({
                //         icon: response.data.icon,
                //         title: response.data.msg
                //     });
                // } else {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Somthing Going Wrong',
                //         customClass: 'text-danger'
                //     });
                //     // Swal.fire("Failed!", data.message, "warning");
                //     console.log(response);
                // }

            },

            // Edit Data Modal
            editDataModel(singleData){
                
                this.editmode       = true;
                this.dataModelTitle = 'Update Data'
                //this.form.reset();
               
                // Warranty
                if(singleData.warranty){
                    this.warranty       = 'y'
                    this.warranty_type  = 'month'
                    let start           = this.$moment(singleData.warranty)
                    this.warranty_type_data = start.diff(this.$moment(singleData.purchase), 'months')
                    //console.log(this.warranty_type_data, start)
                }

                // if(singleData.document){
                //     this.documentAppend = true
                // }else{
                //     this.documentAppend = false
                // }

                
                
                this.form.fill(singleData);
                // Subcategory
                this.getSubcategory()

                this.dataModalDialog = true;
            },

            // Update data
            updateData() {
                this.dataModalLoading = true;
                //console.log('Edit Form submited', this.form.id);
                this.$Progress.start();

                // warranty Data
                if( this.warranty_type == 'month' ){
                    if( this.warranty_type_data && this.form.purchase ){
                        this.form.warranty = this.$moment(this.form.purchase).add(this.warranty_type_data, 'M').format('YYYY-MM-DD')
                        console.log('warranty-month: ', this.form.warranty )
                    }
                }
                if( this.warranty_type == 'year' ){
                    if( this.warranty_type_data && this.form.purchase ){
                        this.form.warranty = this.$moment(this.form.purchase).add(this.warranty_type_data*12, 'M').format('YYYY-MM-DD')
                        console.log('warranty-year: ', this.form.warranty )
                    }
                }

                console.log(this.form);

                // request send and get response
                this.form.put(this.currentUrl + '/update/' + this.form.id).then(response=>{

                    // Input field make empty
                    this.form.reset();
                    this.form.errors.clear();
                    this.resetForm();
                    this.dataModalLoading = false;
                    // Hide model
                    this.dataModalDialog = false;
                    // Refresh Tbl Data with current page
                    this.getResults(this.currentPageNumber);
                    this.$Progress.finish();

                    Toast.fire({
                        icon: response.data.icon,
                        title: response.data.msg
                    });

                }).catch(error=>{
                    this.dataModalLoading = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong',
                        customClass: 'text-danger'
                    });
                    console.log(response);
                });
                // Input field make empty
                // this.form.reset();
                // this.resetForm();
                // this.$Progress.start()
                // this.dataModalLoading = false;
                // // Hide model
                // this.dataModalDialog = false;
                // // Refresh Tbl Data with current page
                // this.getResults(this.currentPageNumber);
                // this.$Progress.finish();
                
                // if (response.status == 200) {
                //     Toast.fire({
                //         icon: response.data.icon,
                //         title: response.data.msg
                //     });
                // } else {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Somthing Going Wrong',
                //         customClass: 'text-danger'
                //     });
                //     // Swal.fire("Failed!", data.message, "warning");
                //     console.log(response);
                // }

            },




        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();

            this.getAllCategory();

            this.$Progress.finish();
        },



    }

</script>

<style scoped>
    .v-input--selection-controls {
        margin-top: -6px;
        padding-top: 0px;
    }
    .v-radio {
        display: inline !important;
    }

</style>
