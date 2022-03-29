<template>
    <v-dialog v-model="dataModalDialog" max-width="900">

        <v-card>
            <v-card-title>
                <v-row>
                    <v-col cols="10">
                        Official Email Request Form
                    </v-col>
                    <v-col cols="2">
                        <v-btn @click="dataModalDialog = false" color="error" small outlined
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
                                    <v-text-field label="Name" v-model="form.name" required :rules="[v => !!v || 'Name is required!']" outlined dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('branch')" v-html="form.errors.get('branch')" />
                                    <v-autocomplete label="Branch:" v-model="form.branch" required :rules="[v => !!v || 'Branch is required!']" :items="allOffice" item-text="text" item-value="text" outlined dense>
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('position')" v-html="form.errors.get('position')" />
                                    <v-text-field label="Position" v-model="form.position" required :rules="[v => !!v || 'Position is required!']" outlined dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('department')" v-html="form.errors.get('department')" />
                                    <v-autocomplete label="Departments:" v-model="form.department" required :rules="[v => !!v || 'Department is required!']" :items="allDepartments" item-text="department" item-value="department" outlined dense>
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('office_mobile')" v-html="form.errors.get('office_mobile')" />
                                    <v-text-field label="Office Mobile" v-model="form.office_mobile" required :rules="[v => !!v || 'Office Mobile is required!']" outlined dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('personal_mobile')" v-html="form.errors.get('personal_mobile')" />
                                    <v-text-field label="Personal Mobile" v-model="form.personal_mobile" required :rules="[v => !!v || 'Personal Mobile is required!']" outlined dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="12">
                                    <div class="text-danger" v-if="form.errors.has('personal_email')" v-html="form.errors.get('personal_email')" />
                                    <v-text-field label="Personal e-mail" v-model="form.personal_email" required :rules="[v => !!v || 'Personal Email is required!']" outlined dense></v-text-field>
                                </v-col>

                                <!-- <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('bu_head_email')" v-html="form.errors.get('bu_head_email')" />
                                    <v-text-field label="BU Head e-mail" v-model="form.bu_head_email" outlined dense></v-text-field>
                                </v-col> -->
                            </v-row>

                            <v-btn color="primary" @click="step = 2" v-if="form.name && form.branch && form.department && form.office_mobile && form.personal_mobile && form.personal_email != '' ">
                                Continue
                            </v-btn>
                        </v-stepper-content>

                        <v-stepper-content step="2">
                            <div class="h5 py-2 bg-dark text-white text-center" block>Request For</div>

                            <v-row>
                                <v-col cols="4" v-for="(data, index) in options" :key="index">
                                    <v-checkbox multiple v-model="form.request_for" :label="data.text" :value="data.value" color="indigo"></v-checkbox>
                                </v-col>
                            </v-row>

                            <v-text-field label="Request E-mail ID" v-model="form.requested_email" outlined dense></v-text-field>


                            <div class="text-danger" v-if="form.errors.has('purpose')" v-html="form.errors.get('purpose')" />
                            <v-textarea label="Purpose" v-model="form.purpose" required :rules="[v => !!v || 'Purpose is required!']" outlined dense></v-textarea>

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

                valid: false,

                step: 1,

                options:[
                    {
                        value:'New e-Mail ID',
                        text: 'New e-Mail ID'
                    },
                    {
                        value:'Reset Password',
                        text: 'Reset Password'
                    },
                    {
                        value:'Enable',
                        text: 'Enable'
                    },
                    {
                        value:'Suspend',
                        text: 'Suspend'
                    },
                    {
                        value:'Delete',
                        text: 'Delete'
                    },
                ],

                
                dataModalDialog: true,

                dataModalLoading: false,
                

                currentUrl: '/iaccess/form/email',

                form: new Form({

                    name: '',
                    branch: '',
                    position: '',
                    department: '',
                    office_mobile: '',
                    personal_mobile: '',
                    personal_email: '',
                    bu_head_email: '',

                    request_for: '',
                    requested_email: '',
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
