<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        <b class="info--text">{{ current_category.name }}</b> Stock Report ( {{sort_by_startDate}} to {{sort_by_endDate}} )
                    </v-col>
                    <v-col cols="2">
                        <v-btn outlined elevation="5" class="float-right" small @click="exportExcel()"
                            :loading="exportLoading">
                            <v-icon left color="success">mdi-file-excel</v-icon>
                            Export
                        </v-btn>

                         <!-- <a :href="'/inventory/admin/report/stock/export_view?sort_by_startDate=' + sort_by_startDate +
                    '&sort_by_endDate=' +sort_by_endDate +
                    '&sort_by_category=' +current_category.id +
                    '&product_name=' +current_category.name" target="_blank" class="btn" >Export View</a> -->

                    </v-col>

                    

                </v-row>
            </v-card-title>

            <v-card-text>
                <v-row>
                   
                    <v-col lg="4" cols="4">
                        <!-- {{ current_category.id }} -->
                        <v-autocomplete v-model="current_category" label="Choose Category:" :items="allCategory" dense>
                        </v-autocomplete>
                    </v-col>


                    <v-col lg="4" cols="4">
                        <!-- {{sort_by_startDate}} -->
                        <v-menu v-model="menu" min-width="auto">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="sort_by_startDate" label="Report Start Date"
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
                                <v-text-field v-model="sort_by_endDate" label="Report End Date"
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


                </v-row>

                <div v-if="allData.data">

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Issue Date</th>
                                <th>CMS Number</th>
                                <th>Location</th>
                                <th>Department</th>
                                <th>Product Type/Category</th>
                                <th>Unit Price</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td><span v-if="singleData.updated_at">{{ singleData.updated_at | moment("dddd, MMMM Do YYYY") }}</span></td>
                                <td><span v-if="singleData.newold">{{ singleData.newold.new_pro_id }}</span></td>
                                <td><span v-if="singleData.newold">{{ singleData.newold.business_unit }}</span></td>
                                <td><span v-if="singleData.newold">{{ singleData.newold.office }}</span></td>
                                <td><span v-if="singleData.category">{{ singleData.category.name }}</span></td>
                                <td> <span v-if="singleData.unit_price">
                                        {{singleData.unit_price}}
                                    </span>
                                    <span v-else class="error--text">N/A</span>
                                </td>
                                <td><span v-html="singleData.remarks"></span></td>

                            </tr>
                        </tbody>
                    </table>



                </div>
                <div v-else>
                    <div v-if="dataLoading" class="p-5 my-5">
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin
                            </v-icon>
                        </p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Don't use this month</h1>

                <div class="col-8">Summary Report:
                <!-- Summary table -->
                <table class="table table-bordered text-center">
                    <tr>
                        <th colspan="2">TOTAL USEGE</th>
                        <th>Unit Price</th>
                        <th>Amount</th>
                    </tr> 
                    <tr class="summary_color">
                        <th>B/F</th>
                        <td><span v-if="allData.totalBroughtForward"> {{ allData.totalBroughtForward }}</span><span v-else
                                class="error--text">N/A</span></td>
                        <td><span v-if="allData.broughtForwardAmmountUnit"> {{ allData.broughtForwardAmmountUnit }}</span><span
                                v-else class="error--text">N/A</span></td>
                        <td><span v-if="allData.totalBroughtForwardAmmount"> {{ allData.totalBroughtForwardAmmount }}</span><span
                                v-else class="error--text">N/A</span></td>
                       
                    </tr>
                    <tr>
                        <th>RECEIVED</th>
                        <td><span v-if="allData.totalReceived"> {{ allData.totalReceived }}</span> <span v-else
                                class="error--text">N/A</span></td>
                        <td><span v-if="allData.receivedAmmountUnit"> {{ allData.receivedAmmountUnit }}</span><span
                                v-else class="error--text">N/A</span></td>
                        <td><span v-if="allData.totalReceivedAmmount"> {{ allData.totalReceivedAmmount }}</span><span
                                v-else class="error--text">N/A</span></td>

                    </tr>
                    <tr>
                        <th>ISSUE</th>
                        <td><span v-if="allData.totalIssue"> {{ allData.totalIssue }}</span><span v-else
                                class="error--text">N/A</span></td>
                        <td><span v-if="allData.issueAmmountUnit"> {{ allData.issueAmmountUnit }}</span><span v-else
                                class="error--text">N/A</span></td>
                        <td><span v-if="allData.totalIssueAmmount"> {{ allData.totalIssueAmmount }}</span><span v-else
                                class="error--text">N/A</span></td>

                    </tr>
                    <tr>
                        <th>DAMAGE</th>
                        <td><span v-if="allData.totalDamaged"> {{ allData.totalDamaged }}</span><span v-else
                                class="error--text">N/A</span></td>
                        <td><span v-if="allData.totalDamagedAmmount"> {{ allData.totalDamagedAmmount }}</span><span
                                v-else class="error--text">N/A</span></td>
                        <td><span v-if="allData.damagedAmmountUnit"> {{ allData.damagedAmmountUnit }}</span><span v-else
                                class="error--text">N/A</span></td>
                    </tr>
                    <tr class="summary_color">
                        <th>C/F</th>
                        <td><span v-if="allData.totalRemaining"> {{ allData.totalRemaining }}</span><span v-else
                                class="error--text">N/A</span></td>
                        <td><span v-if="allData.totalRemainingAmmount"> {{ allData.totalRemainingAmmount }}</span><span
                                v-else class="error--text">N/A</span></td>
                        <td><span v-if="allData.totalRemainingAmmount"> {{ allData.totalRemainingAmmount }}</span><span
                                v-else class="error--text">N/A</span></td>
                       
                    </tr>
                </table>
                </div>

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


                sortByProduct: [],

                // deliver details
                // currentData: '',
                // leaveActionKey: 0,
                // currentCategory: '',
                // currentSubcategory: '',


                // exportLoading
                exportLoading: false,

                
                current_category_name: '',
                current_category_id: '',
                current_category: '',
                // sort by between date
                sort_by_startDate: this.$moment().startOf('month').format('YYYY-MM-DD'),
                sort_by_endDate: this.$moment().endOf('month').format('YYYY-MM-DD'),

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
                    this.current_category = response.data[0]
                    this.current_category_name = response.data[0].name

                    for (let i = 0; i < response.data.length; i++) {
                        this.allCategory.push(response.data[i]);
                        this.allCategory[i] = {
                            value: response.data[i],
                            text: response.data[i].name
                        };
                    }
                }).catch(error => {
                    console.log(error)
                })
            },



            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl + '/stock?page=' + page +
                        '&sort_by_startDate=' + this.sort_by_startDate +
                        '&sort_by_endDate=' + this.sort_by_endDate +
                        '&sort_by_category=' + this.current_category.id
                    )
                    .then(response => {
                        console.log(response.data);
                        this.allData = response.data;
                        this.totalValue = response.data.totalIssue;
                        this.dataLoading = false;

                    });
            },


            exportExcel() {

                this.exportLoading = true;

                axios({
                    method: 'get',
                    url: this.currentUrl + '/stock/export_data?sort_by_startDate=' + this.sort_by_startDate +
                    '&sort_by_endDate=' + this.sort_by_endDate +
                    '&sort_by_category=' + this.current_category.id +
                    '&product_name=' + this.current_category.name,

                    responseType: 'blob', // important
                }).then((response) => {

                    let repName = this.current_category.name + ' Stock Report -(' + this.sort_by_startDate +
                        ' to ' + this.sort_by_endDate + ')';
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

            sort_by_startDate: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },

            sort_by_endDate: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },

            current_category: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },
        },


        mounted() {
            //this.getProductName();

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
    .summary_color{
        background-color: #009688; 
        color:white
    }
</style>
