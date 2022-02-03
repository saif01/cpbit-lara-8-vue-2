<template>
    <div>
       <h1>SMS Admin</h1>


       
    </div>
</template>

<script>
import axios from 'axios';


export default {

    data(){
        return{

            //current page url
            currentUrl: '/sms/admin',
            allDashboardData: ''
        }
    },

    methods:{
        getDashboardData(){
            axios.get( this.currentUrl+ '/').then(response=>{

                console.log(response.data)
                this.allDashboardData = response.data

            }).catch(error=>{
                console.log(error)
            })
        }

    },

    created(){
        this.$Progress.start();
        console.log('SMS Admin Dashboard')
        this.$Progress.finish();
    }
}
</script>

