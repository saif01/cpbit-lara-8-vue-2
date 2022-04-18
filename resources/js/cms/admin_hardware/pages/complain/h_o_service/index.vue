<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                         H.O. Service Complain List
                    </v-col>
                    <v-col cols="2">

                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text class="table-responsive">
                <v-row>
                        <v-col cols="2">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" small>
                            </v-select>
                        </v-col>
                        <v-col cols="4" >
                            <!-- zone_office --> 
                            <!-- <v-select v-model="zone_office" 
                            label="Zones:"
                            :items="allZoneOfficesAssign"
                            item-text="name"
                                item-value="offices"
                             >
                            </v-select> -->
                            <v-select v-if="isHardwareHoService()" v-model="zone_office_custom" 
                            label="Zones:"
                            :items="allZoneOffices"
                            item-text="name"
                            item-value="name"
                             >
                            </v-select>
                            <v-select v-else disabled v-model="zone_office_custom" 
                            label="Zones:"
                            :items="allZoneOffices"
                            item-text="name"
                            item-value="name"
                             >
                            </v-select>
                        </v-col>

                        <v-col cols="6">
                            <v-text-field prepend-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                                placeholder="Search Input..."></v-text-field>
                        </v-col>
                    </v-row>
                <div v-if="allData.data">
                    

                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>
                                    <a href="#" @click.prevent="change_sort('id')">Num.</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'id'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'id'">&darr;</span>
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

                                    <button class="btn btn-secondary btn-sm" v-if="singleData.makby"
                                        @click="currentUserView(singleData.makby)">
                                        <v-avatar size="20" @click="currentUserView(singleData.makby)">
                                            <img v-if="singleData.makby.image"
                                                :src="'/images/users/small/' + singleData.makby.image" alt="image">
                                        </v-avatar> {{ singleData.makby.name }}
                                    </button>

                                </td>
                                <td>
                                    <span v-if="singleData.makby">{{ singleData.makby.department }}</span>
                                </td>
                                <td class="text-center">
                                    <v-btn @click="action(singleData.id)" color="error" depressed small elevation="20">
                                        <v-icon small>mdi-arch</v-icon> Action
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
                currentUrl: '/cms/h_admin/complain/ho_service',

                // Current User Show By Dilog 
                ...userDetailsData,

                // allZons:[],
                // selected_zone:'All',

                zone_office_custom: 'All',
            }
        },

        methods: {

            // CurrentUserData
            ...userDetailsMethods,

            // Get table data
            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl + '/index?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field +
                        '&zone_office=' + this.zone_office_custom
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

             // Get all Zone
            getZons() {
                axios.get(this.currentUrl + '/zone_data').then(response => {
                    //console.log(response.data)
                    this.allZons = response.data
                }).catch(error => {
                    console.log(error)
                })
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


        watch:{
            zone_office_custom:function(){
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            }
        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.getZoneOffices();
            //this.getZoneOfficesAssign();
            this.$Progress.finish();
        },



    }

</script>
