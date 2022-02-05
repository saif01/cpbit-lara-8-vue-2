<template>
        <div>
        <div class=" col-12 background_color d-flex justify-content-center align-items-center p-0">
            <div class="box-shadow col-lg-10 col-11 m-auto py-5">
                <div class="h2 text-center mt-2">Template Selection</div>
                <div class="d-flex flex-column adjust-gap pb-2">
                    <div>
                        <div class="col-12 col-lg-10 m-auto" @click="selectValueSet('mro_manufacturer')">
                            <div class="d-flex justify-content-between p-3 select-hover border-select">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            class="form-check-input"
                                            name="radio"
                                            v-model="template"
                                            value="mro_manufacturer"
                                        />
                                        Supplier Manufacturer
                                    </label>
                                </div>
                                <div>
                                    <img
                                        src="/css/ivca/frontend/img/manufactur.svg"
                                        alt="image"
                                        class="img-fluid images"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="col-12 col-lg-10 m-auto" @click="selectValueSet('mro_importer')">
                            <div
                                class="
                                    d-flex
                                    justify-content-between
                                    p-3
                                    select-hover
                                    border-select
                                "
                            >
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            class="form-check-input"
                                            name="radio"
                                            v-model="template"
                                            value="mro_importer"
                                        />
                                        Importer and Traders
                                    </label>
                                </div>
                                <div>
                                    <img
                                        src="/css/ivca/frontend/img/importer.svg"
                                        alt="image"
                                        class="img-fluid images"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="col-12 col-lg-10 m-auto" @click="selectValueSet('mro_retailer')">
                            <div
                                class="
                                    d-flex
                                    justify-content-between
                                    p-3
                                    select-hover
                                    border-select
                                "
                            >
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            id="temp3"
                                            class="form-check-input"
                                            name="radio"
                                            v-model="template"
                                            value="mro_retailer"
                                        />
                                        Supplier for Retailer
                                    </label>
                                </div>
                                <div>
                                    <img
                                        src="/css/ivca/frontend/img/retailer.svg"
                                        alt="image"
                                        class="img-fluid images"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mx-auto">
                        <v-btn @click="startAudit()" color="info" class="mt-2"
                        ><v-icon>mdi-check-circle-outline</v-icon> Choose Audit Template</v-btn>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
</template>

<script>
export default {

    data(){
        return{

            // current page url
            currentUrl: '/ivca/mro',
            template: '',
            token: '',

        }
    },

    methods:{

        tokenData(){

            axios.post(this.currentUrl+ '/token/data',{
                token: this.$route.query.token
            }).then(response=>{
                
                // Success
                if(response.data.status == 'Success'){
                    console.log(response.data)
                    this.token  = response.data.allData.token

                    // check template selected and audit status 1
                    if( response.data.allData.template.length > 0  && response.data.allData.audit_status == 1 ){
                        // Redirect
                        this.$router.push({
                            name:'ivca_mro_audit_questions', 
                            query: { 
                                token: response.data.allData.token, 
                            } 
                        })
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
                console.log(error)
            })

        },

        // selectValueSet
        selectValueSet(val){
            this.template = val
            console.log('template', this.template)
        },

        // Start Audit
        startAudit(){

            // Not template any template
            if(this.template.length <= 0){
                Swal.fire({
                    icon: 'error',
                    title: 'Error !!',
                    text: 'Please, choose one template for start audit',  
                })
            }else{

                axios.post(this.currentUrl + '/token/tempplate_update',{
                    token: this.token,
                    template: this.template,
                }).then(response=>{

                    if(response.data.status == 'Success'){
                        // Redirect
                        this.$router.push({
                            name:'ivca_mro_audit_questions', 
                            query: { 
                                token: response.data.token, 
                            } 
                        })

                    }else{
                        // Error
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,  
                        })
                    }

                }).catch(error=>{
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Sorry! Somthing going wrong',  
                    })
                    console.log(error)
                })

               
            }


           // console.log('template', this.template, this.token)

        }

    },
    

    created(){
        //console.log('The id is: ' + $router.params.id) 

        console.log('The id is: ' + this.$route.query.token );

        // Data get by token
        this.tokenData()
    }
}
</script>


<style scoped>
.background_color {
    background: #16222a;
    background: -webkit-linear-gradient(to right, #3a6073, #16222a);
    background: linear-gradient(to right, #3a6073, #16222a);

    height: 100vh;
}
.box-shadow {
    color: white;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    /* height: 50vh; */
}
.border-select {
    border: 2px solid #4389a2;
    border-radius: 12px;
}
.select-hover {
    transition: 0.2s;
}
.select-hover:hover {
    background-color: #4389a2;
}
.images {
    height: 30px;
    width: 30px;
}
.adjust-gap > div {
    margin: 0.3rem 0;
}

</style>