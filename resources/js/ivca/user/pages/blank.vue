<template>
    <div>
       <p>Blank</p>
       
    </div>
</template>

<script>
export default {
   // props: ['token'],

    created(){
        // console.log('blank token ', this.token)

        console.log('blank token ', this.$route.query.token)

        
    }

}
</script>