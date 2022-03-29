<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        Old Product List
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
                        <v-col lg="2" cols="4">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="2" cols="4">
                            <!-- business_unit -->
                            <v-select v-model="businessUnit" label="Business Unit:" :items="b_unit" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="2" cols="4">
                            <!-- search_type -->
                            <v-select v-model="search_type" label="Product type:" :items="search_by_type" item-text="text"
                                item-value="value" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="2" cols="6">
                            <!-- search_field -->
                            <v-select v-model="search_field" label="Search By:" :items="customSrcByFields" item-text="text"
                                item-value="value" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="4" cols="6">
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

                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th class="col-2">
                                    Action
                                </th>
                                <th class="col-10">
                                    Details
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td class="text-center">

                                    <v-btn class="m-1" @click="editDataModel(singleData)" color="info" elevation="20" small>
                                        <v-icon small>mdi-circle-edit-outline</v-icon> Edit
                                    </v-btn>

                                    <v-btn class="ma-1" @click="deleteDataTemp(singleData.id)" color="error" elevation="20" small>
                                        <v-icon small>mdi-delete-empty</v-icon> Delete
                                    </v-btn>

                                    <v-btn class="ma-2" @click="view(singleData)" color="teal" elevation="20" small>
                                        <v-icon small>mdi-eye</v-icon> View
                                    </v-btn>
                                    <br>
                                    <span class="text-muted small">Create By-- </span><v-btn x-small dense v-if="singleData.makby" @click="currentUserView(singleData.makby)">{{ singleData.makby.name }}</v-btn>
                                </td>
                                <td>
                                    <v-row>
                                        <v-col>

                                            <div>
                                                <b>Product Name or Model: </b> <span v-if="singleData.name">{{ singleData.name }}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            <div>
                                                <b>Product Category: </b> <span v-if="singleData.category">{{ singleData.category.name }}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            <div>
                                                <b>Product Subcategory: </b> <span v-if="singleData.subcategory">{{ singleData.subcategory.name }}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            <div>
                                                <b>Product Serial: </b> <span v-if="singleData.serial">{{ singleData.serial }}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            <div>
                                                <b>Invoice Number: </b> <span v-if="singleData.invoice_num">{{ singleData.invoice_num }}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            <div>
                                                <b>Request Payment Number: </b> <span v-if="singleData.req_payment_num">{{ singleData.req_payment_num }}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>

                                        </v-col>
                                        <v-col>

                                            <div>
                                                <b>Business Unit: </b> <span v-if="singleData.business_unit">{{ singleData.business_unit }}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            <div>
                                                <b>Operation: </b> <span v-if="singleData.operation">{{ singleData.operation.name }}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            <div>
                                                <b>Office: </b> <span v-if="singleData.office">{{ singleData.office }}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            <div>
                                                <b>Created Date : </b> <span v-if="singleData.created_at">{{ singleData.created_at | moment("MMM Do YYYY, h:mm a") }}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>
                                            <div>
                                                <b>Bill Submit Date : </b> <span v-if="singleData.bill_submit">{{ singleData.bill_submit | moment("MMMM Do YYYY") }}</span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>

                                            <div>
                                                <b>Remarks : </b> <span v-if="singleData.remarks" v-html="singleData.remarks"></span>
                                                <span v-else class="error--text">N/A</span>
                                            </div>

                                        </v-col>
                                    </v-row>
                                    
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
                                    <div class="small text-danger" v-if="form.errors.has('category')"
                                        v-html="form.errors.get('category')" />
                                    <v-autocomplete :items="allCategory" @change="getSubcategory
                                    ()" v-model="form.cat_id" label="Select Category"
                                        :rules="[v => !!v || 'Category is required!']" dense required>
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('subcategory')"
                                        v-html="form.errors.get('subcategory')" />
                                    <v-autocomplete :items="allSubcategory" v-model="form.subcat_id"
                                        label="Select Subcategory" :rules="[v => !!v || 'Subcategory is required!']"
                                        dense  required></v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('operation_id')"
                                        v-html="form.errors.get('operation_id')" />
                                    <v-autocomplete :items="operation" v-model="form.operation_id"
                                        label="Select Operation" :rules="[v => !!v || 'Operation is required!']"
                                        dense  required></v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('business_unit')"
                                        v-html="form.errors.get('business_unit')" />
                                    <v-autocomplete :items="business_unit" v-model="form.business_unit"
                                        label="Select Business Unit" :rules="[v => !!v || 'Business Unit is required!']"
                                        dense  required></v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('office')"
                                        v-html="form.errors.get('office')" />
                                    <v-autocomplete :items="allOffice" v-model="form.office"
                                        label="Select Office Name" :rules="[v => !!v || 'Office is required!']"
                                        dense  required></v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('type')"
                                        v-html="form.errors.get('type')" />
                                    <v-autocomplete :items="type" v-model="form.type"
                                        label="Select Product Type" :rules="[v => !!v || 'Product Type is required!']"
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
                                    <div class="small text-danger" v-if="form.errors.has('serial')"
                                        v-html="form.errors.get('serial')" />
                                    <v-text-field v-model="form.serial" label="Serial number"
                                        :rules="[v => !!v || 'erail Number is required!']"
                                        placeholder="Enter Serial number" dense required>
                                    </v-text-field>
                                </v-col>

                                  <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('invoice_num')"
                                        v-html="form.errors.get('invoice_num')" />
                                    <v-text-field v-model="form.invoice_num" label="Invoice Number"
                                        placeholder="Enter invoice number" dense >
                                    </v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('bill_submit')"
                                        v-html="form.errors.get('bill_submit')" />
                                    <!-- Date Picker -->
                                    <v-menu ref="menu" v-model="menu" :close-on-content-click="false"
                                        :return-value.sync="date" offset-y min-width="auto" dense>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.bill_submit" label="Bill Submit Date"  prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" dense >
                                            </v-text-field>
                                        </template>
                                        <v-date-picker v-model="form.bill_submit" scrollable  dense>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu = false">
                                                Cancel</v-btn>
                                            <v-btn text color="primary" @click="$refs.menu.save(date)">
                                                OK </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('req_payment_num')"
                                        v-html="form.errors.get('req_payment_num')" />
                                    <v-text-field v-model="form.req_payment_num" label="Request Payment Number"
                                        placeholder="Enter request payment number" dense >
                                    </v-text-field>
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





        <!-- view product -->
        <view-product v-if="currentData" :currentData="currentData" :category="currentCategory" :subcategory="currentSubcategory" :operation="currentOperation" :key="leaveActionKey" ></view-product>

        


    </div>

</template>


<script>
    // vform
    import Form from 'vform';
    import viewProduct from './../viewData.vue'

    import {
        VueEditor
    } from "vue2-editor";
    import vue2EditorToolbar from "./../../pages/common/js/vue2_editor_toolbar"


    import userTblData from './../../../../super_admin/pages/users/js/data'
    import userTblMethods from './../../../../super_admin/pages/users/js/methods'

    // User Details Show By Dialog
    import userDetails from './../../../../super_admin/pages/users/details/user_details.vue'
    import userDetailsData from './../../../../super_admin/pages/users/details/js/data'
    import userDetailsMethods from './../../../../super_admin/pages/users/details/js/methods'



    export default {

        components: {
            VueEditor,
            "view-product":viewProduct,
            'user-details': userDetails,
        },

        data() {

            return {

                //current page url
                currentUrl: '/inventory/admin/old_product',


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

                // modal  for view data
                viewModal:false,
               

                allCategory: [],
                allSubcategory: [],
                allOffice: [],
                business_unit: [],
                operation: [],
                b_unit:[],


                allCatData:'',


                // Form
                form: new Form({
                    id: '',
                    cat_id: '',
                    subcat_id: '',
                    serial: '',
                    name: '',
                    remarks: '',
                    operation_id: '',
                    business_unit: '',
                    office: '',
                    type: '',
                    rec_name: '',
                    rec_contact: '',
                    rec_position: '',
                    invoice_num: '',
                    bill_submit: '',
                    req_payment_num: '',

                }),

                customSrcByFields:[
                    {
                        value: 'All',
                        text: 'All'
                    },
                    {
                        value: 'invoice_num',
                        text: 'Invoice Number'
                    },
                    {
                        value: 'req_payment_num',
                        text: 'Request Payment Number'
                    },
                    {
                        value: 'serial',
                        text: 'Serial'
                    },
                    {
                        value: 'cat_id',
                        text: 'Category'
                    },
                    {
                        value: 'subcat_id',
                        text: 'Subcategory'
                    },
                    {
                        value: 'name',
                        text: 'Name'
                    },
                    {
                        value: 'operation',
                        text: 'Operation'
                    },
                    // {
                    //     value: 'business_unit',
                    //     text: 'Business Unit'
                    // },
                    {
                        value: 'office',
                        text: 'Office'
                    },
                    // {
                    //     value: 'Running',
                    //     text: 'Running Product'
                    // },
                    // {
                    //     value: 'Damaged',
                    //     text: 'Damaged Product'
                    // },
                    {
                        value: 'rec_name',
                        text: 'Receiver Name'
                    },
                    {
                        value: 'rec_position',
                        text: 'Receiver Position'
                    },
                    
                ],



                // type
                type: [
                    {
                        value: 'Running',
                        text: 'Running Product'
                    },
                    {
                        value: 'Damaged',
                        text: 'Damaged Product'
                    },
                ],


                // search_by_type
                search_by_type: [
                    {
                        value: 'All',
                        text: 'All'
                    },
                    {
                        value: 'Running',
                        text: 'Running Product'
                    },
                    {
                        value: 'Damaged',
                        text: 'Damaged Product'
                    },
                ],


                // view details
                currentData: '',
                leaveActionKey:0,
                currentCategory:'',
                currentSubcategory:'',
                currentOperation:'',



                // userTblData
                ...userTblData,

                // Current User Show By Dilog
                ...userDetailsData,

                // businessUnit for sort
                businessUnit: '',

                // search_type
                search_type: '',

                

            }


        },

        methods: {

            // userTblMethods
            //...userTblMethods,

            // getAllCategory
            getAllCategory() {
                axios.get('/inventory/admin/category').then(response => {
                    this.allCatData = response.data
                    //console.log(response.data)
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


            // getOffice
            getOffice() {
                axios.get(this.currentUrl+'/office').then(response => {
                    console.log(response.data);
                    // business_unit
                    response.data.office.forEach(element => {
                        this.allOffice.push({
                            value: element.department,
                            text: element.department
                        });
                        //console.log('getOffice',  this.allOffice, element);
                    });

                    // business_unit
                    response.data.business_unit.forEach(element => {
                        this.business_unit.push({
                            value: element.business_unit,
                            text: element.business_unit
                        }) ;
                        //console.log('business_unit',  this.allOffice, element);
                    });

                    // operation
                    response.data.operation.forEach(element => {
                        this.operation.push({
                            value: element.id,
                            text: element.name
                        }) ;
                        //console.log('operation',  this.allOffice, element);
                    });

                }).catch(error => {
                    console.log(error)
                })
            },


            // getBusinessUnitOldProductTable
            getBunit() {
                axios.get(this.currentUrl+'/business_unit').then(response => {
                    
                    // business_unit
                    response.data.forEach(element => {
                        this.b_unit.push({
                            value: element.business_unit,
                            text: element.business_unit
                        }) ;
                        //console.log('business_unit',  this.allOffice, element);
                    });

                }).catch(error => {
                    console.log(error)
                })
            },

            // Edit Data Modal
            editDataModel(singleData){
                
                this.editmode       = true;
                this.dataModelTitle = 'Update Data'
                this.form.fill(singleData);

                if(singleData.remarks === null){
                    this.form.remarks = '';
                }
                // Subcategory
                this.getSubcategory()
                this.dataModalDialog = true;
            },

            // view
            view(data){
                if(data.category){
                    this.currentCategory = data.category.name
                }
                if(data.subcategory){
                    this.currentSubcategory = data.subcategory.name
                }
                if(data.operation){
                    this.currentOperation = data.operation.name
                }
                
                this.leaveActionKey++
                this.currentData = data
            },

            // Get table data
            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl+'/index?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field +
                        '&business_unit=' + this.businessUnit +
                        '&search_type=' + this.search_type
                    )
                    .then(response => {
                        //console.log(response.data.data);
                        //console.log(response.data.from, response.data.to, response.data.current_page);
                        this.allData = response.data;
                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;
                        this.currentPageNumber  = response.data.current_page
                        // Loading Animation
                        this.dataLoading = false;

                    });
            },



            // CurrentUserData
            ...userDetailsMethods,



        },


        watch:{
            //Excuted When make change value 
            businessUnit: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },

            //Excuted When make change value 
            search_type: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },
        },

        mounted(){
            this.getOffice();
            this.getAllCategory();
            this.getBunit();
        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();

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
