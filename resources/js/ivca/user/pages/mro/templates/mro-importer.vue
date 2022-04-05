<template>
    <div>

        <p class="h3 text-center">The survey report of the Importer and Traders</p>

        <v-alert color="success" class="text-center h3" v-if="auditComplete" show><b>Successfully Audit Completed</b></v-alert>

        
        <!-- Place of production / storage location -->
        <div class="mt-5">
            <v-card :class="{ 'submit-complete': storage_complete }">
            <v-card-title>Place of production / storage location</v-card-title>
                <v-form v-model="valid">
                    <form @submit.prevent="storageDataUpdate()">

                        <v-card-text class="ml-2">
                            {{ templateData.storage_1 }}
                            
                                <v-select v-model="form.storage_1" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('storage_1') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('storage_1')"
                                    v-html="form.errors.get('storage_1')" />
                                <v-textarea rows="1" outlined v-model="form.storage_1_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('storage_1_remarks')"
                                    v-html="form.errors.get('storage_1_remarks')" />
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.storage_2 }}
                            
                                <v-select v-model="form.storage_2" :items="options" :class="{ 'is-invalid': form.errors.has('storage_2') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('storage_1')"
                                    v-html="form.errors.get('storage_2')" />
                                <v-textarea rows="1" outlined v-model="form.storage_2_remarks" small
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('storage_2_remarks')"
                                    v-html="form.errors.get('storage_2_remarks')" />
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.storage_3 }}
                            
                                <v-select v-model="form.storage_3" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('storage_3') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('storage_1')"
                                    v-html="form.errors.get('storage_3')" />
                                <v-textarea rows="1" outlined v-model="form.storage_3_remarks" small
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('storage_3_remarks')"
                                    v-html="form.errors.get('storage_3_remarks')" />
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.storage_4 }}
                            
                                <v-select v-model="form.storage_4" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('storage_4') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('storage_1')"
                                    v-html="form.errors.get('storage_4')" />
                                <v-textarea rows="1" outlined v-model="form.storage_4_remarks" small
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('storage_4_remarks')"
                                    v-html="form.errors.get('storage_4_remarks')" />
                            
                        </v-card-text>
                        <v-card-text>
                            <div v-if="iamgeUploadAccess">
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'storage_image')"
                                            label="Choose or drop Image here..." small accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6">
                                        <img :src="showImageByName('storage_image')" class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>
                        
                        


                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense :loading="storage_loading" small color="primary"><v-icon>mdi-pencil-outline</v-icon> Update</v-btn>
                        </div>
                        

                    </form>
                </v-form>

            </v-card>
        </div>
        

        <!-- Production planning / control product quality and service -->
        <div class="mt-5">
            <v-card title="Production planning / control product quality and service" :class="{ 'submit-complete': production_qs_complete }">
                <v-form v-model="valid">
                    <form @submit.prevent="productionQsDataUpdate()">

                        <v-card-text class="ml-2">
                            {{ templateData.production_qs_1 }}
                            
                                <v-select v-model="form.production_qs_1" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('production_qs_1') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('production_qs_1')"
                                    v-html="form.errors.get('production_qs_1')" />
                                <v-textarea rows="1" outlined v-model="form.production_qs_1_remarks" small
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('production_qs_1_remarks')"
                                    v-html="form.errors.get('production_qs_1_remarks')" />
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.production_qs_2 }}
                            
                                <v-select v-model="form.production_qs_2" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('production_qs_2') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('production_qs_2')"
                                    v-html="form.errors.get('production_qs_2')" />
                                <v-textarea rows="1" outlined v-model="form.production_qs_2_remarks" small
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('production_qs_2_remarks')"
                                    v-html="form.errors.get('production_qs_2_remarks')" />
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.production_qs_3 }}
                            
                                <v-select v-model="form.production_qs_3" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('production_qs_3') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('production_qs_3')"
                                    v-html="form.errors.get('production_qs_3')" />
                                <v-textarea rows="1" outlined v-model="form.production_qs_3_remarks" small
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('production_qs_3_remarks')"
                                    v-html="form.errors.get('production_qs_3_remarks')" />
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.production_qs_4 }}
                            
                                <v-select v-model="form.production_qs_4" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('production_qs_4') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('production_qs_4')"
                                    v-html="form.errors.get('production_qs_4')" />
                                <v-textarea rows="1" outlined v-model="form.production_qs_4_remarks" small
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('production_qs_4_remarks')"
                                    v-html="form.errors.get('production_qs_4_remarks')" />
                            
                        </v-card-text>

                        <v-card-text>
                            <div v-if="iamgeUploadAccess">
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'production_qs_image')"
                                            label="Choose or drop Image here..." small accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6">
                                        <img :src="showImageByName('production_qs_image')" class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense :loading="production_qs_loading" small color="primary"><v-icon>mdi-pencil-outline</v-icon> Update</v-btn>
                        </div>

                    </form>
                </v-form>

            </v-card>
        </div>
      
        <!-- Safety -->
        <div class="mt-5">
            <v-card title="Safety" :class="{ 'submit-complete': safety_complete }">
                <v-form v-model="valid">
                    <form @submit.prevent="safetyDataUpdate()">
                        <v-card-text class="ml-2">
                            {{ templateData.safety_1 }}
                            
                                <v-select v-model="form.safety_1" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('safety_1') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('safety_1')"
                                    v-html="form.errors.get('safety_1')" />
                                <v-textarea rows="1" outlined v-model="form.safety_1_remarks" small
                                    label="Enter Audit Remarks">
                                </v-textarea>
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.safety_2 }}
                            
                                <v-select v-model="form.safety_2" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('safety_2') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('safety_2')"
                                    v-html="form.errors.get('safety_2')" />
                                <v-textarea rows="1" outlined v-model="form.safety_2_remarks" small
                                    label="Enter Audit Remarks">
                                </v-textarea>
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.safety_3 }}
                            
                                <v-select v-model="form.safety_3" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('safety_3') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('safety_3')"
                                    v-html="form.errors.get('safety_3')" />
                                <v-textarea rows="1" outlined v-model="form.safety_3_remarks" small
                                    label="Enter Audit Remarks">
                                </v-textarea>
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.safety_4 }}
                            
                                <v-select v-model="form.safety_4" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('safety_4') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('safety_4')"
                                    v-html="form.errors.get('safety_4')" />
                                <v-textarea rows="1" outlined v-model="form.safety_4_remarks" small
                                    label="Enter Audit Remarks">
                                </v-textarea>
                            
                        </v-card-text>

                        <v-card-text>
                            <div v-if="iamgeUploadAccess">
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'safety_image')"
                                            label="Choose or drop Image here..." small accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6">
                                        <img :src="showImageByName('safety_image')" class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>
                        

                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense :loading="safety_loading" small color="primary"><v-icon>mdi-pencil-outline</v-icon> Update</v-btn>
                        </div>

                    </form>
                </v-form>

            </v-card>
        </div>
       
        <!-- Environment and Surrounding condition -->
        <div class="mt-5">
            <v-card title="Environment and Surrounding condition" :class="{ 'submit-complete': env_sur_con_complete }">
                <v-form v-model="valid">
                    <form @submit.prevent="envSurConDataUpdate()">

                        <v-card-text class="ml-2">
                            {{ templateData.env_sur_con_1 }}
                            
                                <v-select v-model="form.env_sur_con_1" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('env_sur_con_1') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('env_sur_con_1')"
                                    v-html="form.errors.get('env_sur_con_1')" />
                                <v-textarea rows="1" outlined v-model="form.env_sur_con_1_remarks" small
                                    label="Enter Audit Remarks"></v-textarea>
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.env_sur_con_2 }}
                            
                                <v-select v-model="form.env_sur_con_2" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('env_sur_con_2') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('env_sur_con_2')"
                                    v-html="form.errors.get('env_sur_con_2')" />
                                <v-textarea rows="1" outlined v-model="form.env_sur_con_2_remarks" small
                                    label="Enter Audit Remarks"></v-textarea>
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.env_sur_con_3 }}
                            
                                <v-select v-model="form.env_sur_con_3" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('env_sur_con_3') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('env_sur_con_3')"
                                    v-html="form.errors.get('env_sur_con_3')" />
                                <v-textarea rows="1" outlined v-model="form.env_sur_con_3_remarks" small
                                    label="Enter Audit Remarks"></v-textarea>
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.env_sur_con_4 }}
                            
                                <v-select v-model="form.env_sur_con_4" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('env_sur_con_4') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('env_sur_con_4')"
                                    v-html="form.errors.get('env_sur_con_4')" />
                                <v-textarea rows="1" outlined v-model="form.env_sur_con_4_remarks" small
                                    label="Enter Audit Remarks"></v-textarea>
                            
                        </v-card-text>

                        <v-card-text>
                            <div v-if="iamgeUploadAccess">
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'env_sur_con_image')"
                                            label="Choose or drop Image here..." small accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6">
                                        <img :src="showImageByName('env_sur_con_image')" class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>
                        

                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense :loading="env_sur_con_loading" small color="primary"><v-icon>mdi-pencil-outline</v-icon> Update</v-btn>
                        </div>

                    </form>
                </v-form>

            </v-card>
        </div>
       

        <!-- To cooperate with the company -->
        <div class="mt-5">
            <v-card title="To cooperate with the company" :class="{ 'submit-complete': cooperate_complete }">
                <v-form v-model="valid">
                    <form @submit.prevent="cooperateDataUpdate()">
                        <v-card-text class="ml-2">
                            {{ templateData.cooperate_1 }}
                            
                                <v-select v-model="form.cooperate_1" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('cooperate_1') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('cooperate_1')"
                                    v-html="form.errors.get('cooperate_1')" />
                                <v-textarea rows="1" outlined v-model="form.cooperate_1_remarks" small
                                    label="Enter Audit Remarks">
                                </v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('cooperate_1_remarks')"
                                    v-html="form.errors.get('cooperate_1_remarks')" />
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.cooperate_2 }}
                            
                                <v-select v-model="form.cooperate_2" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('cooperate_2') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('cooperate_2')"
                                    v-html="form.errors.get('cooperate_2')" />
                                <v-textarea rows="1" outlined v-model="form.cooperate_2_remarks" small
                                    label="Enter Audit Remarks">
                                </v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('cooperate_2_remarks')"
                                    v-html="form.errors.get('cooperate_2_remarks')" />
                            
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.cooperate_3 }}
                            
                                <v-select v-model="form.cooperate_3" :items="options" 
                                    :class="{ 'is-invalid': form.errors.has('cooperate_3') }" :rules="mroImporterRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('cooperate_3')"
                                    v-html="form.errors.get('cooperate_3')" />
                                <v-textarea rows="1" outlined v-model="form.cooperate_3_remarks" small
                                    label="Enter Audit Remarks">
                                </v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('cooperate_3_remarks')"
                                    v-html="form.errors.get('cooperate_3_remarks')" />
                            
                        </v-card-text>

                        <v-card-text>
                            <div v-if="iamgeUploadAccess">
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'cooperate_image')"
                                            label="Choose or drop Image here..." small accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6">
                                        <img :src="showImageByName('cooperate_image')" class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            
                            </div>
                        </v-card-text>
                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense :loading="cooperate_loading" small color="primary"><v-icon>mdi-pencil-outline</v-icon> Update</v-btn>
                        </div>

                    </form>
                </v-form>
            </v-card>
        </div>
      

        <!-- Final Submit -->
        <div class="my-4 p-3 card">
            <v-form v-model="valid">
                <form @submit.prevent="finalDataUpdate()">

                    <div class="row">
                        <div class="col-md-6">
                            <div v-if="iamgeUploadAccess">
                                <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'group_image')"
                                    label="Choose or drop Image here..." small accept=".jpg, .png, .jpeg">
                                </v-file-input>
                                <div class="small text-danger" v-if="form.errors.has('group_image')"
                                        v-html="form.errors.get('group_image')" />
                                <div class="mt-1">
                                    <img :src="showImageByName('group_image')" class="rounded mx-auto d-block image-thum-size" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div v-if="iamgeUploadAccess">
                                <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'vendor_image')"
                                    label="Choose or drop Image here..." small accept=".jpg, .png, .jpeg">
                                </v-file-input>
                                <div class="small text-danger" v-if="form.errors.has('vendor_image')"
                                        v-html="form.errors.get('vendor_image')" />
                                <div class="mt-1">
                                    <img :src="showImageByName('vendor_image')" class="rounded mx-auto d-block image-thum-size" />
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense :loading="final_loading" color="error"><i class="far fa-check-circle"></i> Final Submit</v-btn>
                        </div>
                    </div>

                </form>
            </v-form>

        </div>


        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        

        

    </div>
</template>

<script>
    // vform
    import Form from 'vform';

    export default {
        props: ['token', 'iamgeUploadAccess'],
        data() {
            return {

                valid:false,
                // overlay
                overlay: false,

                mroImporterRules: [v => !!v || 'This Field is required!'],


                // current page url
                currentUrl: '/ivca/mro/audit',

                templateData: '',
                userType: '',
                selected: null,
                auditComplete: false,

                imageMaxSize: '5111775',
                imagePath: '/images/ivca/',
                imagePathSm: '/images/ivca/small/',

                // Section Complete Status
                storage_complete : false,
                production_qs_complete : false,
                safety_complete : false,
                env_sur_con_complete : false,
                cooperate_complete : false,

                // Loading Indecator
                storage_loading : false,
                production_qs_loading : false,
                safety_loading : false,
                env_sur_con_loading : false,
                cooperate_loading : false,
                final_loading:false,


                options: [{
                        value: null,
                        text: 'Please select an option'
                    },
                    {
                        value: 1,
                        text: '1 (One)'
                    },
                    {
                        value: 2,
                        text: '2 (Two)'
                    },
                    {
                        value: 3,
                        text: '3 (Three)'
                    },
                    {
                        value: 4,
                        text: '4 (Four)'
                    },
                ],

                // Form
                form: new Form({
                    id: '',
                    storage_1: null,
                    storage_1_remarks: null,
                    storage_2: null,
                    storage_2_remarks: null,
                    storage_3: null,
                    storage_3_remarks: null,
                    storage_4: null,
                    storage_4_remarks: null,
                    storage_image: null,

                    production_qs_1: null,
                    production_qs_1_remarks: null,
                    production_qs_2: null,
                    production_qs_2_remarks: null,
                    production_qs_3: null,
                    production_qs_3_remarks: null,
                    production_qs_4: null,
                    production_qs_4_remarks: null,
                    production_qs_image: null,

                    safety_1: null,
                    safety_1_remarks: null,
                    safety_2: null,
                    safety_2_remarks: null,
                    safety_3: null,
                    safety_3_remarks: null,
                    safety_4: null,
                    safety_4_remarks: null,
                    safety_image: null,

                    env_sur_con_1: null,
                    env_sur_con_1_remarks: null,
                    env_sur_con_2: null,
                    env_sur_con_2_remarks: null,
                    env_sur_con_3: null,
                    env_sur_con_3_remarks: null,
                    env_sur_con_4: null,
                    env_sur_con_4_remarks: null,
                    env_sur_con_image: null,

                    cooperate_1: null,
                    cooperate_1_remarks: null,
                    cooperate_2: null,
                    cooperate_2_remarks: null,
                    cooperate_3: null,
                    cooperate_3_remarks: null,
                    cooperate_image: null,

                    group_image: null,
                    vendor_image: null,
                }),

            }
        },

        methods: {

            // Template
            auditTempalte() {
                axios.post(this.currentUrl + '/template/importer').then(response => {
                    //console.log('Template', response.data)
                    this.templateData = response.data;
                }).catch(error => {
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Sorry! Somthing going wrong',  
                    })
                    console.log(error)
                })
            },

            // Audit Data Refresh 
            auditDataRefresh() {
                axios.get(this.currentUrl + '/importer/audit_data/' + this.token).then(response => {
                    // console.log( 'auditDataRefresh', response.data.id)
                    if (response.data.id) {
                        this.form.fill(response.data)
                    }

                    // Audit Complete
                    if (response.data.status == 1) {
                        this.auditComplete = true
                    }

                    //1 storage_complete
                    if (response.data.storage_status == 1) {
                        this.storage_complete = true
                    }

                    //2 production_qs_complete
                    if (response.data.production_qs_status == 1) {
                        this.production_qs_complete = true
                    }

                    //3 safety_complete
                    if (response.data.safety_status == 1) {
                        this.safety_complete = true
                    }

                    //4 env_sur_con_complete
                    if (response.data.env_sur_con_status == 1) {
                        this.env_sur_con_complete = true
                    }

                    //5 cooperate_complete
                    if (response.data.cooperate_status == 1) {
                        this.cooperate_complete = true
                    }

                }).catch(error => {
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Sorry! Somthing going wrong',  
                    })
                    console.log(error)
                })
            },

            // currentRoleCheck
            currentRoleCheck() {
                if (this.iamgeUploadAccess) {
                    this.userType = 'Auditor'
                }else{
                    this.userType = 'User'
                }
            },

            // checkPhotoUploadAccess
            checkPhotoUploadAccess(){
                if(singleData.user_id == this.user.id && singleData.date == this.todayDate){
                    return true;
                }
                return false;
            },




            // storageDataUpdate
            storageDataUpdate() {
                // Start loading
                this.storage_loading =true
                this.overlay = true
                this.form.post(this.currentUrl + '/importer/storage_store/' + this.token + '/' + this.userType)
                    .then(response => {
                        this.storage_loading =false
                        this.overlay = false
                        //console.log(response.data)
                        // this.form.fill(response.data.allData)
                        this.auditDataRefresh();

                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        })

                    }).catch(error => {
                        this.storage_loading =false
                        this.overlay = false
                        // Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry! Somthing going wrong',  
                        })
                        console.log(error)
                    })
            },


            // productionQsDataUpdate
            productionQsDataUpdate() {
                // Start loading
                this.production_qs_loading =true
                this.overlay = true
                this.form.post(this.currentUrl + '/importer/production_qs_store/' + this.token + '/' + this
                    .userType).then(response => {
                    this.production_qs_loading =false
                    this.overlay = false
                    //console.log(response.data)
                    //this.form.fill(response.data.allData)
                    this.auditDataRefresh();

                    Swal.fire({
                        icon: response.data.icon,
                        title: response.data.status,
                        text: response.data.msg,
                    })

                }).catch(error => {
                    this.production_qs_loading =false
                    this.overlay = false
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Sorry! Somthing going wrong',  
                    })
                    console.log(error)
                })
            },


            // safetyDataUpdate
            safetyDataUpdate() {
                // Start loading
                this.safety_loading =true
                this.overlay = true
                this.form.post(this.currentUrl + '/importer/safety_store/' + this.token + '/' + this.userType).then(
                    response => {
                        this.safety_loading =false
                        this.overlay = false
                        //console.log(response.data)
                        // this.form.fill(response.data.allData)
                        this.auditDataRefresh();
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        })

                    }).catch(error => {
                        this.safety_loading =false
                        this.overlay = false
                        // Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry! Somthing going wrong',  
                        })
                        console.log(error)
                    })
            },


            // envSurConDataUpdate
            envSurConDataUpdate() {
                // Start loading
                this.env_sur_con_loading =true
                this.overlay = true
                this.form.post(this.currentUrl + '/importer/env_sur_con_store/' + this.token + '/' + this.userType)
                    .then(response => {
                        this.env_sur_con_loading =false
                        this.overlay = false
                        //console.log(response.data)
                        // this.form.fill(response.data.allData)
                        this.auditDataRefresh();
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        })

                    }).catch(error => {
                        this.env_sur_con_loading =false
                        this.overlay = false
                        // Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry! Somthing going wrong',  
                        })
                        console.log(error)
                    })
            },



            // cooperateDataUpdate
            cooperateDataUpdate() {
                // Start loading
                this.cooperate_loading =true
                this.overlay = true
                this.form.post(this.currentUrl + '/importer/cooperate_store/' + this.token + '/' + this.userType)
                    .then(response => {
                        this.cooperate_loading =false
                        this.overlay = false
                        //console.log(response.data)
                        //this.form.fill(response.data.allData)
                        this.auditDataRefresh();

                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        })

                    }).catch(error => {
                        this.cooperate_loading =false
                        this.overlay = false
                        // Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry! Somthing going wrong',  
                        })
                        console.log(error)
                    })
            },


            // finalDataUpdate
            finalDataUpdate() {
                // Start loading
                this.final_loading =true
                this.overlay = true
                this.form.post(this.currentUrl + '/importer/final_store/' + this.token + '/' + this.userType)
                    .then(response => {
                        this.final_loading =false
                        this.overlay = false
                        //console.log(response.data)
                        //this.form.fill(response.data.allData)
                        this.auditDataRefresh();
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        }).then(()=>{
                            // Redirect route
                            this.$router.push({ name:'ivca_mro_schedule' })
                        })

                    }).catch(error => {
                        this.final_loading =false
                        this.overlay = true
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


        created() {
            // Template data
            this.auditTempalte()
            // Check current user type
            this.currentRoleCheck()

            // Current Audit data
            this.auditDataRefresh()

            //console.log('Token: ' + this.token, this.userType)


        }
    }

</script>


<style scoped>
    .float {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 40px;
        background-color: #0C9;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        box-shadow: 2px 2px 3px #999;
    }

    .my-float {
        margin-top: 22px;
    }

    .show-ontop {
        position: sticky;
        top: 0;
        background-color: #0C9;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        box-shadow: 2px 2px 3px #999;
        z-index: 1;
    }

    .image-thum-size{
        height: 50px;
        width: 100px;    
    }

    .submit-complete{
        background:rgb(123, 243, 123);
    }

</style>
