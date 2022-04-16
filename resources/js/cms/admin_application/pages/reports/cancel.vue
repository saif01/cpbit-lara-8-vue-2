<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Complain Canceled Reports
                    </v-col>
                    <v-col cols="2">
                        <v-btn outlined elevation="5" class="float-right" small @click="exportExcel()" :loading="exportLoading">
                            <v-icon left color="success">mdi-file-excel</v-icon>
                            Export
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text class="table-responsive pt-3">
                <div v-if="allData.data">
                    <v-row>
                        <v-col lg="2" cols="4">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col cols="2">
                            <!-- <v-text-field prepend-icon="mdi-calendar-cursor" label="Start:" type="date" v-model="start_date" ></v-text-field> -->
                            <v-menu v-model="menu" min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="start_date" label="Start" prepend-inner-icon="mdi-calendar"
                                        readonly v-bind="attrs" v-on="on" outlined dense clearable></v-text-field>
                                </template>

                                <v-date-picker v-model="start_date" no-title scrollable>
                                    <v-spacer></v-spacer>
                                    <v-btn text color="primary" @click="menu = false">
                                        Cancel
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>
                        <v-col cols="2">
                            <!-- <v-text-field prepend-icon="mdi-calendar-cursor" label="End:" type="date" v-model="end_date" ></v-text-field> -->
                            <v-menu v-model="menu2" min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="end_date" label="Start" prepend-inner-icon="mdi-calendar"
                                        readonly v-bind="attrs" v-on="on" outlined dense clearable></v-text-field>
                                </template>

                                <v-date-picker v-model="end_date" no-title scrollable>
                                    <v-spacer></v-spacer>
                                    <v-btn text color="primary" @click="menu2 = false">
                                        Cancel
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>

                        <v-col lg="2" cols="6">
                            <!-- {{ zone_office }} -->
                            <v-select v-model="zone_office" label="Zones:" :items="allZoneOffices" item-text="name"
                                item-value="offices" outlined dense clearable>
                            </v-select>
                        </v-col>


                        <v-col lg="2" cols="6">
                            <!-- Departments -->
                            <v-select v-model="department" label="Departments:" :items="allDepartments"
                                item-text="department" item-value="department" outlined dense clearable>
                            </v-select>
                        </v-col>

                        <v-col lg="6" cols="6">
                            <!-- search_field -->
                            <v-select v-model="search_field" label="Search By:" :items="customSrcByFields" item-text="text"
                                item-value="value" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="6" cols="6">
                            <v-text-field prepend-inner-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                                placeholder="Search Input..." outlined dense></v-text-field>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered responsive">
                        <thead class="text-center">
                            <tr>
                              
                                <th>
                                    <a href="#" @click.prevent="change_sort('id')">Num.</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'id'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'id'">&darr;</span>
                                </th>
                                <th>Software</th>
                                <th>Module</th>
                                <th>User</th>
                                <th>Department</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('created_at')">Register</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'created_at'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'created_at'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('updated_at')">Last Update</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'updated_at'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'updated_at'">&darr;</span>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">

                               
                                <td>
                                    <div class="pa-1 info rounded-pill h4 text-white text-center">
                                        {{ singleData.id }}
                                    </div>
                                </td>
                                <td>
                                    <span v-if="singleData.category">{{ singleData.category.name }}</span>
                                </td>
                                <td>
                                    <span v-if="singleData.subcategory">{{ singleData.subcategory.name }}</span>
                                </td>

                                <td class="text-center">

                                    <v-btn x-small class="secondary" v-if="singleData.makby"
                                        @click="currentUserView(singleData.makby)">
                                        <v-avatar size="20" @click="currentUserView(singleData.makby)">
                                            <img v-if="singleData.makby.image"
                                                :src="'/images/users/small/' + singleData.makby.image" alt="image">
                                        </v-avatar> {{ singleData.makby.name }}
                                    </v-btn>

                                </td>
                                <td>
                                    <span v-if="singleData.makby">{{ singleData.makby.department }}</span>
                                </td>
                                <td><span v-if="singleData.created_at">{{ singleData.created_at | moment("MMM Do YYYY, h:mm a") }}</span>
                                </td>
                                <td><span v-if="singleData.updated_at">{{ singleData.updated_at | moment("MMM Do YYYY, h:mm a") }}</span>
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

        <!-- user-details -->
        <user-details v-if="CurrentUserData" :userData="CurrentUserData" :key="userDetailsDialogKey"></user-details>

    </div>

</template>


<script>
    // User Details Show By Dialog
    import userDetails from './../../../../super_admin/pages/users/details/user_details.vue'
    import userDetailsData from './../../../../super_admin/pages/users/details/js/data'
    import userDetailsMethods from './../../../../super_admin/pages/users/details/js/methods'

    export default {

        components: {
            'user-details': userDetails,
        },

        data() {

            return {
                //current page url
                currentUrl: '/cms/a_admin/reports',

                // Current User Show By Dilog
                ...userDetailsData,

                start_date:'',
                end_date:'',

                customSrcByFields:[
                    {
                        value: 'All',
                        text: 'All'
                    },
                    {
                        value: 'cat_id',
                        text: 'Software'
                    },
                    {
                        value: 'subcat_id',
                        text: 'Module'
                    },
                    {
                        value: 'department',
                        text: 'Department'
                    },
                    
                    
                ],


                // search_type
                search_field: '',

                // excelData
                excelData: '',

                // exportLoading
                exportLoading: false,


                zone_office:'',
                department: '',

                // datepicker
                menu: '',
                menu2: '',
            }
        },

        methods: {

            // CurrentUserData
            ...userDetailsMethods,


            // Get table data
            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl+'/canceled?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field + 
                        '&start='+ this.start_date +
                        '&end='+ this.end_date +
                        '&zone_office='+ this.zone_office+
                        '&department='+ this.department

                    )
                    .then(response => {
                        //console.log(response.data.data);
                        //console.log(response.data.from, response.data.to);
                        this.allData = response.data;
                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;
                        this.currentPageNumber  = response.data.current_page
                        // Loading Animation
                        this.dataLoading = false;

                    });
                    
            },


            // action
            action(val) {
                this.$router.push({
                    name: 'Action',
                    query: {
                        id: val
                    }
                })
            },


            // exportExcel
            exportExcel(){
                this.exportLoading = true;

                axios({
                    method: 'get',
                    url: this.currentUrl+'/export_data_cancel?search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field + 
                        '&start='+ this.start_date +
                        '&end='+ this.end_date +
                        '&zone_office='+ this.zone_office+
                        '&department='+ this.department,

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
            start_date: function (value) {
                if(this.end_date){
                    this.$Progress.start();
                    this.getResults();
                    this.$Progress.finish();
                }
            },

            end_date: function (value) {
                if(this.start_date){
                    this.$Progress.start();
                    this.getResults();
                    this.$Progress.finish();
                }
            },

            search_field: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },

            zone_office: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },

            department: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },
        },


        mounted(){
            this.getZoneOffices();
            this.getDepartments();
        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
        },



    }

</script>
