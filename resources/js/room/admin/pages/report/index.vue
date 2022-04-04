<template>
    <div>
        <v-card>
            <v-card-title>Room Bookings Reports</v-card-title>

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
                                    Room
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('start')">Start</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'start'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'start'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('end')">End</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'end'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'end'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('purpose')">Purpose</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'purpose'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'purpose'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('status')">Status</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'status'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'status'">&darr;</span>
                                </th>
                                <th>
                                    Booked By
                                </th>
                                <th>
                                    Department
                                </th>
                             
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td> <span v-if="singleData.room">{{ singleData.room.name }}</span></td>
                                <td>{{ singleData.start  | moment("MMMM Do YYYY, h:mm a") }}</td>
                                <td>{{ singleData.end  | moment("MMMM Do YYYY, h:mm a") }}</td>
                                <td>{{ singleData.purpose }}</td>
                                 <td><span v-if="singleData.status == 1" >Booked</span><span v-else>Canceled</span> </td>

                                <td> <span v-if="singleData.bookby">{{ singleData.bookby.name }}</span></td>
                                <td> <span v-if="singleData.bookby">{{ singleData.bookby.department }}</span></td>
                               
                            
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



    </div>

</template>


<script>

    export default {
      
        data() {

            return {

                //current page url
                currentUrl: '/room/admin/report',

              
               

                imageMaxSize: '5111775',
                imagePath: '/images/room/',
                imagePathSm: '/images/room/small/',

            }


        },

        methods: {



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
    .image-thum-size{
        height: 50px;
        width: 100px;
    }
</style>
