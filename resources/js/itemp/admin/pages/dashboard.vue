<template>
    <div>
        <v-row>
            <v-col cols="12" lg="3" >
                <v-card>
                    <v-img
                    class="white--text align-end teal"
                    height="200px"
                    >
                    <div class="d-flex justify-content-between">
                        <v-card-title>Total Employees</v-card-title>
                        
                        <v-card-title v-text="allEmp" class="align-end"></v-card-title>
                    </div>
                    </v-img>
                </v-card>
            </v-col>

            <v-col cols="12" lg="3" >
                <v-card>
                    <v-img
                    class="white--text align-end indigo"
                    height="200px"
                    >
                    <div class="d-flex justify-content-between">
                        <v-card-title>Today Temp Measured</v-card-title>
                        
                        <v-card-title v-text="todayTempRec" class="align-end"></v-card-title>
                    </div>
                    </v-img>
                </v-card>
            </v-col>

            <v-col cols="12" lg="3" >
                <v-card>
                    <v-img
                    class="white--text align-end pink"
                    height="200px"
                    >
                    <div class="d-flex justify-content-between">
                        <v-card-title>Total Temp Rec</v-card-title>
                        
                        <v-card-title v-text="totalTempRec" class="align-end"></v-card-title>
                    </div>
                    </v-img>
                </v-card>
            </v-col>
            
            <v-col cols="12" lg="3" >
                <v-card>
                    <v-img
                    class="white--text align-end orange"
                    height="200px"
                    >
                    <div class="d-flex justify-content-between">
                        <v-card-title>Total Other Rec.</v-card-title>
                        
                        <v-card-title v-text="totalOtherTempRec" class="align-end"></v-card-title>
                    </div>
                    </v-img>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>



export default {
   
    data(){
        return{
            // current Url
            currentUrl : '/itemp/admin',
            allEmp: '',
            todayTempRec: '',
            totalTempRec: '',
            totalOtherTempRec: '',

        }
    },

    methods:{

        getDashboardData(){
            axios.get( this.currentUrl + '/dashboard_data').then(response=>{
                console.log(response.data)
                this.allEmp = response.data.allEmp

                this.todayTempRec = response.data.todayTempRec

                this.totalTempRec = response.data.totalTempRec

                this.totalOtherTempRec = response.data.totalOtherTempRec
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

