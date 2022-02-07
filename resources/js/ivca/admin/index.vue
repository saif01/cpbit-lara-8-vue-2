<template>
    <v-app>

        <side-bar></side-bar>
            <v-main>
                <v-container fluid>
                    <router-view></router-view>
                </v-container>
            </v-main>
        <page-footer></page-footer>

    </v-app>
</template>

<script>

import sideBar from './pages/common/sidebar.vue';
import pageFooter from './pages/common/footer.vue'


export default ({
    props: ['authuser', 'permission'],

    components:{
       'side-bar'      : sideBar,
       'page-footer'   : pageFooter,
    },
    
    data(){
       return {
          
       }

    },

   methods: {

        filter(singleRole) {
            return this.role.includes(singleRole)
        },


       
        checkRole2(roleVal){

            if(this.role){
                console.log('roleCheck if')
                let result = false;

                    this.role.filter(function (element) {
                    
                        console.log('roleCheck filter', element.name)
                        if(element.name == roleVal){
                            console.log('Found')
                            //result= true ;
                        }

                    })

                return result;

            }else{
                console.log('roleCheck else')
                return false;
            }
        
        },
       
   },

  

    mounted() {
       //console.log('index component', this.user, this.role)

       //this.checkRole2('Administrator')

      //console.log('filter', this.checkSingleRole('Ivca-admin'), this.isAdministrator() ) 
    },
   
    created() {
        this.$store.commit('setAuth', JSON.parse(this.authuser) )
        this.$store.commit('setRoles', JSON.parse(this.permission) )

        this.$Progress.start();

        console.log('main iVCA_app created', this.auth)
        this.$Progress.finish();
    },


})
</script>



