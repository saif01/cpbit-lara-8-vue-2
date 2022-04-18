<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Delivered Complain List
                    </v-col>
                    <v-col cols="2">

                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text class="table-responsive pt-3">
                <div v-if="allData.data">
                    <v-row >
                        <v-col cols="2">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" dense>
                            </v-select>
                        </v-col>

                        <v-col cols="2">
                            <!-- {{ zone_office }} -->
                            <v-select v-model="zone_office" label="Zones:" :items="allZoneOfficesAssign" item-text="name"
                                item-value="offices" dense>
                            </v-select>
                        </v-col>


                        <v-col cols="2">
                            <!-- Departments -->
                            <v-select v-model="department" label="Departments:" :items="allDepartments"
                                item-text="department" item-value="department" dense>
                            </v-select>
                        </v-col>

                        <v-col cols="2">
                            <!-- <v-text-field prepend-icon="mdi-calendar-cursor" label="Start:" type="date" v-model="start_date" ></v-text-field> -->
                            <v-menu v-model="menu" min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="start_date" label="Start date" prepend-inner-icon="mdi-calendar"
                                        readonly v-bind="attrs" v-on="on" dense clearable></v-text-field>
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
                                        readonly v-bind="attrs" v-on="on" dense clearable></v-text-field>
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
                                placeholder="Search Input..." dense></v-text-field>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>
                                    Num.
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('rec_name')">Rec. Name</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'rec_name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'rec_name'">&darr;</span>
                                </th>
                                 <th>
                                    <a href="#" @click.prevent="change_sort('rec_contact')">Rec. Contact</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'rec_contact'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'rec_contact'">&darr;</span>
                                </th>
                                 <th>
                                    <a href="#" @click.prevent="change_sort('rec_position')">Rec. Position.</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'rec_position'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'rec_position'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('details')">Details</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'details'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'details'">&darr;</span>
                                </th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>User</th>
                                <th>Department</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>
                                    <div class="pa-1 info rounded-pill h4 text-white text-center">
                                        {{ singleData.complain.id }}
                                    </div>
                                </td>
                                <td>{{ singleData.rec_name }} </td>
                                <td>{{ singleData.rec_contact }} </td>
                                <td>{{ singleData.rec_position }} </td>
                                <td> <span v-html="singleData.details"></span></td>

                                <td>
                                    <span v-if="singleData.complain.category">{{ singleData.complain.category.name }}</span>
                                </td>
                                <td>
                                    <span v-if="singleData.complain.subcategory">{{ singleData.complain.subcategory.name }}</span>
                                </td>

                                <td class="text-center">

                                    <button class="btn btn-secondary btn-sm" v-if="singleData.complain.makby"
                                        @click="currentUserView(singleData.complain.makby)">
                                        <v-avatar size="20" @click="currentUserView(singleData.complain.makby)">
                                            <img v-if="singleData.complain.makby.image"
                                                :src="'/images/users/small/' + singleData.complain.makby.image" alt="image">
                                        </v-avatar> {{ singleData.complain.makby.name }}
                                    </button>

                                </td>
                                <td>
                                    <span v-if="singleData.complain.makby">{{ singleData.complain.makby.department }}</span>
                                </td>
                                <td class="text-center">
                                    <v-btn @click="action(singleData.complain.id)" color="error" depressed small elevation="20">
                                        <v-icon small>mdi-arch</v-icon> View
                                    </v-btn>
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
    import userDetails from './../../../../../super_admin/pages/users/details/user_details.vue'
    import userDetailsData from './../../../../../super_admin/pages/users/details/js/data'
    import userDetailsMethods from './../../../../../super_admin/pages/users/details/js/methods'

    export default {

        components: {
            'user-details': userDetails,
        },

        data() {

            return {
                //current page url
                currentUrl: '/cms/h_admin/complain',

                // datepicker
                menu: '',
                menu2: '',

                // Current User Show By Dilog
                ...userDetailsData,
            }
        },

        methods: {

            // CurrentUserData
            ...userDetailsMethods,

            // Get table data
            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl + '/delivered?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field + 
                        '&start='+ this.start_date +
                        '&end='+ this.end_date+
                        '&zone_office='+ this.zone_office+
                        '&department='+ this.department
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


            // action
            action(val) {
                this.$router.push({
                    name: 'Action',
                    query: {
                        id: val
                    }
                })
            },

        },

        mounted(){
            this.getZoneOfficesAssign();
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
