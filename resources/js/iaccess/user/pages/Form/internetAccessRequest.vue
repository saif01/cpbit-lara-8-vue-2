<template>
    <v-dialog v-model="dataModalDialog" max-width="1100">

        <v-card>
            <v-card-title>
                <v-row>
                    <v-col cols="10">
                        Internet Access Request Form
                    </v-col>
                    <v-col cols="2">
                        <v-btn @click="dataModalDialog = false" color="error" small 
                            class="float-right">
                            <v-icon left dark>mdi-close </v-icon> Close
                        </v-btn>
                        
                    </v-col>
                </v-row>
            </v-card-title>
        </v-card>

        <v-stepper v-model="step">
            
            <v-stepper-header>
                <v-stepper-step :complete="step > 1" step="1">
                    User Information
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="step > 2" step="2">
                    Purpose
                </v-stepper-step>

            </v-stepper-header>

            <v-stepper-items>
                <v-form v-model="valid" ref="form">
                    <form @submit.prevent="createData()">

                        <v-stepper-content step="1">
                            
                            <v-row class="mt-2">
                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                                    <v-text-field label="Name" v-model="form.name" required :rules="[v => !!v || 'Name is required!']"  dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('branch')" v-html="form.errors.get('branch')" />
                                    <v-autocomplete label="Branch:" v-model="form.branch" required :rules="[v => !!v || 'Branch is required!']" :items="allOffice" item-text="text" item-value="text"  dense>
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('position')" v-html="form.errors.get('position')" />
                                    <v-text-field label="Position" v-model="form.position" required :rules="[v => !!v || 'Position is required!']"  dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('department')" v-html="form.errors.get('department')" />
                                    <v-autocomplete label="Departments:" v-model="form.department" required :rules="[v => !!v || 'Department is required!']" :items="allDepartments" item-text="department" item-value="department"  dense>
                                    </v-autocomplete>  
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('office_mobile')" v-html="form.errors.get('office_mobile')" />
                                    <v-text-field label="Office Mobile" v-model="form.office_mobile" required :rules="[v => !!v || 'Office Mobile is required!']"  dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('personal_mobile')" v-html="form.errors.get('personal_mobile')" />
                                    <v-text-field label="Personal Mobile" v-model="form.personal_mobile" required :rules="[v => !!v || 'Personal Mobile is required!']"  dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('personal_email')" v-html="form.errors.get('personal_email')" />
                                    <v-text-field label="Personal e-mail" v-model="form.personal_email" required :rules="[v => !!v || 'Personal Email is required!']"  dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('office_email')" v-html="form.errors.get('office_email')" />
                                    <v-text-field label="Office e-mail" v-model="form.office_email"  dense></v-text-field>
                                </v-col>

                                 <v-col cols="12" lg="6">
                                   <v-file-input prepend-icon="mdi-paperclip" @change="uploadImageByName($event, 'image')"
                                        label="NID / Passport (Only Thei)" size="sm" accept=".jpg, .png, .jpeg">
                                    </v-file-input>
                                </v-col>

                                 <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('office_email')" v-html="form.errors.get('office_email')" />
                                    <v-file-input prepend-icon="mdi-paperclip" @change="uploadImageByName($event, 'image')"
                                        label="Office ID / Visa (Only Thei)" size="sm" accept=".jpg, .png, .jpeg">
                                    </v-file-input>
                                </v-col>

                                 
                            </v-row>

                            <v-btn color="primary" @click="step = 2" v-if="form.name && form.branch && form.department && form.office_mobile && form.personal_mobile && form.personal_email != '' ">
                                Continue
                            </v-btn>
                        </v-stepper-content>

                        <v-stepper-content step="2">
                            <div>
                                Do you have any ID <b>(like xxxx.yyy)</b> for Smart Soft, Smart Procurement, Win Feed, Win Farm or other
                            </div>
                            <v-row>
                                <v-col cols="4">
                                    <v-checkbox v-model="int_id" label="No" value="no" color="indigo"></v-checkbox>
                                </v-col>
                                <v-col cols="4">
                                    <v-checkbox v-model="int_id" label="Yes" value="Yes" color="indigo"></v-checkbox>
                                </v-col>
                                <v-col cols="4" v-if="int_id == 'Yes'">
                                    <v-text-field label="Enter the ID" v-model="form.internet_id"></v-text-field>
                                </v-col>
                            </v-row>
                            
                            <div class="h5 py-2 bg-dark text-white text-center" block>Request For</div>
                            <v-row>
                                <v-col cols="4" v-for="(data, index) in options" :key="index">
                                    <v-checkbox multiple v-model="form.request_for" :label="data.text" :value="data.value" color="indigo"></v-checkbox>
                                </v-col>
                            </v-row>

                            <div class="text-danger" v-if="form.errors.has('web_url')" v-html="form.errors.get('web_url')" />
                            <v-textarea label="Web Address (URL)" v-model="form.web_url"  dense></v-textarea>

                            <div class="text-danger" v-if="form.errors.has('purpose')" v-html="form.errors.get('purpose')" />
                            <v-textarea label="Purpose" v-model="form.purpose" required :rules="[v => !!v || 'Purpose is required!']"  dense></v-textarea>

                            <v-btn color="primary" type="submit" :loading="dataModalLoading">
                                Submit
                            </v-btn>

                            <v-btn text @click="step = 1">
                                Back
                            </v-btn>
                        </v-stepper-content>

                    </form>
                </v-form>

            </v-stepper-items>
        </v-stepper>
    </v-dialog>
</template>

<script>
import Form from 'vform';
    export default {
        data() {
            return {

                int_id: '', 

                valid: false,

                step: 1,

                options:[
                    {
                        value:'Internet Access',
                        text: 'Internet Access'
                    },
                    {
                        value:'Reset Password',
                        text: 'Reset Password'
                    },
                    {
                        value:'Disable',
                        text: 'Disable'
                    },
                    {
                        value:'Delete',
                        text: 'Delete'
                    },
                ],

                
                dataModalDialog: true,
                dataModalLoading: false,


                currentUrl: '/iaccess/form/webaccess',

                form: new Form({

                    name: '',
                    branch: '',
                    position: '',
                    department: '',
                    office_mobile: '',
                    personal_mobile: '',
                    personal_email: '',
                    office_email: '',


                    internet_id: '',
                    request_for: '',
                    web_url: '',
                    purpose: '',

                }),

            }
        },

        methods:{
            
            
        },


        mounted(){
            this.getDepartments();
            this.getOffice();
        }
    }

</script>
