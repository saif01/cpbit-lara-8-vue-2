<template>
<div>
    <h3 class="text-muted text-center">---: Food Template :---</h3>
     <form @submit.prevent="templateInfoStore()">


            <v-card>
                
                <v-card-title>1. Building and facilities</v-card-title>
                <v-card-subtitle>This Sections All Questions</v-card-subtitle>

                <v-card-text>
                    <v-textarea outlined v-model="form.building_facilities_a" label="Enter this sections question a"
                            :class="{ 'is-invalid': form.errors.has('building_facilities_a') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('building_facilities_a')" v-html="form.errors.get('building_facilities_a')" />
                

                
                    <v-textarea outlined v-model="form.building_facilities_b" label="Enter this sections question b"
                            :class="{ 'is-invalid': form.errors.has('building_facilities_b') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('building_facilities_b')" v-html="form.errors.get('building_facilities_b')" />
                

                
                    <v-textarea outlined v-model="form.building_facilities_c" label="Enter this sections question c"
                            :class="{ 'is-invalid': form.errors.has('building_facilities_c') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('building_facilities_c')" v-html="form.errors.get('building_facilities_c')" />
                

                
                    <v-textarea outlined v-model="form.building_facilities_d" label="Enter this sections question d"
                            :class="{ 'is-invalid': form.errors.has('building_facilities_d') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('building_facilities_d')" v-html="form.errors.get('building_facilities_d')" />
                

                
                    <v-textarea outlined v-model="form.building_facilities_e" label="Enter this sections question e"
                            :class="{ 'is-invalid': form.errors.has('building_facilities_e') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('building_facilities_e')" v-html="form.errors.get('building_facilities_e')" />
                </v-card-text>

            </v-card>

            <v-card>
        
                <v-card-title>2. Equipment</v-card-title>
                <v-card-subtitle>This Sections All Questions</v-card-subtitle>

                <v-card-text>
                    <v-textarea outlined v-model="form.equipment_a" label="Enter this sections question a"
                            :class="{ 'is-invalid': form.errors.has('equipment_a') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('equipment_a')" v-html="form.errors.get('equipment_a')" />
                

                
                    <v-textarea outlined v-model="form.equipment_b" label="Enter this sections question b"
                            :class="{ 'is-invalid': form.errors.has('equipment_b') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('equipment_b')" v-html="form.errors.get('equipment_b')" />
                

                
                    <v-textarea outlined v-model="form.equipment_c" label="Enter this sections question c"
                            :class="{ 'is-invalid': form.errors.has('equipment_c') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('equipment_c')" v-html="form.errors.get('equipment_c')" />
                </v-card-text>

            </v-card>

            <v-card>
        
                <v-card-title>3. Personnel</v-card-title>
                <v-card-subtitle>This Sections All Questions</v-card-subtitle>

                <v-card-text>
                    <v-textarea outlined v-model="form.personnel_a" label="Enter this sections question a"
                            :class="{ 'is-invalid': form.errors.has('personnel_a') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('personnel_a')" v-html="form.errors.get('personnel_a')" />
                

                
                    <v-textarea outlined v-model="form.personnel_b" label="Enter this sections question b"
                            :class="{ 'is-invalid': form.errors.has('personnel_b') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('personnel_b')" v-html="form.errors.get('personnel_b')" />
                

                
                    <v-textarea outlined v-model="form.personnel_c" label="Enter this sections question c"
                            :class="{ 'is-invalid': form.errors.has('personnel_c') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('personnel_c')" v-html="form.errors.get('personnel_c')" />
                </v-card-text>

            </v-card>

            <v-card>
        
                <v-card-title>4. Raw Materials</v-card-title>
                <v-card-subtitle>This Sections All Questions</v-card-subtitle>

                <v-card-text>
                    <v-textarea outlined v-model="form.raw_materials_a" label="Enter this sections question a"
                            :class="{ 'is-invalid': form.errors.has('raw_materials_a') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('raw_materials_a')" v-html="form.errors.get('raw_materials_a')" />
                

                
                    <v-textarea outlined v-model="form.raw_materials_b" label="Enter this sections question b"
                            :class="{ 'is-invalid': form.errors.has('raw_materials_b') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('raw_materials_b')" v-html="form.errors.get('raw_materials_b')" />
                

                
                    <v-textarea outlined v-model="form.raw_materials_c" label="Enter this sections question c"
                            :class="{ 'is-invalid': form.errors.has('raw_materials_c') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('raw_materials_c')" v-html="form.errors.get('raw_materials_c')" />
                

                
                    <v-textarea outlined v-model="form.raw_materials_d" label="Enter this sections question d"
                            :class="{ 'is-invalid': form.errors.has('raw_materials_d') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('raw_materials_d')" v-html="form.errors.get('raw_materials_d')" />
                

                
                    <v-textarea outlined v-model="form.raw_materials_e" label="Enter this sections question e"
                            :class="{ 'is-invalid': form.errors.has('raw_materials_e') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('raw_materials_e')" v-html="form.errors.get('raw_materials_e')" />
                </v-card-text>

            </v-card>

            <v-card>
        
                <v-card-title>5. Production</v-card-title>
                <v-card-subtitle>This Sections All Questions</v-card-subtitle>

                <v-card-text>
                    <v-textarea outlined v-model="form.production_a" label="Enter this sections question a"
                            :class="{ 'is-invalid': form.errors.has('production_a') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('production_a')" v-html="form.errors.get('production_a')" />
                

                
                    <v-textarea outlined v-model="form.production_b" label="Enter this sections question b"
                            :class="{ 'is-invalid': form.errors.has('production_b') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('production_b')" v-html="form.errors.get('production_b')" />
                

                
                    <v-textarea outlined v-model="form.production_c" label="Enter this sections question c"
                            :class="{ 'is-invalid': form.errors.has('production_c') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('production_c')" v-html="form.errors.get('production_c')" />
                

                
                    <v-textarea outlined v-model="form.production_d" label="Enter this sections question d"
                            :class="{ 'is-invalid': form.errors.has('production_d') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('production_d')" v-html="form.errors.get('production_d')" />
                

                
                    <v-textarea outlined v-model="form.production_e" label="Enter this sections question e"
                            :class="{ 'is-invalid': form.errors.has('production_e') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('production_e')" v-html="form.errors.get('production_e')" />
                

                
                    <v-textarea outlined v-model="form.production_f" label="Enter this sections question f"
                            :class="{ 'is-invalid': form.errors.has('production_f') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('production_f')" v-html="form.errors.get('production_f')" />
                </v-card-text>

            </v-card>

            <v-card>
        
                <v-card-title>6. Records</v-card-title>
                <v-card-subtitle>This Sections All Questions</v-card-subtitle>

                <v-card-text>
                    <v-textarea outlined v-model="form.records_a" label="Enter this sections question a"
                            :class="{ 'is-invalid': form.errors.has('records_a') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('records_a')" v-html="form.errors.get('records_a')" />
                

                
                    <v-textarea outlined v-model="form.records_b" label="Enter this sections question b"
                            :class="{ 'is-invalid': form.errors.has('records_b') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('records_b')" v-html="form.errors.get('records_b')" />
                

                
                    <v-textarea outlined v-model="form.records_c" label="Enter this sections question c"
                            :class="{ 'is-invalid': form.errors.has('records_c') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('records_c')" v-html="form.errors.get('records_c')" />
                

                
                    <v-textarea outlined v-model="form.records_d" label="Enter this sections question d"
                            :class="{ 'is-invalid': form.errors.has('records_d') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('records_d')" v-html="form.errors.get('records_d')" />
                </v-card-text>

            </v-card>

            <v-card>
        
                <v-card-title>7. Labeling</v-card-title>
                <v-card-subtitle>This Sections All Questions</v-card-subtitle>

                <v-card-text>
                    <v-textarea outlined v-model="form.labeling_a" label="Enter this sections question a"
                            :class="{ 'is-invalid': form.errors.has('labeling_a') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('labeling_a')" v-html="form.errors.get('labeling_a')" />
                

                
                    <v-textarea outlined v-model="form.labeling_b" label="Enter this sections question b"
                            :class="{ 'is-invalid': form.errors.has('labeling_b') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('labeling_b')" v-html="form.errors.get('labeling_b')" />
                

                
                    <v-textarea outlined v-model="form.labeling_c" label="Enter this sections question c"
                            :class="{ 'is-invalid': form.errors.has('labeling_c') }"></v-textarea>
                    <div class="small text-danger" v-if="form.errors.has('labeling_c')" v-html="form.errors.get('labeling_c')" />
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
                    building_facilities_a: '',
                    building_facilities_b: '',
                    building_facilities_c: '',
                    building_facilities_d: '',
                    building_facilities_e: '',

                    equipment_a: '',
                    equipment_b: '',
                    equipment_c: '',

                    personnel_a: '',
                    personnel_b: '',
                    personnel_c: '',

                    raw_materials_a: '',
                    raw_materials_b: '',
                    raw_materials_c: '',
                    raw_materials_d: '',
                    raw_materials_e: '',

                    production_a: '',
                    production_b: '',
                    production_c: '',
                    production_d: '',
                    production_e: '',
                    production_f: '',

                    records_a: '',
                    records_b: '',
                    records_c: '',
                    records_d: '',

                    labeling_a: '',
                    labeling_b: '',
                    labeling_c: '',
                }),

            }


        },

        methods: {

            templateInfoData(){

                this.form.get( this.currentUrl + '/food_data' ).then( response=>{
                    //console.log(response.data)

                    this.form.reset();
                    this.form.fill(response.data);

                }).catch( error=>{
                    console.log(error)
                })
            },

            templateInfoStore(){ 

                this.form.post( this.currentUrl + '/food_store' ).then(response=>{
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
