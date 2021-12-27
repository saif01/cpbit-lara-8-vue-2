<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Room Bookings Report Table</h3>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div v-if="allData.data">
                    <div class="row mb-2">
                        <div class="col form-inline small">
                            <select v-model="paginate" class="form-control form-control-sm">
                                <option value="10">10</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="col">
                            <input v-model="search" class="form-control form-control-sm" type="text"
                                placeholder="Search by any data at the table...">
                        </div>
                    </div>

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
                                    Bookied By
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
                        <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </div>
        </div>



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


        mounted() {
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
