<template>
    <div>
        <v-dialog v-model="actionDailog" scrollable>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            (HO) Complain Actions :
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
                currentUrl: '/cms/h_admin/complain/ho_service',

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
                    warranty: '',
                    delivery: '',
                    applicable: '',
                }),

                currentHoProcess: '',

                // damagedReasons
                ...damagedReasons,
                applicableOptions: [],

                // Closed
                closedoptions: [],
                closedVal: '',

            }
        },

        methods: {

            setProcessOptions(val) {

                // console.log('setProcess', val, val == 'Send Service' )

                this.stepOptions = []

                //console.log('set', element, element.name)

                // console.log('Dhaka Zone found', element.name)
                if (val == 'Send Service' || val == 'Again Send Service') {

                    this.stepOptions = [
                        {
                            text: 'Service Quotation',
                            value: 'Service Quotation'
                        },
                        {
                            text: 'Back Service',
                            value: 'Back Service'
                        },
                        // {
                        //     text: 'Again Send Service',
                        //     value: 'Again Send Service'
                        // },
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

                else if (val == 'Service Quotation' ) {

                    this.stepOptions = [
                       
                        {
                            text: 'Back Service',
                            value: 'Back Service'
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
                
                
                else {
                    this.stepOptions = [{
                            text: 'Processing',
                            value: 'Processing'
                        },
                        {
                            text: 'Send Service',
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
                }







            },


            // changeProcess
            changeProcess() {
                // current process
                let crpro = this.form.process
                this.applicableOptions = []
                this.closedoptions = []
                this.showDamagedReson = false

                console.log('process', crpro)

                // Damaged
                if (crpro == 'Damaged' || crpro == 'Partial Damaged') {
                    this.showDamagedReson = true
                    this.applicableOptions = [{
                            label: 'Applicable for User (Non-stock)',
                            value: 'Applicable',
                            color: 'success'
                        },
                        {
                            label: 'Not Applicable for User (Stock)',
                            value: 'Not Applicable',
                            color: 'error'
                        }
                    ]
                }

                // Closed
                if (crpro == 'Closed') {
                    this.closedoptions = [{
                            label: 'Deliverable',
                            value: 'Deliverable',
                            color: 'success'
                        },
                        {
                            label: 'Not Deliverable',
                            value: 'Not Deliverable',
                            color: 'info'
                        }
                    ]
                }


            },


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

            // get_user_zone
            getHoRemarks() {
                axios.get(this.currentUrl + '/action_remarks_data/' + this.comData.id).then(response => {
                    //console.log( response.data.process )
                    this.currentHoProcess = response.data.process
                    this.setProcessOptions(response.data.process)
                }).catch(error => {
                    console.log(error)
                })
            }

        },

        created() {
            this.getHoRemarks();
            //this.getUserZone();
            //this.setProcessOptions();

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
