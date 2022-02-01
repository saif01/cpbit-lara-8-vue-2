<template>
    <div>
        <v-dialog v-model="managerSelectDilog" max-width="1000" scrollable>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="5">
                            Manager Select
                        </v-col>
                        <v-col cols="5">
                            <div class="m-auto">
                                <v-btn @click="request()" color="success" elevation="20">
                                    <v-icon left>mdi-bookmark-plus</v-icon>Select Manager
                                </v-btn>
                            </div>
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="managerSelectDilog = false" color="red lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>


                    <div class="card-body table-responsive">
                        <div v-if="allData.data">
                            <v-row>
                                <v-col cols="2">
                                    <!-- Show -->
                                    <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" small>
                                    </v-select>
                                </v-col>

                                <v-col cols="2">
                                    <!-- zone_office -->
                                    <v-select v-model="zone_office" label="Zones:" :items="allZoneOffices"
                                        item-text="name" item-value="offices" small>
                                    </v-select>
                                </v-col>

                                <v-col cols="3">
                                    <!-- Departments -->
                                    <v-select v-model="department" label="Departments:" :items="allDepartments"
                                        item-text="department" item-value="department" small>
                                    </v-select>
                                </v-col>

                                <v-col cols="2">
                                    <!-- search_field -->
                                    <v-select v-model="search_field" label="Search By:" :items="searchByFields"
                                        item-text="name" item-value="value" small>
                                    </v-select>
                                </v-col>

                                <v-col cols="3">
                                    <v-text-field prepend-icon="mdi-clipboard-text-search" v-model="search"
                                        label="Search:" placeholder="Search Input..."></v-text-field>
                                </v-col>

                            </v-row>

                            <!-- selectedManager : {{ selectedManager }} -->

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            <a href="#" @click.prevent="change_sort('login')">login</a>
                                            <span v-if="sort_direction == 'desc' && sort_field == 'login'">&uarr;</span>
                                            <span v-if="sort_direction == 'asc' && sort_field == 'login'">&darr;</span>
                                        </th>
                                        <th>Image</th>
                                        <th>
                                            <a href="#" @click.prevent="change_sort('name')">Name</a>
                                            <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                            <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                        </th>
                                        <th>
                                            <a href="#" @click.prevent="change_sort('department')">Department</a>
                                            <span
                                                v-if="sort_direction == 'desc' && sort_field == 'department'">&uarr;</span>
                                            <span
                                                v-if="sort_direction == 'asc' && sort_field == 'department'">&darr;</span>
                                        </th>
                                        <th>
                                            <a href="#" @click.prevent="change_sort('office')">Office</a>
                                            <span
                                                v-if="sort_direction == 'desc' && sort_field == 'office'">&uarr;</span>
                                            <span v-if="sort_direction == 'asc' && sort_field == 'office'">&darr;</span>
                                        </th>
                                        <th>
                                            <a href="#" @click.prevent="change_sort('business_unit')">Business Unit</a>
                                            <span
                                                v-if="sort_direction == 'desc' && sort_field == 'business_unit'">&uarr;</span>
                                            <span
                                                v-if="sort_direction == 'asc' && sort_field == 'business_unit'">&darr;</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="singleData in allData.data" :key="singleData.id">
                                        <td>
                                            <v-checkbox v-model="selectedManager" :value="singleData.id"
                                                :label="`${singleData.login}`"> </v-checkbox>
                                        </td>
                                        <td><img v-if="singleData.image" :src="imagePathSm + singleData.image"
                                                alt="image" class="rounded-circle" height="50" width="50">
                                        </td>
                                        <td>{{ singleData.name }}</td>
                                        <td>{{ singleData.department }} </td>
                                        <td>{{ singleData.office }} </td>
                                        <td>{{ singleData.business_unit }} </td>
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
                                <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon>
                                </p>
                            </div>
                        </div>
                        <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>
                    </div>


                </v-card-text>
            </v-card>

        </v-dialog>
    </div>
</template>


<script>
    import userMethods from './js/methods'
    import userTblData from './js/data'

    export default {
        // For parent response
        props: ['childrenRequest', 'selected_id'],


        data() {

            return {

                //current page url
                currentUrl: '/super_admin/user',

                managerSelectDilog: true,

                selectedManager: [],

                // userTblData
                ...userTblData,


            }


        },

        methods: {

            //userMethods
            ...userMethods,



            // request
            request() {

                console.log('selectedManager', this.selectedManager)

                if (this.selectedManager.length <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!!, Manager not selected',
                    })
                } else {

                    // setManager
                    this.setManager()

                    // Make Object
                    let result = {
                        manager_id: this.selectedManager,
                        manager_name: this.selectedManagerName
                    };



                    // Data send to parent
                    this.childrenRequest(result)

                    //console.log('result', result)

                    // Hide Dilog
                    this.managerSelectDilog = false
                }



            },



            //Set Manager
            setManager() {
                // make empty
                this.selectedManagerName = []

                var allDataArr = this.allData.data;
                var managerId = this.selectedManager
                //console.log(managerId, myarr, singleData.manager_id);

                // Manager ID check in all Data
                for (var key in allDataArr) {
                    var value = allDataArr[key];
                    // Check manager ID in Current Data
                    for (var key2 in managerId) {
                        var value2 = managerId[key2];
                        // Single value check
                        if (value2 == value.id) {
                            //console.log('value found', value.id, value.name)
                            // Name push in array
                            this.selectedManagerName.push(value.name)
                            // ID Push in form obj
                            //this.form.manager_id.push(value.id)
                        }
                        // console.log('for2 -- ', key2, value2);
                    }
                }


                console.log('selectedManagerName', this.selectedManagerName, )

            },




        },




        mounted() {
            // All ZoneOffices
            this.getZoneOffices();
            //getDepartments
            this.getDepartments();
        },

        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            // Assign
            this.selectedManager =  this.selected_id.split(',').map(Number);
            //console.log('Selected Id', this.selected_id, this.selectedManager)
            this.$Progress.finish();
        }



    }

</script>


<style scoped>
    .hide {
        /* visibility: hidden !important; */
        display: none !important;
    }

    .image-thum-size {
        height: 50px;
        width: 100px;
    }

</style>
