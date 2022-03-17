<template>
    <div>
        <v-dialog v-model="actionDailog" scrollable>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                           (Damaged Replacment) Complain Actions :
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
                            <td><div class="pa-1 success rounded-pill h6 text-white text-center">{{ comData.id }}</div></td>
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
                               
                                <!-- Remaining Stock -->
                                <v-card-text v-if="remainingStock">
                                    <p>Remaining Stock:</p>
                                    <v-row>
                                        <v-col cols="12" lg="3"  v-for="(item, index) in remainingStock" :key="index">
                                            <v-btn @click="selectStockProduct(item)" :class="(secectedProID == item[0].category.id)? 'success': ''" outlined dense>{{ item[0].category.name }} :{{ item.length }}</v-btn>
                                        </v-col>
                                    </v-row>
                                    <!-- {{ selectedProduct.length }} -- {{ selectedProduct }} <hr>
                                    {{ initialSelectProduct }} -->

                                    <v-row v-if="selectedProduct.length">
                                        <!-- Product Select -->
                                        <v-col cols="6" >
                                            <!-- {{ form.product_id.length }} -->
                                            <v-autocomplete :items="selectedProduct"  v-model="form.product_id" label="Select Product"
                                                :rules="[v => !!v || 'Product is required!']" multiple outlined dense >
                                            </v-autocomplete>
                                        </v-col>
                                        <v-col cols="2">
                                            <!-- {{ form.product_id }} -->
                                           Total Select: <span class="rounded bg-info px-1 h4">{{ form.product_id.length }}</span>
                                        </v-col>
                                        <!-- Operation Select for Inventory -->
                                        <v-col cols="4">
                                            <!-- {{ form.product_id }} -->
                                            <v-autocomplete :items="invOperations" v-model="form.operation_id" label="Select Operation"
                                                :rules="[v => !!v || 'Operation is required!']" outlined dense required>
                                            </v-autocomplete>
                                        </v-col>
                                    </v-row>
                                        
                                    

                                </v-card-text>
                                <v-card-text v-else>
                                     <div class="p-5 my-5">
                                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin
                                            </v-icon>
                                        </p>
                                    </div>
                                </v-card-text>
                              
                                <!-- Reciver Details -->
                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('rec_name')"
                                        v-html="form.errors.get('rec_name')" />
                                    <v-text-field v-model="form.rec_name" :rules="[v => !!v || 'Reciver Name is required!']" label="Receiver name" required></v-text-field>
                                </v-col>
                                <v-col cols="12" lg="4" >
                                    <div class="small text-danger" v-if="form.errors.has('rec_contact')"
                                    v-html="form.errors.get('rec_contact')" />
                                    <v-text-field type="number" v-model="form.rec_contact" :rules="numberRules" label="Receiver Contact" required></v-text-field>
                                </v-col>
                                <v-col cols="12" lg="4" >
                                    <div class="small text-danger" v-if="form.errors.has('rec_position')"
                                    v-html="form.errors.get('rec_position')" />
                                    <v-text-field v-model="form.rec_position" :rules="[v => !!v || 'Reciver Position is required!']" label="Receiver Position" required></v-text-field>
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

                numberRules: [
                    v => !!v || 'Phone Number is required',
                    v => v.length == 11 || 'Phone Number must be 11 characters',
                    v => /01+/.test(v) || 'Phone Number must be valid',
                ],

                dataModalLoading : false, 

               
                // Form
                form: new Form({
                    comp_id: '',
                    details: '',

                    operation_id: '',
                    product_id: [],
                    rec_name:'',
                    rec_contact:'',
                    rec_position:'',
                }),

                // remaining stock
                remainingStock: '',
                selectedProduct: [],
                secectedProID: '',
                invOperations:[],

                initialSelectProduct:[],



            }
        },

        methods:{

            setProcessOptions(val){

               // console.log('setProcess', val, val == 'Send Service' )

                this.stepOptions = []

                //console.log('set', element, element.name)

                this.stepOptions = [
                        {
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
                

                

            },


            // selectStockProduct
            selectStockProduct(val){
                //this.selectedProduct = []
                //console.log('val :', val)

                for (let i = 0; i < val.length; i++) {
                    this.initialSelectProduct.push(val[i])
                }

                for (let i = 0; i < this.initialSelectProduct.length; i++) {
                    let optionData = { value:  this.initialSelectProduct[i].id, text: this.initialSelectProduct[i].category.name + ' -- ' + this.initialSelectProduct[i].name + ' -- SL: ' + this.initialSelectProduct[i].serial + ' -- P.O: ' + this.initialSelectProduct[i].po_number }
                    this.selectedProduct.push(optionData)
                }

              

                console.log('Selected Product', this.initialSelectProduct)


                // let selectedProduct =[]
                // for (let i = 0; i < val.length; i++) {
                //         selectedProduct.push(val[i]);
                //         selectedProduct[i] = {value: val[i].id, text: val[i].category.name + ' -- ' + val[i].name + ' -- SL: ' + val[i].serial + ' -- P.O: ' + val[i].po_number};
                //     }


                //this.secectedProID = val[0].cat_id
               // console.log('Selected Product', val, this.secectedProID, this.selectedProduct)

                //this.selectedProduct = val
            },


         

            // actionStore
            actionStore(){
                // Loading
                this.dataModalLoading = true
                // Assign complain ID
                this.form.comp_id = this.comData.id
                
                this.form.accessories = this.checkedAccessories

                this.form.post( this.currentUrl + '/action_damaged' ).then(response=>{
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

            // getRemainingStock
            getRemainingStock(){
                axios.get( this.currentUrl + '/damaged/remaining_stock').then(response=>{
                    console.log( response.data )
                    this.remainingStock = response.data
                }).catch(error=>{
                    console.log(error)
                })
            },

            // getInvOperations
            getInvOperations(){
                axios.get( this.currentUrl + '/damaged/inv_operations').then(response=>{
                    console.log( response.data )
                    this.invOperations = response.data
                }).catch(error=>{
                    console.log(error)
                })
            },

        },

        created(){
            this.getRemainingStock();
            this.getInvOperations();
            //this.getUserZone();
            //this.setProcessOptions();
            
            
            
            //console.log('comData', this.auth, this.comData )
        }
    }

</script>

<style scoped>
    .error_bg{
        border: 1px solid red;
    }
</style>