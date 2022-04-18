<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Given Product
                    </v-col>
                    <v-col cols="2">
                        <v-btn outlined elevation="5" class="float-right" small @click="exportExcel()"
                            :loading="exportLoading">
                            <v-icon left color="success">mdi-file-excel</v-icon>
                            Export
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text>
                <div v-if="allData.data">
                    <v-row>
                        <v-col lg="2" cols="6">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="2" cols="6">
                            <!-- business_unit -->
                            <v-select v-model="businessUnit" label="Business Unit:" :items="b_unit" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="2" cols="6">
                            <!-- search_field -->
                            <v-select v-model="search_field" label="Search By:" :items="customSrcByFields"
                                item-text="text" item-value="value" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="6" cols="6">
                            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" hide-details
                                class="mb-5" outlined dense></v-text-field>
                        </v-col>
                    </v-row>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>

                                <th>File</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('name')">Product Model</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('office')">Office</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'office'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'office'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('business_unit')">Business Unit</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'business_unit'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'business_unit'">&darr;</span>
                                </th>
                                <th>Operation</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('serial')">Serial</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'serial'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'serial'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('purchase')">Purchase Date</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'purchase'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'purchase'">&darr;</span>
                                </th>
                                <th>View</th>
                            </thead>
                            <tbody>
                                <tr v-for="singleData in allData.data" :key="singleData.id">

                                    <td>
                                        <v-btn v-if="singleData.document"
                                            :href="'/images/inventory/'+singleData.document" color="info" download>
                                            <v-icon left>mdi-download-network-outline</v-icon> File
                                        </v-btn>
                                        <span v-else class="text-danger">Not Attached</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.name">{{singleData.name}}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.category">{{ singleData.category.name }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.subcategory">{{ singleData.subcategory.name }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.office">{{ singleData.office }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.business_unit">{{ singleData.business_unit }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.operation">{{ singleData.operation.name }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.serial">{{ singleData.serial }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.purchase">{{ singleData.purchase }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td class="text-center">
                                        <v-btn @click="view(singleData)" color="teal white--text" depressed small>
                                            <v-icon small>mdi-eye</v-icon> View
                                        </v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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



        <!-- view product -->
        <view-product v-if="currentData" :currentData="currentData" :category="currentCategory"
            :subcategory="currentSubcategory" :operation="currentOperation" :key="leaveActionKey"></view-product>

    </div>
</template>



<script>
    import viewProduct from './../viewData.vue'


    export default {

        data() {

            return {
                // dialog
                dataModalDialog: false,

                // loader
                addNetworklLoader: false,


                //current page url
                currentUrl: '/inventory/admin/product/given-product',


                // view details
                currentData: '',
                leaveActionKey: 0,
                currentCategory: '',
                currentSubcategory: '',
                currentOperation: '',


                customSrcByFields: [{
                        value: 'All',
                        text: 'All'
                    },
                    {
                        value: 'office',
                        text: 'Office'
                    },
                    {
                        value: 'business_unit',
                        text: 'Business unit'
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
                        value: 'operation',
                        text: 'Operation'
                    },
                    {
                        value: 'name',
                        text: 'Product Name'
                    },
                ],

                // businessUnit for sort
                businessUnit: '',
                b_unit: [],


                // exportLoading
                exportLoading: false,

            }


        },

        components: {
            "view-product": viewProduct
        },

        methods: {

            // view
            view(data) {
                if (data.category) {
                    this.currentCategory = data.category.name
                }
                if (data.subcategory) {
                    this.currentSubcategory = data.subcategory.name
                }
                if (data.operation) {
                    this.currentOperation = data.operation.name
                }

                this.leaveActionKey++
                this.currentData = data
            },


            // getBusinessUnitOldProductTable
            getBunit() {
                axios.get('/inventory/admin/old_product/business_unit').then(response => {

                    // business_unit
                    response.data.forEach(element => {
                        this.b_unit.push({
                            value: element.business_unit,
                            text: element.business_unit
                        });
                        //console.log('business_unit',  this.allOffice, element);
                    });

                }).catch(error => {
                    console.log(error)
                })
            },



            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl + '/index?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field +
                        '&business_unit=' + this.businessUnit
                    )
                    .then(response => {
                        //console.log(response.data.data);
                        //console.log(response.data.from, response.data.to, response.data.current_page);
                        this.allData = response.data;
                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;
                        this.currentPageNumber = response.data.current_page
                        // Loading Animation
                        this.dataLoading = false;

                    });
            },




            // exportExcel
            exportExcel() {
                this.exportLoading = true;

                axios({
                    method: 'get',
                    url: this.currentUrl + '/export_data?search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field +
                        '&business_unit=' + this.businessUnit,

                    responseType: 'blob', // important
                }).then((response) => {



                    let repName = new Date();

                    const url = URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', `${repName}.xlsx`)
                    document.body.appendChild(link)
                    link.click()

                    this.exportLoading = false;

                }).catch(error => {
                    //stop Loading
                    this.exportLoading = false
                    console.log(error)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Somthing going wrong !!'
                    })
                })


            }




        },

        watch: {
            //Excuted When make change value 
            businessUnit: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },
        },


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
            this.getBunit();
        },



    }

</script>
