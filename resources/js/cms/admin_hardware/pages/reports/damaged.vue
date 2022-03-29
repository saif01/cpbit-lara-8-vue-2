<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Damaged Complain Reports
                    </v-col>
                    <v-col cols="2">
                        <v-btn outlined elevation="5" class="float-right" small @click="exportExcel()" :loading="exportLoading">
                            <v-icon left color="success">mdi-file-excel</v-icon>
                            Export
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text class="table-responsive mt-5">
                <div v-if="allData.data">
                    <v-row>
                        <v-col cols="4">
                            <!-- {{ applicable_type }} -->
                            <v-select v-model="applicable_type" label="Applicable Type:" :items="applicableTypeList" item-text="text"
                                item-value="value" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col cols="4">
                            <!-- {{ damaged_type }} -->
                            <v-select v-model="damaged_type" label="Damages Type:" :items="damageTypeList" item-text="text"
                                item-value="value" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col cols="4">
                            <!-- {{ damaged_reason }} -->
                            <v-select v-model="damaged_reason" label="Damaged Reason:" :items="damagedReasons" item-text="text"
                                item-value="value" outlined dense>
                            </v-select>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="2">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" outlined dense>
                            </v-select>
                        </v-col>

                         <v-col cols="2">
                            <!-- {{ zone_office }} -->
                            <v-select v-model="zone_office" label="Zones:" :items="allZoneOffices" item-text="name"
                                item-value="offices" outlined dense>
                            </v-select>
                        </v-col>


                        <v-col cols="2">
                            <!-- Departments -->
                            <v-select v-model="department" label="Departments:" :items="allDepartments"
                                item-text="department" item-value="department" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col cols="2">
                            <!-- <v-text-field prepend-icon="mdi-calendar-cursor" label="Start:" type="date" v-model="start_date" ></v-text-field> -->
                            <v-menu v-model="menu" min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="start_date" label="Start Date" prepend-inner-icon="mdi-calendar"
                                        readonly v-bind="attrs" v-on="on" outlined dense></v-text-field>
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
                                    <v-text-field v-model="end_date" label="End Date" prepend-inner-icon="mdi-calendar"
                                        readonly v-bind="attrs" v-on="on" outlined dense></v-text-field>
                                </template>

                                <v-date-picker v-model="end_date" no-title scrollable>
                                    <v-spacer></v-spacer>
                                    <v-btn text color="primary" @click="menu2 = false">
                                        Cancel
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>

                        <v-col cols="2">
                            <v-text-field prepend-inner-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                                placeholder="Search Input..." outlined dense></v-text-field>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered responsive">
                        <thead class="text-center">
                            <tr>
                                <th>View</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('id')">Num.</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'id'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'id'">&darr;</span>
                                </th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th><a href="#" @click.prevent="change_sort('damaged_reason')">Reason</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'damaged_reason'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'damaged_reason'">&darr;</span>
                                    </th>
                                <th>Complain By</th>
                                <th>Department</th>
                                <th>Damaged By</th>
                                <th>Register</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('updated_at')">Last Update</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'updated_at'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'updated_at'">&darr;</span>
                                </th>

                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr v-for="singleData in allData.data" :key="singleData.id">

                                <td class="text-center">
                                    <v-btn @click="action(singleData.comp_id)" color="error" depressed small elevation="20">
                                        <v-icon small>mdi-arch</v-icon> View
                                    </v-btn>
                                </td>
                                <td>
                                    <div class="pa-1 info rounded-pill h4 text-white text-center">
                                        {{ singleData.comp_id }}
                                    </div>
                                </td>
                                
                                <td>
                                    <span v-if="singleData.complain.category">{{ singleData.complain.category.name }}</span>
                                </td>
                                <td>
                                    <span v-if="singleData.complain.subcategory">{{ singleData.complain.subcategory.name }}</span>
                                </td>
                                <td>
                                    <span v-if="singleData.damaged_reason">{{ singleData.damaged_reason }}</span>
                                </td>

                                <td class="text-center">
                                    <v-btn x-small class="secondary" v-if="singleData.complain.makby"
                                        @click="currentUserView(singleData.complain.makby)">
                                        <v-avatar size="20" @click="currentUserView(singleData.complain.makby)">
                                            <img v-if="singleData.complain.makby.image"
                                                :src="'/images/users/small/' + singleData.complain.makby.image" alt="image">
                                        </v-avatar> {{ singleData.complain.makby.name }}
                                    </v-btn>
                                </td>
                                <td>
                                    <span v-if="singleData.makby">{{ singleData.makby.department }}</span>
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
                                <td><span v-if="singleData.complain.created_at">{{ singleData.complain.created_at | moment("MMM Do YYYY") }}</span>
                                </td>
                                <td><span v-if="singleData.updated_at">{{ singleData.updated_at | moment("MMM Do YYYY") }}</span>
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
    import userDetails from '../../../../super_admin/pages/users/details/user_details.vue'
    import userDetailsData from '../../../../super_admin/pages/users/details/js/data'
    import userDetailsMethods from '../../../../super_admin/pages/users/details/js/methods'

    import damagedReasonList from '../complain/action/js/damaged_reasons'

    export default {

        components: {
            'user-details': userDetails,
        },

        data() {

            return {
                //current page url
                currentUrl: '/cms/h_admin/reports',

                // Current User Show By Dilog
                ...userDetailsData,

                // exportLoading
                exportLoading: false,

                // damaged reason list
                ...damagedReasonList,

                applicableTypeList:[
                    {
                        text: 'All',
                        value: 'All'
                    },
                    {
                        text: 'Applicable',
                        value: 'Applicable'
                    },
                    {
                        text: 'Not Applicable',
                        value: 'Not Applicable'
                    }
                ],

                damageTypeList:[
                    {
                        text: 'All',
                        value: 'All'
                    },
                    {
                        text: 'Damaged',
                        value: 'Damaged'
                    },
                    {
                        text: 'Partial Damaged',
                        value: 'Partial Damaged'
                    }
                ],


                damaged_reason: '',
                applicable_type: '',
                damaged_type: '',

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
                axios.get(this.currentUrl+'/damaged?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field + 
                        '&start='+ this.start_date +
                        '&end='+ this.end_date +
                        '&zone_office='+ this.zone_office +
                        '&department='+ this.department +
                        '&zone_office='+ this.zone_office +
                        '&department='+ this.department +
                        '&damaged_reason='+ this.damaged_reason +
                        '&applicable_type='+ this.applicable_type +
                        '&damaged_type='+ this.damaged_type

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
                    url: this.currentUrl+'/export_data_damage?search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field + 
                        '&start='+ this.start_date +
                        '&end='+ this.end_date +
                        '&zone_office='+ this.zone_office +
                        '&department='+ this.department +
                        '&zone_office='+ this.zone_office +
                        '&department='+ this.department +
                        '&damaged_reason='+ this.damaged_reason +
                        '&applicable_type='+ this.applicable_type +
                        '&damaged_type='+ this.damaged_type,

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


            },

            merge(){
                
                 
                let json2 = {
                        text: 'All',
                        value: 'All'
                    };
                this.damagedReasons.unshift(json2);
                

                
            }

        },

        watch: {
            //Excuted When make change value 
            damaged_reason: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
                
            },

            applicable_type: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
                
            },

            damaged_type: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
                
            },
        },

      

        mounted(){
            this.getZoneOffices();
            this.getDepartments();
            this.merge();
        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
        },



    }

</script>
