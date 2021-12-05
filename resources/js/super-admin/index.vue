<template>
    <div>
        
    </div>
</template>

<script>



export default {

    props:['authuser'],

    components:{
       
    },

    data(){
        return{
            auth: JSON.parse(this.authuser),

          
        }
    },

    methods:{

      

       
    },

    created(){

        this.$Progress.start();

        //checkUserRole
      
        console.log('auth user', this.auth);

        this.$Progress.finish();  
    }
    
}
</script>

