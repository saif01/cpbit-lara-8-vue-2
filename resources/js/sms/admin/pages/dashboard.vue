<template>
    <div>
       <h1 class="text-center">SMS Admin Dashboard</h1>

        <v-row>
            <v-col cols="4">
                <v-card class="bg_card">
                    <v-card-text class="h5 white--text">
                        <div class="d-flex justify-content-between">
                            Total SMS Operations
                            <span>
                                <v-icon color="white" size="40">mdi-cellphone-message</v-icon>
                                {{ allDashboardData.allOperation }}
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

            <v-col cols="4">
                <v-card class="bg_card">
                    <v-card-text class="h5 white--text">
                        <div class="d-flex justify-content-between">
                            Total SMS User
                            <span>
                                <v-icon color="white" size="40">mdi-account-group</v-icon>
                                {{ allDashboardData.allRoleUser }}/ {{ allDashboardData.allUser}}
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

            <v-col cols="4">
                <v-card class="bg_card_3">
                    <v-card-text class="h5 white--text">
                        <div class="d-flex justify-content-between">
                            Total SMS Admin
                            <span>
                                <v-icon color="white" size="40">mdi-account-tie</v-icon>
                                {{ allDashboardData.allRoleAdmin }}/ {{ allDashboardData.allUser}}
                            </span>
                        </div>
                        <v-progress-linear
                        class="mt-7"
                        v-model="allDashboardData.adminPercent"
                        color="pink darken-1"
                        height="25"
                        rounded
                        >
                        <template v-slot col>
                            <strong class="white--text">{{ Math.ceil(allDashboardData.adminPercent) }}%</strong>
                        </template>
                        </v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

    </div>
</template>

<script>
import axios from 'axios';


export default {

    data(){
        return{

            //current page url
            currentUrl: '/sms/admin',
            allDashboardData: '',
            value: '100',
        }
    },

    methods:{
        getDashboardData(){
            axios.get( this.currentUrl+ '/dashboard_data').then(response=>{
                //console.log(response.data)
                this.allDashboardData = response.data

            }).catch(error=>{
                console.log(error)
            })
        }

    },

    created(){
        this.$Progress.start();

        this.getDashboardData()
        //console.log('SMS Admin Dashboard')
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

.bg_card_3{
    background: linear-gradient(120deg, rgb(130, 106, 92) 60%, rgb(80, 88, 102) 40%);
    border:5px solid transparent;
    border-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg'%3E %3Cstyle%3Epath%7Banimation:stroke 10s infinite linear%3B%7D%40keyframes stroke%7Bto%7Bstroke-dashoffset:776%3B%7D%7D%3C/style%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%232d3561' /%3E%3Cstop offset='25%25' stop-color='%23c05c7e' /%3E%3Cstop offset='50%25' stop-color='%23f3826f' /%3E%3Cstop offset='100%25' stop-color='%23ffb961' /%3E%3C/linearGradient%3E %3Cpath d='M1.5 1.5 l97 0l0 97l-97 0 l0 -97' stroke-linecap='square' stroke='url(%23g)' stroke-width='3' stroke-dasharray='388'/%3E %3C/svg%3E") 1;
   
}
</style>

