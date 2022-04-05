<template>
    <div>
      
        <div>
            <v-alert color="info" class="text-center h2" show>Token: <b class="spacing">{{ token }}</b></v-alert>
        </div>

        

        <div v-if="auditQuestionsShowLoading" class="p-5 my-5">
            <p class="text-center"><v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon></p>
        </div>
        <div v-else>
            <!-- mro-manufacturer-template -->
            <mro-manufacturer-template v-if="currentTemplate == 'mro_manufacturer'" :token="token" :iamgeUploadAccess="iamgeUploadAccess" ></mro-manufacturer-template>

            <!-- mro-importer-template -->
            <mro-importer-template v-if="currentTemplate == 'mro_importer'" :token="token" :iamgeUploadAccess="iamgeUploadAccess" ></mro-importer-template>

            <!-- mro-retailer-template -->
            <mro-retailer-template v-if="currentTemplate == 'mro_retailer'" :token="token" :iamgeUploadAccess="iamgeUploadAccess" ></mro-retailer-template>
        </div>
       

       



    </div>
</template>

<script>

import mroManufacturerTemplate from './templates/mro-manufacturer.vue' 
import mroImporterTemplate from './templates/mro-importer.vue' 
import mroRetailerTemplate from './templates/mro-retailer.vue' 


export default {

    components:{
      'mro-manufacturer-template' : mroManufacturerTemplate,
      'mro-importer-template'     : mroImporterTemplate,
      'mro-retailer-template'     : mroRetailerTemplate
    },

    data(){
        return{

            // current page url
            currentUrl: '/ivca/mro/audit',

            token: this.$route.query.token,
            userType: '',
           
            currentTemplate:'', 

            imageMaxSize: '5111775',
            imagePath: '/images/ivca/',
            imagePathSm: '/images/ivca/small/',

            iamgeUploadAccess: false,
            auditQuestionsShowLoading : true

        }
    },

    methods:{

        auditTempalteData(){

            axios.post(this.currentUrl+ '/tempalte_data',{
                token: this.token
            }).then(response=>{
                // auditQuestionsShowLoading
                this.auditQuestionsShowLoading = false
                
                // Success
                if(response.data.status == 'Success'){
                    console.log(response.data)

                    this.currentTemplate = response.data.allData.template
                   
                    // Check Auditor
                    if(response.data.allData.schedule){
                        if(response.data.allData.schedule.user_id == this.auth.id){
                            this.iamgeUploadAccess = true
                        }
                    }

                }else{
                    // Error
                    Swal.fire({
                        icon: response.data.icon,
                        title: response.data.status,
                        text: response.data.msg,  
                    })
                    // Redirect route
                    this.$router.push({ name:'ivca_dashboard' })
                }


            }).catch(error=>{
                // auditQuestionsShowLoading
                this.auditQuestionsShowLoading = false
                // Error
                Swal.fire({
                    icon: 'error',
                    title: 'Error !!',
                    text: 'Sorry! Somthing going wrong',  
                })
                console.log(error)
            })

        },

       

    },
    

    created(){
        //console.log('The id is: ' + $router.params.id) 

        // console.log('Url Data: ' + this.token, this.isAuditor(), this.isUser());

        // Data get by token
        this.auditTempalteData()
        

    }
}
</script>