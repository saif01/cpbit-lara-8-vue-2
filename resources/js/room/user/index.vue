<template>
    <div>
        <nav-bar></nav-bar>
          
        <div class="container p-0">
            <main class="content-wrapper">
                <div class="container-fluid p-0">
                
                    <router-view></router-view>
                    <vue-progress-bar></vue-progress-bar>
                
                </div>
            </main>
        </div>
        <page-footer></page-footer>
      
    </div>
</template>

<script>

import navBar from './pages/common/navbar.vue'
import pageFooter from './pages/common/footer.vue'


export default {

    props: ['authuser', 'permission'],

    components:{
       'nav-bar'        : navBar,
       'page-footer'    : pageFooter,
    },

    data(){
        return{
            response: false,
            
        }
    },

    methods:{

    

       
    },

   

    created(){

        // Set Auth and Role data in Store
        this.$store.commit('setAuth', JSON.parse(this.authuser) )
        this.$store.commit('setRoles', JSON.parse(this.permission) )

        this.$Progress.start();

        //checkUserRole
      
       // console.log('Index, auth user', JSON.parse(this.authuser));

        //console.log('Role: ', this.isAdministrator(), this.isAnyRole(['Administrator', 'Ivca']), this.isRole('Administrator') )

        this.$Progress.finish();  
    }
    
}
</script>

<style lang="scss">

</style>

