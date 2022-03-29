<template>
    <v-dialog v-model="dataModalDialog" max-width="900">

        <v-card>
            <v-card-title>
                <v-row>
                    <v-col cols="10">
                        Guest User Request Form
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
                    Requester Information
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="step > 2" step="2">
                    Guest User Information
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
                                    <div class="text-danger" v-if="form.errors.has('mobile')" v-html="form.errors.get('mobile')" />
                                    <v-text-field label="Office Mobile" v-model="form.mobile" required :rules="[v => !!v || 'Mobile is required!']" outlined dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('personal_email')" v-html="form.errors.get('personal_email')" />
                                    <v-text-field label="Personal e-mail" v-model="form.personal_email" required :rules="[v => !!v || 'Personal Email is required!']" outlined dense></v-text-field>
                                </v-col>
                            </v-row>

                            <v-btn color="primary" @click="step = 2" v-if="form.name && form.branch && form.department && form.mobile && form.personal_email != '' ">
                                Continue
                            </v-btn>
                        </v-stepper-content>

                        <v-stepper-content step="2">

                            <v-row class="mt-2">
                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('guest_company')" v-html="form.errors.get('guest_company')" />
                                    <v-text-field label="Guest Company" v-model="form.guest_company" required :rules="[v => !!v || 'Guset Company is required!']" outlined dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('no_of_guest')" v-html="form.errors.get('no_of_guest')" />
                                    <v-text-field label="No of Guest" type="text" v-model="form.no_of_guest" required :rules="[v => !!v || 'No of guest is required!']" outlined dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('guest_job')" v-html="form.errors.get('guest_job')" />
                                    <v-text-field label="Guest User Job" v-model="form.guest_job" outlined dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <div class="text-danger" v-if="form.errors.has('guest_duration')" v-html="form.errors.get('guest_duration')" />
                                    <v-text-field label="Guest User Duration" v-model="form.guest_duration" required :rules="[v => !!v || 'Guest User duration is required!']" outlined dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <v-menu v-model="menu" min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.start_date" label="Start Date" prepend-inner-icon="mdi-calendar"
                                                readonly v-bind="attrs" v-on="on" required :rules="[v => !!v || 'Start Date is required!']" outlined dense></v-text-field>
                                        </template>

                                        <v-date-picker v-model="form.start_date" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu = false">
                                                Cancel
                                            </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <v-menu v-model="menu2" min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.end_date" label="Emd Date" prepend-inner-icon="mdi-calendar"
                                                readonly v-bind="attrs" v-on="on" required :rules="[v => !!v || 'End Date is required!']" outlined dense></v-text-field>
                                        </template>

                                        <v-date-picker v-model="form.end_date" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu2 = false">
                                                Cancel
                                            </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>
                            </v-row>
                            

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


                currentUrl: '/iaccess/form/guest',

                form: new Form({

                    name: '',
                    branch: '',
                    position: '',
                    department: '',
                    mobile: '',
                    personal_email: '',

                    guest_company: '',
                    no_of_guest: '',
                    guest_job: '',
                    guest_duration: '',
                    start_date: '',
                    end_date: '',


                }),


                // datepicker
                menu: '',
                menu2: '',

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
