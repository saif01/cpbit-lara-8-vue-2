<template>
    <div>
        <v-dialog v-model="actionDailog" scrollable max-width="600px" >

            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Complain Modify
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="actionDailog = false" color="error lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>

                    <form @submit.prevent="actionStore()"  >

                        <v-row align-content="center" class="pt-5">

                            <v-col lg="12" md="12" cols="12">
                                <div class="small text-danger" v-if="form.errors.has('cat_id')"
                                    v-html="form.errors.get('cat_id')" />
                                <v-autocomplete :items="allCategory" @change="getSubcategory
                                    ()" v-model="form.cat_id" label="Select Category"
                                    :rules="[v => !!v || 'category is required!']" outlined required>
                                </v-autocomplete>
                            </v-col>
                            <v-col lg="12" md="12" cols="12">
                                <div class="small text-danger" v-if="form.errors.has('subcat_id')"
                                    v-html="form.errors.get('subcat_id')" />
                                <v-autocomplete :items="allSubcategory" v-model="form.subcat_id"
                                    label="Select Subcategory" :rules="[v => !!v || 'Subcategory  is required!']"
                                    outlined required></v-autocomplete>
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
    

    export default {

        props:['comData'],

        data() {
            return {
                // Dialog show
                actionDailog: true,

                //current page url
                currentUrl: '/cms/h_admin/complain',

                reqRules:[v => !!v || 'This field is required!'],

                dataModalLoading : false,

                allCatData:[],
                allCategory:[],
                allSubcategory:[],

                // Form
                form: new Form({
                    id: '',
                    cat_id: '',
                    subcat_id: '',
                }),

            }
        },

        methods:{

           
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
                
                    // Assign Form data
                   this.form.id = this.comData.id
                   this.form.cat_id = this.comData.cat_id
                   this.form.subcat_id = this.comData.subcat_id
                   this.getSubcategory()

                }).catch(error => {
                    console.log(error)
                })
            },

            // getSubcategory
            getSubcategory() {
                //console.log('cat id', this.form.cat_id)

                this.allCatData.forEach(element => {
                    //console.log(element.id)
                    this.currentAccessories = ''

                    // Check Selected category ID 
                    if (element.id == this.form.cat_id) {

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
                        
                    }
                })

              
            },

            // actionStore
            actionStore(){
                // Loading
                this.dataModalLoading = true
                // Assign complain ID
                this.form.comp_id = this.comData.id

                this.form.post( this.currentUrl + '/category_modify' ).then(response=>{
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
            this.getAllCategory()
            //console.log('comData', this.comData.cat_id,  this.comData.subcat_id, this.comData )
        }
    }

</script>