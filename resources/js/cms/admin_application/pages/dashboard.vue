<template>
    <div class="pa-2">
        <v-row>
            <v-col cols="12" lg="4">
                <v-card class="bg_card">
                    <v-card-text class="h5 white--text">
                        <div class="d-flex justify-content-between">
                            Total Softwares
                            <span>
                                <v-icon color="white" size="40">mdi-cellphone-message</v-icon>
                                {{ allDashboardData.totalCategory }}
                            </span>
                        </div>
                        <v-progress-linear
                        class="mt-7"
                        v-model="value"
                        color="indigo"
                        height="25"
                        rounded
                        >
                        <template v-slot:default="{ value }">
                            <strong class="white--text">{{ Math.ceil(value) }}%</strong>
                        </template>
                        </v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" lg="4">
                <v-card class="bg_card">
                    <v-card-text class="h5 white--text">
                        <div class="d-flex justify-content-between">
                            Total Modules
                            <span>
                                <v-icon color="white" size="40">mdi-cellphone-message</v-icon>
                                {{ allDashboardData.totalSubcategory }}
                            </span>
                        </div>
                        <v-progress-linear
                        class="mt-7"
                        v-model="value"
                        color="indigo"
                        height="25"
                        rounded
                        >
                        <template v-slot:default="{ value }">
                            <strong class="white--text">{{ Math.ceil(value) }}%</strong>
                        </template>
                        </v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" lg="4">
                <v-card class="bg_card">
                    <v-card-text class="h5 white--text">
                        <div class="d-flex justify-content-between">
                            Total CMS User
                            <span>
                                <v-icon color="white" size="40">mdi-account-group</v-icon>
                                {{ allDashboardData.totalRoleUser }}/ {{ allDashboardData.totalUser}}
                            </span>
                        </div>
                        <v-progress-linear
                        class="mt-7"
                        v-model="allDashboardData.userPercent"
                        color="info"
                        height="25"
                        rounded
                        >
                        <template v-slot>
                            <strong class="white--text">{{ Math.ceil(allDashboardData.userPercent) }}%</strong>
                        </template>
                        </v-progress-linear>
                    </v-card-text>
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

        data() {
            return {

                //current page url
                currentUrl: '/cms/a_admin',
                allDashboardData: '',
                value: '100',

                // allChartData:{
                //     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                //     data: [60, 40, 20, 50, 90, 10, 20, 40, 50, 70, 90, 100],
                // }

                // Chart
                chartShow: false,
                allChartData:{}, 
            }
        },

        methods: {

            getDashboardData(){
                axios.get( this.currentUrl+ '/dashboard_data').then(response=>{
                    //console.log(response.data)
                    this.allDashboardData = response.data

                    let chData = response.data.chartData
                    // For chart
                    if(chData){

                        let chlavels = [];
                        let chdata = [];
                        chData.forEach(item=>{
                           if(item.category){
                               chlavels.push(item.category.name)
                           }
                           chdata.push(item.total)
                           // console.log('item', item.total, item.category.name)
                        })

                        let dataArry = { labels: chlavels, data: chdata }
                        // assign dara 
                        this.allChartData = dataArry;
                        this.chartShow = true;
                        // console.log(this.allChartData)
                    }

                }).catch(error=>{
                    console.log(error)
                })
            },


        },

        created() {
            this.$Progress.start();
            this.getDashboardData()
            this.$Progress.finish();
        }
    }

</script>


<style scoped>


.bg_card{
    background: linear-gradient(120deg, rgb(155, 198, 159) 60%, rgb(137, 168, 227) 40%);
    border:5px solid transparent;
    border-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg'%3E %3Cstyle%3Epath%7Banimation:stroke 10s infinite linear%3B%7D%40keyframes stroke%7Bto%7Bstroke-dashoffset:776%3B%7D%7D%3C/style%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%232d3561' /%3E%3Cstop offset='25%25' stop-color='%23c05c7e' /%3E%3Cstop offset='50%25' stop-color='%23f3826f' /%3E%3Cstop offset='100%25' stop-color='%23ffb961' /%3E%3C/linearGradient%3E %3Cpath d='M1.5 1.5 l97 0l0 97l-97 0 l0 -97' stroke-linecap='square' stroke='url(%23g)' stroke-width='3' stroke-dasharray='388'/%3E %3C/svg%3E") 1;
    
}

</style>

