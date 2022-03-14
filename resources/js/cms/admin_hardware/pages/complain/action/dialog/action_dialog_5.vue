<template>
    <div>
        <v-dialog v-model="actionDailog" scrollable>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                           Damaged Quotation Complain Actions :
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
                            <td><div class="pa-1 success rounded-pill h6 text-white text-center">
                                {{ comData.id }}</div></td>
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

                                <!-- Document -->
                                <v-col cols="12">
                                    <v-file-input 
                                        @change="uploadDocByName($event, 'document')"
                                        show-size
                                        label="Document"
                                        accept="image/*, .pdf, .xlsx, .docx"
                                        :rules="docRules"
                                        outlined
                                        dense
                                    ></v-file-input>
                                </v-col>
                               
                               

                                <!-- Details -->
                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('details')" v-html="form.errors.get('details')" />
                                   
                                    <v-row>
                                        <v-col cols="8">
                                            <label>Details :</label>
                                        </v-col>
                                        <v-col cols="4" v-if="drafts.length">
                                            <v-autocomplete :items="drafts" dense v-model="selectDraft"
                                                label="Draft"></v-autocomplete>
                                        </v-col>
                                    </v-row>
                                    <vue-editor :class="{ error_bg: (form.details && ( form.details.length <= 10 || form.details.length >= 20000 )) }" v-model="form.details" :editorToolbar="customToolbar"></vue-editor>
                                    <v-row>
                                        <v-col cols="10">
                                            <span v-if="(form.details && form.details.length <= 10)" class="small text-danger" >10 chars minimum or more.</span>
                                            <span v-if="(form.details && form.details.length >= 20000)" class="small text-danger" >Description must be 20,000 characters or less.</span>
                                        </v-col>
                                        <v-col cols="2" >
                                            <span class="float-right">{{ form.details.length }}/ 20,000</span>
                                        </v-col>
                                    </v-row>
                                    
                                </v-col>
                               
                            </v-row>

                           
                           <v-row class="mt-2">
                                <v-btn type="submit" block :loading="dataModalLoading" elevation="20"
                                    color="primary"><v-icon left dark>mdi-shape-polygon-plus</v-icon> Submit
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

   

    export default {

        props:['comData'],

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

                reqRules:[v => !!v || 'This field is required!'],

                docRules: [
                    value => !value || value.size < 2000000 || 'Document size should be less than 2 MB!',
                ],

                remRules:[
                    v => (v || '' ).length <= 20000 || 'Description must be 20,000 characters or less',
                    v => (v || '' ).length >= 10 || '10 chars minimum or more',
                ],


                stepOptions:[],

                dataModalLoading : false,

               
                // Form
                form: new Form({
                    comp_id: '',
                    process: '',
                    details: '',
                    document: '',
                    accessories: '',
                    warranty: '',
                    delivery: '',
                    applicable_type:'',
                    damaged_reason:''
                }),

                assignedZone :[],

                // Damaged
                applicableOptions:[],
               
                // Closed
                closedoptions:[],
                closedVal:'',

              

            }
        },

        methods:{

         

         


            // actionStore 
            actionStore(){
                // Loading
                this.dataModalLoading = true
                // Assign complain ID
                this.form.comp_id = this.comData.id
                
                this.form.accessories = this.checkedAccessories

                this.form.post( this.currentUrl + '/action_quotation' ).then(response=>{
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

                }).catch(error=>{
                    // Loading
                    this.dataModalLoading = false
                    console.log(error)
                })

            },

           

        },

        created(){
            
            //console.log('comData', this.auth, this.comData )
        }
    }

</script>

<style scoped>
    .error_bg{
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