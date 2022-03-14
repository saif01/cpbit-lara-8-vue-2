<template>
    <div>
        <v-card>
            <v-card-title>
                Remaining Stock:
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12" lg="3"  v-for="(item, index) in allDashboardData" :key="index">
                       {{ item.category.name }} : <b>{{ item.total }}</b>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>



export default {
   
    data(){
        return{
            // current Url
            currentUrl : '/inventory/admin',
            allDashboardData : '',
           
        }
    },

    methods:{

        getDashboardData(){
            axios.get( this.currentUrl + '/dashboard_data').then(response=>{
                console.log(response.data)
                this.allDashboardData = response.data.remainProduct
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

