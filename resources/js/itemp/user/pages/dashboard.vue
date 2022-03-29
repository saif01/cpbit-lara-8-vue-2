<template>
    <div>

        <div class="h1 text-center pa-5 border_card shadow">
            We keep a temparature record of all employees !!
            iTemp of C.P. Bangladesh !!
        </div>
        <v-row>
            <v-col cols="12" lg="4" >
                <v-card>
                    <v-img
                    class="white--text align-end teal"
                    height="130px"
                    >
                    <div class="d-flex justify-content-between">
                        <v-card-title>Total Employees</v-card-title>
                        
                        <v-card-title v-text="allEmp" class="align-end"></v-card-title>
                    </div>
                    </v-img>
                </v-card>
            </v-col>

            <v-col cols="12" lg="4" >
                <v-card>
                    <v-img
                    class="white--text align-end indigo"
                    height="130px"
                    >
                    <div class="d-flex justify-content-between">
                        <v-card-title>Today Temp Measured</v-card-title>
                        
                        <v-card-title v-text="todayTempRec" class="align-end"></v-card-title>
                    </div>
                    </v-img>
                </v-card>
            </v-col>

            <v-col cols="12" lg="4" >
                <v-card>
                    <v-img
                    class="white--text align-end pink"
                    height="130px"
                    >
                    <div class="d-flex justify-content-between">
                        <v-card-title>Total Temp Rec</v-card-title>
                        
                        <v-card-title v-text="totalTempRec" class="align-end"></v-card-title>
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
            currentUrl : '/itemp/dashboard',
            allEmp: '',
            todayTempRec: '',
            totalTempRec: '',
            totalOtherTempRec: '',

            // allDashboardData
            allDashboardData: '',


            // Chart
            chartShow: false,
            allChartData:{}, 

        }
    },

    methods:{

        getDashboardData(){
            axios.get( '/itemp/admin/dashboard_data').then(response=>{
                this.allEmp = response.data.allEmp

                this.todayTempRec = response.data.todayTempRec

                this.totalTempRec = response.data.totalTempRec

                this.totalOtherTempRec = response.data.totalOtherTempRec
            }).catch(error=>{
                console.log(error)
            })
        },

        getGraphData(){
                axios.get( this.currentUrl+ '/dashboard_graph').then(response=>{
                    this.allDashboardData = response.data

                    let chData = response.data
                    console.log(chData);
                    // For chart
                    if(chData){

                        let chlabels = [];
                        let chdata = [];
                        chData.forEach(item=>{
                           if(item){
                               chlabels.push(item.department)
                           }
                            chdata.push(item.total)
                        })

                        let dataArry = { labels: chlabels, data: chdata }

                        // assign data 
                        this.allChartData = dataArry;
                        this.chartShow = true;
                    }

                }).catch(error=>{
                    console.log(error)
                })
            },

     
    },

    created(){
        this.getDashboardData();
        this.getGraphData();
    
    }
}
</script>


<style scoped>
.border_card{
    border:5px solid transparent;
    border-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg'%3E %3Cstyle%3Epath%7Banimation:stroke 10s infinite linear%3B%7D%40keyframes stroke%7Bto%7Bstroke-dashoffset:776%3B%7D%7D%3C/style%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%232d3561' /%3E%3Cstop offset='25%25' stop-color='%23c05c7e' /%3E%3Cstop offset='50%25' stop-color='%23f3826f' /%3E%3Cstop offset='100%25' stop-color='%23ffb961' /%3E%3C/linearGradient%3E %3Cpath d='M1.5 1.5 l97 0l0 97l-97 0 l0 -97' stroke-linecap='square' stroke='url(%23g)' stroke-width='3' stroke-dasharray='388'/%3E %3C/svg%3E") 1;
    
}
</style>

