<template>
    <div>
        <h3>Remaining Stock</h3>
        <v-row>
            <v-col cols="12" lg="3"  v-for="(item, index) in allDashboardData" :key="index">
                <v-card>
                    <v-img
                    class="white--text align-end teal"
                    height="150px"
                    >
                    <div class="d-flex justify-content-between">
                        <v-card-title v-text="item.category.name"></v-card-title>
                        
                        <v-card-title v-text="item.total" class="align-end"></v-card-title>
                    </div>
                    </v-img>
                </v-card>
            </v-col>
        </v-row>

        <h3 class="text-center">Operation Wise Product</h3>

        <v-row>
            <v-col cols="12" lg="3"  v-for="(item, index) in operationWise" :key="index">
                <v-card>
                    <v-img
                    class="white--text align-end indigo"
                    height="150px"
                    >
                    <div class="d-flex justify-content-between">
                        <v-card-title v-text="item.operation.name"></v-card-title>
                        
                        <v-card-title v-text="item.total" class="align-end"></v-card-title>
                    </div>
                    </v-img>
                </v-card>
            </v-col>
        </v-row>

        <!-- Chart -->
        <v-row>
            <v-col cols="12">
                <pai-chart v-if="chartShow" :chartData="allChartData" ></pai-chart>
                <div v-if="!chartShow" class="p-5 my-5">
                    <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon></p>
                </div>
            </v-col>
        </v-row>
    </div>
</template>

<script>

import paiChart from './chart/pai.vue'

export default {

    components:{
        paiChart,
    },
   
    data(){
        return{
            // current Url
            currentUrl : '/inventory/admin',
            allDashboardData : '',

            operationWise: '',


            // Chart
            chartShow: false,
            allChartData:{}, 

           
        }
    },

    methods:{

        getDashboardData(){
            axios.get( this.currentUrl + '/dashboard_data').then(response=>{
                console.log(response.data)
                this.allDashboardData = response.data.remainProduct
                this.operationWise = response.data.operationWiseProduct


                let chData = response.data.chartData
                // For chart
                if(chData){

                    let chlabels = [];
                    let chdata = [];
                    chData.forEach(item=>{
                        if(item.category){
                            chlabels.push(item.category.name)
                        }
                        chdata.push(item.total)
                        // console.log('item', item.total, item.category.name)
                    })

                    let dataArry = { labels: chlabels, data: chdata }
                    // assign dara 
                    this.allChartData = dataArry;
                    this.chartShow = true;
                    // console.log(this.allChartData)
                }
            }).catch(error=>{
                console.log(error)
            })
        }

     
    },

    created(){
        this.getDashboardData()
    
    }
}
</script>

