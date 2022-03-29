<template>
    <div>
        <v-card>
            <v-card-title>
                <v-row>
                    <v-col cols="10">
                        <h3> Alll Car Maintenance Records </h3>
                    </v-col>
                    <v-col cols="2">
                        <v-btn outlined elevation="5" class="float-right" small @click="exportExcel()" :loading="exportLoading">
                            <v-icon left color="success">mdi-file-excel</v-icon>
                            Export
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
                                    <a href="#" @click.prevent="change_sort('name')">Driver</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('name')">Car</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('start')">Maintenance Start</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'start'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'start'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('end')">Maintenance End</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'end'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'end'">&darr;</span>
                                </th>
                                
                                <th>
                                    <a href="#" @click.prevent="change_sort('status')">Status</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'status'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'status'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('register')">Register</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'register'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'register'">&darr;</span>
                                </th>
                             
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>
                                    <span v-if="singleData.driver">
                                        <v-btn color="indigo white--text" small depressed @click=" getDriverModalData( singleData.driver.id)">
                                            {{ singleData.driver.name }}
                                        </v-btn>
                                    </span>
                                    <span v-else class="error--text">Not Found !</span>
                                </td>
                                <td> <span v-if="singleData.car">{{ singleData.car.name }} || {{ singleData.car.number }}</span></td>
                                <td>{{ singleData.start  | moment("MMMM Do YYYY, h:mm a") }}</td>
                                <td>{{ singleData.end  | moment("MMMM Do YYYY, h:mm a") }}</td>
                                <td><span v-if="singleData.status == 1" >Accepted</span><span v-else>Canceled</span> </td>

                                <td> <span v-if="singleData">{{ singleData.created_at }}</span></td>
                                
                               
                            
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span>Total Records: {{ totalValue }}</span>
                    </div>
                    <pagination :data="allData" :limit="3" @pagination-change-page="getResults" class="justify-content-end">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-else>
                    <div v-if="dataLoading" class="p-5 my-5">
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </v-card-text>
        </v-card>




        <!-- driver infomation modal -->
        <v-dialog v-model="driverModal" max-width="600px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Driver Details
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="driverModal = false" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-list-item three-line>
                        <v-list-item-content class="text-overline">
                            <div>
                                Name: <span v-if="driverData">{{ driverData.name }}</span>
                            </div>
                            <div>
                                Contact: <span v-if="driverData">{{ driverData.contact }}</span>
                            </div>

                            <div>
                                License: <span v-if="driverData.driver">{{ driverData.driver }}</span> <span v-else class="error--text">Not Available !</span>
                            </div>

                            <div>
                                NID: <span v-if="driverData.nid">{{ driverData.nid }}</span> <span v-else class="error--text">Not Available !</span>
                            </div>
                            
                        </v-list-item-content>

                        <v-list-item-avatar
                            tile
                            size="100"
                        >
                        <v-img v-if="driverData.image" :src="imagePathSm + driverData.image" alt="image"
                                        max-height="120px" contain></v-img>
                        </v-list-item-avatar>
                    </v-list-item>
                </v-card-text>
            </v-card>
        </v-dialog>


    </div>

</template>


<script>

    export default {
      
        data() {

            return {

                // dialog
                driverModal: false,

                //current page url
                currentUrl: '/carpool/admin/report',


                // allData
                allData: '',
                

                // driverData
                driverData: '',
              
               

                imageMaxSize: '5111775',
                imagePath: '/images/carpool/',
                imagePathSm: '/images/carpool/driver/small/',



                // exportLoading
                exportLoading: false,

            }


        },

        methods: {

            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl+'/car-maintenance?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field
                    )
                    .then(response => {
                        //console.log(response.data.data);
                        //console.log(response.data.from, response.data.to);
                        this.allData = response.data;
                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;
                        this.currentPageNumber  = response.data.current_page

                        //console.log('currentPageNumber: ', this.currentPageNumber)
                    
                        // Loading Animation
                        this.dataLoading = false;

                    });
            },



            // exportExcel
            exportExcel(){

                    this.exportLoading = true;

                    axios({
                        method: 'get',
                        url: this.currentUrl+'/export_data_maint?search=' + this.search +
                            '&sort_direction=' + this.sort_direction +
                            '&sort_field=' + this.sort_field +
                            '&search_field=' + this.search_field,
                            

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


        },


        mounted() {
            
        },


        created(){
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
        }



    }

</script>
