<template>
    <v-app>
       <router-view></router-view>
       <vue-progress-bar></vue-progress-bar>
    </v-app>
</template>

<script>
   
    export default {
        data() {
            return {
               
                
            }
        },
        methods: {
           
        },

        created() {

            this.$Progress.start();

            console.log('CPBIT-Login')

            this.$Progress.finish();
        }


    }
</script>

