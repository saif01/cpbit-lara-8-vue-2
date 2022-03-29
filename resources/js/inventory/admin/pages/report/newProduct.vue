<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        Report for New Product List
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
                        <v-col lg="4" cols="4">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" dense>
                            </v-select>
                        </v-col>

                        <v-col lg="4" cols="4">
                            <!-- search_field -->
                            <v-select v-model="search_field" label="Search By:" :items="customSrcByFields"
                                item-text="text" item-value="value" dense>
                            </v-select>
                        </v-col>

                        <v-col lg="4" cols="4">
                            <v-autocomplete v-model="sort_by_product" label="Choose Product:" :items="sortByProduct"
                                item-text="name" item-value="name" dense>
                            </v-autocomplete>
                        </v-col>



                        <v-col lg="4" cols="4">
                            <v-menu v-model="menu" min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="sort_by_startDate" label="Start Date"
                                        prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" dense>
                                    </v-text-field>
                                </template>

                                <v-date-picker v-model="sort_by_startDate" no-title scrollable>
                                    <v-spacer></v-spacer>
                                    <v-btn text color="primary" @click="menu = false">
                                        Cancel
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>

                        <v-col lg="4" cols="4">
                            <v-menu v-model="menu2" min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="sort_by_endDate" label="End Date"
                                        prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" dense>
                                    </v-text-field>
                                </template>

                                <v-date-picker v-model="sort_by_endDate" no-title scrollable>
                                    <v-spacer></v-spacer>
                                    <v-btn text color="primary" @click="menu2 = false">
                                        Cancel
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>

                        <v-col lg="4" cols="4">
                            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" hide-details
                                class="mb-5" dense></v-text-field>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Product Name/Model</th>
                                <th>Product Serial</th>
                                <th>Product Category</th>
                                <th>Product Subcategory</th>
                                <th>Unit Price</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('document')">Document</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'document'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'document'">&darr;</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>
                                    {{ singleData.name }}
                                </td>

                                <td>
                                    <span v-html="singleData.serial"></span>
                                </td>

                                <td>
                                    <span v-if="singleData.category">{{ singleData.category.name }}</span>
                                </td>

                                <td>
                                    <span v-if="singleData.subcategory">{{ singleData.subcategory.name }}</span>
                                </td>

                                <td>
                                    <span v-if="singleData.unit_price">
                                        {{singleData.unit_price}}
                                    </span>
                                    <span v-else class="error--text">Not Available</span>
                                </td>

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

    </div>

</template>


<script>
    export default {



        data() {

            return {

                //current page url
                currentUrl: '/inventory/admin/report',


                // timepicker
                menu: false,
                menu2: false,
                date: '',




                allCategory: [],
                allSubcategory: [],
                allCatData: '',



                customSrcByFields: [{
                        value: 'All',
                        text: 'All'
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
                ],

                sortByProduct: [],




                // deliver details
                currentData: '',
                leaveActionKey: 0,
                currentCategory: '',
                currentSubcategory: '',


                // exportLoading
                exportLoading: false,

                // sort_by_product
                sort_by_product: '',

                // sort by between date
                sort_by_startDate: '',
                sort_by_endDate: '',

                // datepicker
                menu: '',
                menu2: '',

            }


        },

        methods: {

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



            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl + '/index?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field +
                        '&sort_by_product=' + this.sort_by_product +
                        '&sort_by_startDate=' + this.sort_by_startDate +
                        '&sort_by_endDate=' + this.sort_by_endDate
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



            getProductName() {
                axios.get(this.currentUrl + '/sort_by_product').then(response => {

                    this.sortByProduct = response.data;

                }).catch(error => {
                    console.log(error)
                })
            },



            exportExcel() {
                if (this.sort_by_product) {

                    this.exportLoading = true;

                    axios({
                        method: 'get',
                        url: this.currentUrl + '/export_data?search=' + this.search +
                            '&sort_direction=' + this.sort_direction +
                            '&sort_field=' + this.sort_field +
                            '&search_field=' + this.search_field +
                            '&sort_by_product=' + this.sort_by_product +
                            '&sort_by_startDate=' + this.sort_by_startDate +
                            '&sort_by_endDate=' + this.sort_by_endDate,


                        responseType: 'blob', // important
                    }).then((response) => {


                        let repName = this.sort_by_product + ' List -' + this.$moment(new Date()).format(
                            'YYYY-MMM-DD');
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

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'You must have to select product before Export !!'
                    })

                }


            }



        },

        watch: {
            sort_by_product: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },


            sort_by_startDate: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },

            sort_by_endDate: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            }
        },


        mounted() {
            this.getProductName();

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
