<template>
<div>
    <h3 class="text-muted text-center">---: MRO Retailer Template :---</h3>
     <form @submit.prevent="templateInfoStore()">

            <v-card>

                <v-card-title></v-card-title>
                <v-card-subtitle>Place of production / storage location</v-card-subtitle>

                <v-card-text>
                    <v-text-field v-model="form.storage_1" label="Enter this sections question 1"
                            :class="{ 'is-invalid': form.errors.has('storage_1') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('storage_1')" v-html="form.errors.get('storage_1')" />
                

                
                    <v-text-field v-model="form.storage_2" label="Enter this sections question 2"
                            :class="{ 'is-invalid': form.errors.has('storage_2') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('storage_2')" v-html="form.errors.get('storage_2')" />
                

                
                    <v-text-field v-model="form.storage_3" label="Enter this sections question 3"
                            :class="{ 'is-invalid': form.errors.has('storage_3') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('storage_3')" v-html="form.errors.get('storage_3')" />
                

                
                    <v-text-field v-model="form.storage_4" label="Enter this sections question 4"
                            :class="{ 'is-invalid': form.errors.has('storage_4') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('storage_4')" v-html="form.errors.get('storage_4')" />
                </v-card-text>

            </v-card>


            <v-card>
        
                <v-card-title>Stock planning / control product quality and service</v-card-title>
                <v-card-subtitle>This Sections All Questions</v-card-subtitle>

                <v-card-text>
                    <v-text-field v-model="form.production_qs_1" label="Enter this sections question 1"
                            :class="{ 'is-invalid': form.errors.has('production_qs_1') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('production_qs_1')" v-html="form.errors.get('production_qs_1')" />
                

                
                    <v-text-field v-model="form.production_qs_2" label="Enter this sections question 2"
                            :class="{ 'is-invalid': form.errors.has('production_qs_2') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('production_qs_2')" v-html="form.errors.get('production_qs_2')" />
                

                
                    <v-text-field v-model="form.production_qs_3" label="Enter this sections question 3"
                            :class="{ 'is-invalid': form.errors.has('production_qs_3') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('production_qs_3')" v-html="form.errors.get('production_qs_3')" />
                

                
                    <v-text-field v-model="form.production_qs_4" label="Enter this sections question 4"
                            :class="{ 'is-invalid': form.errors.has('production_qs_4') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('production_qs_4')" v-html="form.errors.get('production_qs_4')" />
                </v-card-text>
                
                
            </v-card>

            <v-card>
                <v-card-title>Safety</v-card-title>
                <v-card-subtitle>This Sections All Questions</v-card-subtitle>

                <v-card-text>
                
                    <v-text-field v-model="form.safety_1" label="Enter this sections question 1"
                            :class="{ 'is-invalid': form.errors.has('safety_1') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('safety_1')" v-html="form.errors.get('safety_1')" />
                

                
                    <v-text-field v-model="form.safety_2" label="Enter this sections question 2"
                            :class="{ 'is-invalid': form.errors.has('safety_2') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('safety_2')" v-html="form.errors.get('safety_2')" />
                

                
                    <v-text-field v-model="form.safety_3" label="Enter this sections question 3"
                            :class="{ 'is-invalid': form.errors.has('safety_3') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('safety_3')" v-html="form.errors.get('safety_3')" />
                

                
                    <v-text-field v-model="form.safety_4" label="Enter this sections question 4"
                            :class="{ 'is-invalid': form.errors.has('safety_4') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('safety_4')" v-html="form.errors.get('safety_4')" />
                </v-card-text>
                
                
            </v-card>

            <v-card>
                <v-card-title>Environment and Surrounding condition</v-card-title>
                <v-card-subtitle>This Sections All Questions</v-card-subtitle>

                <v-card-text>
                
                    <v-text-field v-model="form.env_sur_con_1" label="Enter this sections question 1"
                            :class="{ 'is-invalid': form.errors.has('env_sur_con_1') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('env_sur_con_1')" v-html="form.errors.get('env_sur_con_1')" />
                

                
                    <v-text-field v-model="form.env_sur_con_2" label="Enter this sections question 2"
                            :class="{ 'is-invalid': form.errors.has('env_sur_con_2') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('env_sur_con_2')" v-html="form.errors.get('env_sur_con_2')" />
                

                
                    <v-text-field v-model="form.env_sur_con_3" label="Enter this sections question 3"
                            :class="{ 'is-invalid': form.errors.has('env_sur_con_3') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('env_sur_con_3')" v-html="form.errors.get('env_sur_con_3')" />
                

                
                    <v-text-field v-model="form.env_sur_con_4" label="Enter this sections question 4"
                            :class="{ 'is-invalid': form.errors.has('env_sur_con_4') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('env_sur_con_4')" v-html="form.errors.get('env_sur_con_4')" />
                </v-card-text>
                
            </v-card>

           
            <v-card>
                <v-card-title>To cooperate with the company</v-card-title>
                <v-card-subtitle>This Sections All Questions</v-card-subtitle>

                <v-card-text>
                
                    <v-text-field v-model="form.cooperate_1" label="Enter this sections question 1"
                            :class="{ 'is-invalid': form.errors.has('cooperate_1') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('cooperate_1')" v-html="form.errors.get('cooperate_1')" />
                

                
                    <v-text-field v-model="form.cooperate_2" label="Enter this sections question 2"
                            :class="{ 'is-invalid': form.errors.has('cooperate_2') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('cooperate_2')" v-html="form.errors.get('cooperate_2')" />
                

                
                    <v-text-field v-model="form.cooperate_3" label="Enter this sections question 3"
                            :class="{ 'is-invalid': form.errors.has('cooperate_3') }"></v-text-field>
                    <div class="small text-danger" v-if="form.errors.has('cooperate_3')" v-html="form.errors.get('cooperate_3')" />
                </v-card-text>
                
            </v-card>

            <v-btn block blockdepressed :loading="modalBtnLoading" color="primary mt-3" type="submit">        
                <v-icon left dark>mdi-circle-edit-outline</v-icon> Update           
            </v-btn>

        </form>
</div>
</template>


<script>
    // vform
    import Form from 'vform';
   

    export default {
      
        data() {

            return {

                // current page url
                currentUrl: '/ivca/admin/tempalte',
              
                // Form
                form: new Form({
                    id: '',
                    storage_1: '',
                    storage_2: '',
                    storage_3: '',
                    storage_4: '',

                    production_qs_1: '',
                    production_qs_2: '',
                    production_qs_3: '',
                    production_qs_4: '',

                    safety_1: '',
                    safety_2: '',
                    safety_3: '',
                    safety_4: '',

                    env_sur_con_1: '',
                    env_sur_con_2: '',
                    env_sur_con_3: '',
                    env_sur_con_4: '',

                    cooperate_1: '',
                    cooperate_2: '',
                    cooperate_3: '',
                }),

            }


        },

        methods: {

            templateInfoData(){

                this.form.get( this.currentUrl + '/mro_retailer_data' ).then( response=>{
                    //console.log(response.data)

                    this.form.reset();
                    this.form.fill(response.data);

                }).catch( error=>{
                    console.log(error)
                })
            },

            templateInfoStore(){

                this.form.post( this.currentUrl + '/mro_retailer_store' ).then(response=>{
                    //console.log(response)

                    this.form.reset();
                    this.form.errors.clear();
                    
                    // Refresh Tbl Data with current page
                    this.templateInfoData();
                    this.$Progress.finish();

                    Toast.fire({
                        icon: response.data.icon,
                        title: response.data.msg
                    });

                }).catch(error=>{
                    console.log(error)
                })
            }



        },


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.templateInfoData();
            this.$Progress.finish();
        },



    }

</script>
