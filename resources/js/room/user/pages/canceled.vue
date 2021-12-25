<template>
    <div>

        <div v-if="allData">

            <div v-if="allData.length > 0">

                <div v-for="item in allData" :key="item.id">
                    <b-card no-body class="overflow-hidden my-2">
                        <b-row no-gutters>
                            <b-col md="6">
                                <b-card-img v-if="item.room.image" :src="imagePath+item.room.image" height="150"
                                    width="200" alt="Image" class="rounded-0"></b-card-img>
                                <b-card-img v-else src="/all-assets/common/img/no-image.png" height="150"
                                    width="200" alt="Image" class="rounded-0"></b-card-img>
                            </b-col>
                            <b-col md="6">
                                <b-card-body title="">
                                    <b-card-text>
                                        <table class="table table-sm text-center">
                                            <tr>
                                                <th>Name:</th>
                                                <td><span v-if="item.room">{{ item.room.name }}</span></td>
                                            </tr>
                                            <tr>
                                                <th>Purpose:</th>
                                                <td>{{ item.purpose }}</td>
                                            </tr>
                                            <tr>
                                                <th>Booked:</th>
                                                <td>{{ item.start | moment("MMM Do YYYY, h:mm a") }} - To -
                                                    {{ item.end | moment("MMM Do YYYY, h:mm a") }}</td>
                                            </tr>
                                            <tr>
                                                <th>Canceled:</th>
                                                <td>{{ item.updated_at | moment("MMM Do YYYY, h:mm a") }}</td>
                                            </tr>
                                        </table>
                                    </b-card-text>
                                </b-card-body>
                            </b-col>
                        </b-row>
                    </b-card>
                </div>

            </div>
            <div v-else>
                <div class="p-5 my-5">
                    <p class="text-center text-info h1">Sorry !! You have no canceled booking. </p>
                </div>
            </div>

        </div>
        <div v-else>
            <div v-if="dataLoading" class="p-5 my-5">
                <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
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
                currentUrl: '/room/booked',

                imagePath: '/images/room/',
                imagePathSm: '/images/room/small/',

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
