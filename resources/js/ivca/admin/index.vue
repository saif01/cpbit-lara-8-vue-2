<template>
<v-app>

    
    <sidebar></sidebar>

    <v-main>
        <v-container fluid>
            <router-view></router-view>
        </v-container>
    </v-main>

    <footer-bar></footer-bar>

</v-app>
   
</template>

<script>
import { mapGetters } from 'vuex'
import footer from './pages/common/footer.vue'
import sidebar from './pages/common/sidebar.vue';



export default ({
    props: ['authuser', 'permission'],

    components:{
        "footer-bar":footer,
        sidebar,
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
        //this.$store.commit('setUser', JSON.parse(this.authuser) )
        //this.$store.commit('setRole', JSON.parse(this.permission) )

        this.$Progress.start();

        // console.log('main iVCA_app created', this.authuser)
        this.$Progress.finish();
    },


})
</script>



