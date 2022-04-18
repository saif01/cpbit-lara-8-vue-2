<template>
    <div>
        <v-dialog v-model="appComplainDialog" scrollable>

            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Hardware Complain
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="appComplainDialog = false" color="error lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>

                    <form @submit.prevent="complainStore()">

                        <v-row align-content="center" class="pt-5">

                            <v-col lg="6" md="6" cols="12">
                                <div class="small text-danger" v-if="form.errors.has('cat_id')"
                                    v-html="form.errors.get('cat_id')" />
                                <v-autocomplete :items="allCategory" @change="getSubcategory
                                    ()" v-model="form.cat_id" label="Select Category"
                                    :rules="[v => !!v || 'category is required!']" outlined required>
                                </v-autocomplete>
                            </v-col>
                            <v-col lg="6" md="6" cols="12">
                                <div class="small text-danger" v-if="form.errors.has('subcat_id')"
                                    v-html="form.errors.get('subcat_id')" />
                                <v-autocomplete :items="allSubcategory" v-model="form.subcat_id"
                                    label="Select Subcategory" :rules="[v => !!v || 'Subcategory  is required!']"
                                    outlined required></v-autocomplete>
                            </v-col>
                            
                            <!-- Accessoris currentAccessories:  {{ currentAccessoriesData }} --> 
                            <v-col cols="12" v-if="currentAccessoriesData">
                                <v-input hide-details>Which Accessories are you send in Hardware, Please Select
                                </v-input>
                                <div class="d-flex align-center">
                                    <div v-for="(item, index) in currentAccessoriesData" :key="index">
                                        <v-checkbox class="mr-5" :value="item.name" :label="item.name" v-model="checkedAccessories" 
                                            hide-details></v-checkbox>
                                    </div>
                                </div>
                                <v-text-field label="Other accessoris that you provide mention here" v-model="otherAccessoris" ></v-text-field>
                            </v-col>   

                            <!-- details -->
                            <v-col cols="12">
                                <div class="small text-danger" v-if="form.errors.has('details')"
                                    v-html="form.errors.get('details')" />

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
                                <!-- <v-textarea
                                    outlined
                                    label="Details"
                                    v-model="form.details"
                                    placeholder="Please, Mention your problem in details"
                                    :counter="20000"
                                    :rules="remRules"
                                    required
                                    ></v-textarea> -->
                            </v-col>

                            <!-- document -->
                            <v-col lg="6" md="6" cols="12">
                                <v-file-input @change="uploadDocByName($event, 'document')" show-size label="Document"
                                    accept="image/*, .pdf, .xlsx, .docx" :rules="docRules" outlined></v-file-input>
                            </v-col>

                            <v-col lg="6" md="6" cols="12" v-if="computerNameLavel">
                                <v-text-field :label="computerNameLavel" placeholder="Enter correct name" v-model="form.computer_name"  outlined required></v-text-field>
                            </v-col>

                        </v-row>



                        <v-btn type="submit" x-large block :loading="dataModalLoading" color="primary">
                            <v-icon left dark>mdi-shape-polygon-plus</v-icon> Submit
                        </v-btn>

                    </form>



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
        components: {
            VueEditor
        },


        data() {
            return {
                appComplainDialog: true,

                //current page url
                currentUrl: '/cms/hard',

                docRules: [
                    value => !value || value.size < 2000000 || 'Document size should be less than 2 MB!',
                ],

                remRules: [
                    v => (v || '').length <= 20000 || 'Description must be 20,000 characters or less',
                    v => (v || '').length >= 10 || '10 chars minimum or more',
                ],


                allCategory: [],
                allSubcategory: [],

                allCatData: [],
                currentAccessoriesData: '',

                checkedAccessories:[],
                otherAccessoris:'',
                computerNameLavel: '',

                dataModalLoading: false,

                // Form
                form: new Form({
                    cat_id: '',
                    subcat_id: '',
                    details: '',
                    document: '',
                    computer_name: '',
                    accessories: '',
                }),

                // vue2EditorToolbar
                ...vue2EditorToolbar
            }
        },

        methods: {

            // getAllCategory
            getAllCategory() {
                axios.get(this.currentUrl + '/category').then(response => {

                    // console.log(response.data)
                    this.allCatData = response.data

                    for (let i = 0; i < response.data.length; i++) {
                        this.allCategory.push(response.data[i]);
                        this.allCategory[i] = {
                            value: response.data[i].id,
                            text: response.data[i].name
                        };
                    }
                }).catch(error => {
                    console.log(error)
                })
            },

            // getSubcategory
            getSubcategory() {
                //console.log('cat id', this.form.cat_id)

                this.allCatData.forEach(element => {
                    //console.log(element.id)
                    //this.currentAccessoriesData = ''

                    // Check Selected category ID 
                    if (element.id == this.form.cat_id) {

                        if (element.acsosoris.length > 0) {
                           
                            this.currentAccessoriesData = element.acsosoris

                            //console.log('acsosoris', this.currentAccessoriesData, element.acsosoris)
                        }
                        //console.log(element)
                        this.allSubcategory = []
                        if (element.subcat.length > 0) {
                            for (let i = 0; i < element.subcat.length; i++) {
                                this.allSubcategory.push(element.subcat[i]);
                                this.allSubcategory[i] = {
                                    value: element.subcat[i].id,
                                    text: element.subcat[i].name
                                };
                            }

                        }

                        // Computer Name Field
                        this.computerNameLavel = ''
                        if(element.label){
                            this.computerNameLavel = element.label
                        }
                        
                    }
                })

                // Make Empty
                // this.allSubcategory = []

                // axios.get(this.currentUrl + '/subcategory/' + this.form.cat_id).then(response => {
                //     //this.allCategory = response.data
                //     //console.log(response.data)
                //     for (let i = 0; i < response.data.length; i++) {
                //         this.allSubcategory.push(response.data[i]);
                //         this.allSubcategory[i] = {
                //             value: response.data[i].id,
                //             text: response.data[i].name
                //         };
                //     }
                // }).catch(error => {
                //     console.log(error)
                // })
            },

            // complainStore
            complainStore() {
                // Loading
                this.dataModalLoading = true

                // combaine array and text
                if(this.otherAccessoris){
                    this.checkedAccessories.push(this.otherAccessoris)
                }
                
                // Assign in form 
                this.form.accessories = this.checkedAccessories

                // console.log('ass', this.form.accessories, this.checkedAccessories)

                this.form.post(this.currentUrl + '/complain').then(response => {
                    // console.log(response.data)

                    // Loading
                    this.dataModalLoading = false
                    this.appComplainDialog = false

                    Swal.fire({
                        icon: response.data.icon,
                        title: response.data.msg,
                    })

                }).catch(error => {
                    // Loading
                    this.dataModalLoading = false
                    console.log(error)
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!! Somthing going wrong',
                    })
                })

            },


        },

        created() {
            this.getAllCategory();
        }

    }

</script>
