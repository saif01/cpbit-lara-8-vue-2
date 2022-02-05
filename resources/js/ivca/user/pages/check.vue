<template>
    <div>
        <h1>Check</h1>
    </div>
</template>

<script>
export default {

    data(){
        return{

            // current page url
            currentUrl: '/ivca/audit',

        }
    },

    methods:{

        checkToken(){

            axios.post(this.currentUrl+ '/token_data',{
                token: this.$route.query.token
            }).then(response=>{
                console.log(response.data)


            }).catch(error=>{
                console.log(error)
            })

        }

    },
    

    created(){
        //console.log('The id is: ' + $router.params.id)

        console.log('The id is: ' + this.$route.query.token );

        this.checkToken()
    }
}
</script>