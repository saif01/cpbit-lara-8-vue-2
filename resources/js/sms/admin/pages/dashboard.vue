<template>
    <div>
       <h1>SMS Admin</h1>


       
    </div>
</template>

<script>


export default {

    created(){
        this.$Progress.start();
        console.log('SMS Admin Dashboard')
        this.$Progress.finish();
    }
}
</script>

