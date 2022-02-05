<template>
    <div>

        <div v-if="allData">

            <div v-if="allData.length > 0">
                <!-- card -->
                <div class="booking_card_details my-3">
                    <v-card v-for="item in allData" :key="item.id">
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-img v-if="item.car" :src="imagePath+item.car.image" alt="Image" max-height="250px" width="100%" contain></v-img>

                                <v-img v-else src="/all-assets/common/img/no-image.png" alt="Image" max-height="250px" width="100%" contain></v-img>
                            </v-col>

                            <v-col cols="12" md="6">
                                <v-card-text class="mt-3">
                                    <div class="d-flex justify-content-between">
                                        <div class="h3">
                                            Booking Details
                                        </div>
                                    </div>
                                    <table>
                                        <tr>
                                            <th>Car Details</th>
                                            <td class="pl-4"><span v-if="item.car">{{ item.car.name }} || {{ item.car.number }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Driver Details</th>
                                            <td class="pl-4"><span v-if="item.driver">{{ item.driver.name }} || {{ item.driver.contact }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Purpose</th>
                                            <td class="pl-4 py-2">{{ item.purpose }}</td>
                                        </tr>
                                        <tr>
                                            <th>Booked</th>
                                            <td class="pl-4">{{ item.start | moment("MMM Do YYYY, h:mm a") }} - To -
                                                {{ item.end | moment("MMM Do YYYY, h:mm a") }}</td>
                                        </tr>
                        
                                    </table>

                                     <div class="float-right mt-5 text-danger">
                                        <th>Canceled At</th>
                                            <td class="pl-4">{{ item.updated_at | moment("MMM Do YYYY, h:mm a") }}
                                            </td>
                                    </div>


                                </v-card-text>
                            </v-col>
                        </v-row>
                    </v-card>

                </div>
            </div>
            <div v-else>
                <div class="p-5 my-5">
                    <p class="text-center text-info h1">Sorry !! You have no current booking. </p>
                </div>
            </div>

        </div>
        <div v-else>
            <div v-if="dataLoading" class="p-5 my-5">
                <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon></p>
            </div>
        </div>

    </div>
</template>

<script>
    // vform
    import Form from 'vform';

    export default {
        data() {
            return {

                //current page url
                currentUrl: '/carpool/booked',

                imagePath: '/images/carpool/car/',
                imagePathSm: '/images/carpool/car/small/',

                allData: '',
                dataLoading: false,


            }
        },

        methods: {

            // canceled Data
            getCanceledData() {
                // Loading
                this. dataLoading = true
                axios.get(this.currentUrl + '/canceled').then(response => {
                    console.log(response.data)
                    this.allData = response.data
                    // Loading
                    this. dataLoading = false
                }).catch(error => {
                    console.log(error)
                })
            },

            
        


          

        },

        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getCanceledData();
            this.$Progress.finish();

        }
    }

</script>


<style scoped>

    .booking_card_details {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

</style>
