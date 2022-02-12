<template>
    <div>
        <v-dialog v-model="appComplainDialog" scrollable>
            
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                           Application Complain 
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="appComplainDialog = false" color="error lighten-1" small text class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>

                     <form @submit.prevent="complainStore()"> 
                        
                            <v-row align-content="center">
                                <v-col cols="6">
                                    <div class="small text-danger" v-if="form.errors.has('cat_id')" v-html="form.errors.get('cat_id')" />
                                    <v-autocomplete :items="allCategory" @change="getSubcategory
                                    ()" v-model="form.cat_id" label="Select Software" :rules="[v => !!v || 'Software is required!']" outlined required></v-autocomplete>
                                </v-col>
                                <v-col cols="6">
                                    <div class="small text-danger" v-if="form.errors.has('subcat_id')" v-html="form.errors.get('subcat_id')" />
                                    <v-autocomplete :items="allSubcategory"
                                    v-model="form.subcat_id" label="Select Software Module" :rules="[v => !!v || 'Software Module is required!']" outlined required></v-autocomplete>
                                </v-col>

                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('details')" v-html="form.errors.get('details')" />
                                    <v-textarea
                                    outlined
                                    label="Details"
                                    v-model="form.details"
                                    placeholder="Please, Mention your problem in details"
                                    :counter="20000"
                                    :rules="remRules"
                                    required
                                    ></v-textarea>
                                </v-col>
                               
                          
                                <v-col lg="3" md="6" cols="12">
                                    <v-file-input
                                        @change="uploadDocByName($event, 'document')"
                                        show-size
                                        label="Document 1"
                                        accept="image/*, .pdf, .xlsx, .docx"
                                        :rules="docRules"
                                        outlined
                                    ></v-file-input>
                                </v-col>
                                 <v-col lg="3" md="6" cols="12">
                                    <v-file-input
                                    @change="uploadDocByName($event, 'document2')"
                                        show-size
                                        label="Document 2"
                                        accept="image/*, .pdf, .xlsx, .docx"
                                        :rules="docRules"
                                        outlined
                                    ></v-file-input>
                                </v-col>
                                 <v-col lg="3" md="6" cols="12">
                                    <v-file-input
                                        @change="uploadDocByName($event, 'document3')"
                                        show-size
                                        label="Document 3"
                                        accept="image/*, .pdf, .xlsx, .docx"
                                        :rules="docRules"
                                        outlined
                                    ></v-file-input>
                                </v-col>
                                 <v-col lg="3" md="6" cols="12">
                                    <v-file-input
                                        @change="uploadDocByName($event, 'document4')"
                                        show-size
                                        label="Document 4"
                                        accept="image/*, .pdf, .xlsx, .docx"
                                        :rules="docRules"
                                        outlined
                                    ></v-file-input>
                                </v-col>
                            </v-row>

                           
                           
                            <v-btn type="submit" x-large block :loading="dataModalLoading"
                                color="primary"><v-icon left dark>mdi-shape-polygon-plus</v-icon> Submit
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

    export default{

        data(){
            return{
                appComplainDialog: true,

                //current page url
                currentUrl: '/cms/app',

                docRules: [
                    value => !value || value.size < 2000000 || 'Document size should be less than 2 MB!',
                ],

                remRules:[
                    v => (v || '' ).length <= 20000 || 'Description must be 20,000 characters or less',
                    v => (v || '' ).length >= 10 || '10 chars minimum or more',
                ],


                allCategory:[],
                allSubcategory:[],

                dataModalLoading: false,

                // Form
                form: new Form({
                    id: '',
                    name: '',
                    cat_id: '',
                    subcat_id: '',
                    details: '',
                    document:'',
                    document2:'',
                    document3:'',
                    document4:'',
                }),
            }
        },

        methods:{

            // getAllCategory
            getAllCategory(){
                axios.get( this.currentUrl + '/category').then( response=>{
                    //this.allCategory = response.data
                    //console.log(response.data)
                    for (let i = 0; i < response.data.length; i++) {
                        this.allCategory.push(response.data[i]);
                        this.allCategory[i] = { value: response.data[i].id, text: response.data[i].name };
                    }
                }).catch(error=>{
                    console.log(error)
                })
            },

            // getSubcategory
            getSubcategory(){
                console.log('cat id', this.form.cat_id)
                // Make Empty
                this.allSubcategory = []

                axios.get( this.currentUrl + '/subcategory/'+ this.form.cat_id).then( response=>{
                    //this.allCategory = response.data
                    //console.log(response.data)
                    for (let i = 0; i < response.data.length; i++) {
                        this.allSubcategory.push(response.data[i]);
                        this.allSubcategory[i] = { value: response.data[i].id, text: response.data[i].name };
                    }
                }).catch(error=>{
                    console.log(error)
                })
            },

            // complainStore
            complainStore(){
                // Loading
                this.dataModalLoading = true

                this.form.post( this.currentUrl + '/complain' ).then(response=>{
                    console.log(response.data)

                    // Loading
                    this.dataModalLoading = false

                    this.appComplainDialog = false

                    Swal.fire({
                        icon: response.data.icon,
                        title: response.data.msg,
                    })

                }).catch(error=>{
                    // Loading
                    this.dataModalLoading = false
                    console.log(error)
                })

            },


        },

        created(){
            this.getAllCategory();
        }
        
    }
</script>
