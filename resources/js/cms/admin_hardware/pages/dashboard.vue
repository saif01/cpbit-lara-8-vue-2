<template>
    <div>

        <v-row>
            <v-col cols="12" lg="4">
                <v-card class="bg_card">
                    <v-card-text class="h5 white--text">
                        <div class="d-flex justify-content-between">
                            Total Complain
                            <span>
                                <v-icon color="white" size="40">mdi-cellphone-message</v-icon>
                                {{ dashboardData.allComplain }}
                            </span>
                        </div>
                        <!-- <v-progress-linear
                        class="mt-7"
                        v-model="value"
                        color="indigo"
                        height="25"
                        rounded
                        >
                        <template v-slot:default="{ value }">
                            <strong class="white--text">{{ Math.ceil(value) }}%</strong>
                        </template>
                        </v-progress-linear> -->
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" lg="4">
                <v-card class="bg_card">
                    <v-card-text class="h5 white--text">
                        <div class="d-flex justify-content-between">
                            Total Processing Complain
                            <span>
                                <v-icon color="white" size="40">mdi-cellphone-message</v-icon>
                                {{ dashboardData.allProcessingComplain }}
                            </span>
                        </div>
                        <!-- <v-progress-linear
                        class="mt-7"
                        v-model="value"
                        color="indigo"
                        height="25"
                        rounded
                        >
                        <template v-slot:default="{ value }">
                            <strong class="white--text">{{ Math.ceil(value) }}%</strong>
                        </template>
                        </v-progress-linear> -->
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" lg="4">
                <v-card class="bg_card">
                    <v-card-text class="h5 white--text">
                        <div class="d-flex justify-content-between">
                            Total Closed Complain
                            <span>
                                <v-icon color="white" size="40">mdi-cellphone-message</v-icon>
                                {{ dashboardData.allClosedComplain }}
                            </span>
                        </div>
                        <!-- <v-progress-linear
                        class="mt-7"
                        v-model="value"
                        color="indigo"
                        height="25"
                        rounded
                        >
                        <template v-slot:default="{ value }">
                            <strong class="white--text">{{ Math.ceil(value) }}%</strong>
                        </template>
                        </v-progress-linear> -->
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <h3 class="my-5">Category Wise Complain</h3>

        
        <div v-if="productWiseComplain.length > 0">
            <v-row>
                    <v-col cols="12" lg="3" v-for="(item, index) in productWiseComplain" :key="index">
                <v-card>
                    <v-img class="white--text align-end indigo" height="50px">
                        <div class="d-flex justify-content-between">
                            <v-card-title v-text="item.category.name"></v-card-title>

                            <v-card-title v-text="item.total" class="align-end"></v-card-title>
                        </div>
                    </v-img>
                </v-card>
            </v-col>
            </v-row>
            
        </div>
        <div v-if="!overlay && productWiseComplain.length <= 0" class="m-auto">
            <p class="text-center h3 text-danger"> Complain Data Not Available </p>
        </div>
        

        <h3 class="my-5">Damage Wise Complain</h3>
        <div v-if="damageWiseComplain.length > 0">
            <v-row>
                <v-col cols="12" lg="3" v-for="(item, index) in damageWiseComplain" :key="index">
                    <v-card>
                        <v-img class="white--text align-end indigo" height="50px">
                            <div class="d-flex justify-content-between">
                                <v-card-title v-text="item.damaged_type"></v-card-title>

                                <v-card-title v-text="item.total" class="align-end"></v-card-title>
                            </div>
                        </v-img>
                    </v-card>
                </v-col>
            </v-row>
        </div>
        <div v-if="!overlay && productWiseComplain.length <= 0" class="m-auto">
            <p class="text-center h3 text-danger"> Complain Data Not Available </p>
        </div>

        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>

    </div>
</template>

<script>
    export default {

        data() {
            return {
                // current Url
                currentUrl: '/cms/h_admin',
                productWiseComplain: '',
                allComplain: '',
                damageWiseComplain: '',
                value: '100',
                dashboardData: '',



            }
        },

        methods: {
            getDashboardData() {
                this.overlay = true
                axios.get(this.currentUrl + '/dashboard_data').then(response => {

                    this.overlay = false
                    this.productWiseComplain = response.data.productWiseComplain
                    this.dashboardData = response.data

                    this.damageWiseComplain = response.data.damageWiseComplain

                    console.log(damageWiseComplain);


                    // let chData = response.data.chartData
                    // // For chart
                    // if(chData){

                    //     let chlabels = [];
                    //     let chdata = [];
                    //     chData.forEach(item=>{
                    //         if(item.category){
                    //             chlabels.push(item.category.name)
                    //         }
                    //         chdata.push(item.total)
                    //         // console.log('item', item.total, item.category.name)
                    //     })

                    //     let dataArry = { labels: chlabels, data: chdata }
                    //     // assign dara 
                    //     this.allChartData = dataArry;
                    //     this.chartShow = true;
                    //     // console.log(this.allChartData)
                    // }
                }).catch(error => {
                    this.overlay = false
                    console.log(error)
                })
            }


        },

        created() {

            this.$Progress.start();
            this.getDashboardData()
            this.$Progress.finish();
        }
    }

</script>



<style scoped>
    .bg_card {
        background: linear-gradient(120deg, rgb(155, 198, 159) 60%, rgb(137, 168, 227) 40%);
        border: 5px solid transparent;
        border-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg'%3E %3Cstyle%3Epath%7Banimation:stroke 10s infinite linear%3B%7D%40keyframes stroke%7Bto%7Bstroke-dashoffset:776%3B%7D%7D%3C/style%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%232d3561' /%3E%3Cstop offset='25%25' stop-color='%23c05c7e' /%3E%3Cstop offset='50%25' stop-color='%23f3826f' /%3E%3Cstop offset='100%25' stop-color='%23ffb961' /%3E%3C/linearGradient%3E %3Cpath d='M1.5 1.5 l97 0l0 97l-97 0 l0 -97' stroke-linecap='square' stroke='url(%23g)' stroke-width='3' stroke-dasharray='388'/%3E %3C/svg%3E") 1;

    }

</style>
