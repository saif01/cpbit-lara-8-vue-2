<template>
    <div>
        <v-dialog v-model="actionDailog" scrollable>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Complain Actions (2) :
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="actionDailog = false" color="error lighten-1" small text class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>

                    <table class="table mb-0">
                        <tr>
                            <th>Complain No:</th>
                            <td>
                                <div class="pa-1 success rounded-pill h6 text-white text-center">
                                    {{ comData.id }}</div>
                            </td>
                            <th>Category:</th>
                            <td><span v-if="comData.category">{{ comData.category.name }}</span></td>
                            <th>Subcategory:</th>
                            <td><span v-if="comData.subcategory">{{ comData.subcategory.name }}</span></td>
                        </tr>
                    </table>
                    <hr>
                    <div>

                        <form @submit.prevent="actionStore()">

                            <v-row align-content="center">

                                <!-- Process -->
                                <v-col cols="12" lg="6">
                                    <div class="small text-danger" v-if="form.errors.has('process')"
                                        v-html="form.errors.get('process')" />
                                    <v-autocomplete @change="changeProcess()" :items="stepOptions" dense
                                        v-model="form.process" label="Select Step"
                                        :rules="[v => !!v || 'Step is required!']" outlined required></v-autocomplete>
                                </v-col>

                                <!-- Document -->
                                <v-col cols="12" lg="6">
                                    <v-file-input @change="uploadDocByName($event, 'document')" show-size
                                        label="Document" accept="image/*, .pdf, .xlsx, .docx" :rules="docRules" outlined
                                        dense></v-file-input>
                                </v-col>

                                <!-- Damaged -->
                                <v-col cols="12" lg="6" v-if="applicableOptions.length">
                                    <v-autocomplete :items="damagedReasons" dense v-model="form.damaged_reason"
                                        label="Damaged Reason" :rules="[v => !!v || 'Damaged Reason is required!']"
                                        outlined required></v-autocomplete>
                                </v-col>
                                <v-col cols="12" lg="6" v-if="applicableOptions.length">
                                    <!-- {{ form.applicable_type }} -->
                                    <label>Damaged Status</label>
                                    <v-radio-group v-model="form.applicable_type" row
                                        :rules="[v => !!v || 'Step is required!']" required>
                                        <v-radio v-for="(item, k) in applicableOptions" :key="k"
                                            :label="`${item.label}`" :value="`${item.value}`" :color="`${item.color}`">
                                        </v-radio>
                                    </v-radio-group>
                                </v-col>

                                <!-- For Closed dependences -->
                                <v-col cols="12" v-if="closedoptions.length">
                                    <!-- {{ form.applicable }} -->
                                    <v-radio-group label="Closed Status" v-model="form.delivery" row
                                        :rules="[v => !!v || 'Step is required!']" required>
                                        <v-radio v-for="(item, k) in closedoptions" :key="k" :label="`${item.label}`"
                                            :value="`${item.value}`" :color="`${item.color}`"></v-radio>
                                    </v-radio-group>
                                </v-col>





                                <!-- Details -->
                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('details')"
                                        v-html="form.errors.get('details')" />

                                    <v-row>
                                        <v-col cols="8">
                                            <label>Details :</label>
                                        </v-col>
                                        <v-col cols="4" v-if="drafts.length">
                                            <v-autocomplete :items="drafts" dense v-model="selectDraft" label="Draft">
                                            </v-autocomplete>
                                        </v-col>
                                    </v-row>
                                    <vue-editor
                                        :class="{ error_bg: (form.details && ( form.details.length <= 10 || form.details.length >= 20000 )) }"
                                        v-model="form.details" :editorToolbar="customToolbar"></vue-editor>
                                    <v-row>
                                        <v-col cols="10">
                                            <span v-if="(form.details && form.details.length <= 10)"
                                                class="small text-danger">10 chars minimum or more.</span>
                                            <span v-if="(form.details && form.details.length >= 20000)"
                                                class="small text-danger">Description must be 20,000 characters or
                                                less.</span>
                                        </v-col>
                                        <v-col cols="2">
                                            <span class="float-right">{{ form.details.length }}/ 20,000</span>
                                        </v-col>
                                    </v-row>

                                </v-col>

                            </v-row>


                            <v-row class="mt-2">
                                <v-btn type="submit" block :loading="dataModalLoading" elevation="20" color="primary">
                                    <v-icon left dark>mdi-shape-polygon-plus</v-icon> Submit
                                </v-btn>
                            </v-row>


                        </form>

                    </div>

                </v-card-text>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
    // vform
    import Form from 'vform';
    import {
        VueEditor
    } from "vue2-editor";
    import vue2EditorToolbar from "../js/vue2_editor_toolbar"

    import damagedReasons from './../js/damaged_reasons'
    import changeProcessMethod from './../js/chage_process'


    export default {

        props: ['comData'],

        components: {
            VueEditor
        },

        data() {
            return {
                // Dialog show
                actionDailog: true,

                //current page url
                currentUrl: '/cms/h_admin/complain',

                // Custom Toolbar for vue2 text editor
                ...vue2EditorToolbar,

                reqRules: [v => !!v || 'This field is required!'],

                docRules: [
                    value => !value || value.size < 2000000 || 'Document size should be less than 2 MB!',
                ],

                remRules: [
                    v => (v || '').length <= 20000 || 'Description must be 20,000 characters or less',
                    v => (v || '').length >= 10 || '10 chars minimum or more',
                ],


                stepOptions: [],

                dataModalLoading: false,


                // Form
                form: new Form({
                    comp_id: '',
                    process: '',
                    details: '',
                    document: '',
                    accessories: '',
                    delivery: '',
                    applicable_type: '',
                    damaged_reason: ''
                }),

                assignedZone: [],

                // Closed
                closedoptions: [],
                closedVal: '',

                // damagedReasons
                ...damagedReasons,
                applicableOptions: [],

                showDamagedReson: false,

                // Zone Access
                dhkZoneAccess: false,
                
            }
        },

        methods: {

            setProcessOptions() {

                // current process
                let crpro = this.comData.process
                this.stepOptions = []

               

                   
                // console.log('Dhaka Zone found', element.name)
                if (crpro == 'Processing' &&  this.dhkZoneAccess) {
                    this.stepOptions = [{
                            text: 'Processing',
                            value: 'Processing'
                        },
                        {
                            text: 'Send Service Center',
                            value: 'Send Service'
                        },
                        {
                            text: 'Damaged',
                            value: 'Damaged'
                        },
                        {
                            text: 'Partial Damaged',
                            value: 'Partial Damaged'
                        },
                        {
                            text: 'Closed',
                            value: 'Closed'
                        },
                    ]
                } else if ( (crpro == 'Send Service' || crpro == 'Back Service' || crpro ==
                    'Again Send Service' || crpro ==
                    'Service Quotation') &&  this.dhkZoneAccess) {

                    this.stepOptions = [{
                            text: 'Service Quotation',
                            value: 'Service Quotation'
                        },
                        {
                            text: 'Back Service Center',
                            value: 'Back Service'
                        },
                        {
                            text: 'Again Send Service Center',
                            value: 'Again Send Service'
                        },
                        {
                            text: 'Damaged',
                            value: 'Damaged'
                        },
                        {
                            text: 'Partial Damaged',
                            value: 'Partial Damaged'
                        },
                        {
                            text: 'Closed',
                            value: 'Closed'
                        },
                    ]
                }
                else if (crpro == 'Processing' && ! this.dhkZoneAccess) {
                    this.stepOptions = [{
                            text: 'Processing',
                            value: 'Processing'
                        },
                        {
                            text: 'HO Service',
                            value: 'HO Service'
                        },
                        {
                            text: 'Closed',
                            value: 'Closed'
                        },
                    ]
                }


            },


            // changeProcess
            ...changeProcessMethod,
           


            // actionStore
            actionStore() {
                // Loading
                this.dataModalLoading = true
                // Assign complain ID
                this.form.comp_id = this.comData.id

                this.form.accessories = this.checkedAccessories

                this.form.post(this.currentUrl + '/action_remarks').then(response => {
                    console.log(response.data)

                    // Loading
                    this.dataModalLoading = false

                    this.actionDailog = false

                    Swal.fire({
                        icon: response.data.icon,
                        title: response.data.msg,
                    })

                    // Parent to child
                    this.$emit('childToParent')

                }).catch(error => {
                    // Loading
                    this.dataModalLoading = false
                    console.log(error)
                })

            },

            // get_user_zone_name
            getUserZone() {
                axios.get(this.currentUrl + '/get_user_zone_name').then(response => {
                    
                    this.assignedZone = response.data
                    
                    // Dhk Zone Access Check
                    this.dhkZoneAccess = this.assignedZone.includes('Dhaka')

                    console.log(this.assignedZone, this.dhkZoneAccess )
                    this.setProcessOptions()
                }).catch(error => {
                    console.log(error)
                })
            }

        },

        created() {
            this.getUserZone()

            //console.log('comData', this.auth, this.comData )
        }
    }

</script>

<style scoped>
    .error_bg {
        border: 1px solid red;
    }

    .v-input--selection-controls {
        margin-top: -6px;
        padding-top: 0px;
    }

    .v-radio {
        display: inline !important;
    }

</style>
