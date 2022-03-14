<template>
    <div>
        <v-dialog persistent v-model="deliverModal" max-width="1100px">
            <v-card>
                    <v-card-title class="justify-center">
                        <v-row>
                            <v-col cols="10">
                                Product Delivery Details
                            </v-col>
                            <v-col cols="2">
                                <v-btn @click="deliverModal = false, resetForm()" color="red lighten-1 white--text" small
                                    class="float-right">
                                    <v-icon left dark>mdi-close-octagon</v-icon> Close
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text>
                        <v-form v-model="valid" ref="form" >
                            <form @submit.prevent="deliveryData()">

                                <v-row align-content="center">

                                    <v-col cols="12" lg="3">
                                        <v-text-field disabled label="Category" :value="category"></v-text-field>
                                        <!-- <v-autocomplete disabled :items="allCategory" @change="getSubcategory
                                        ()" v-model="form.cat_id" label="Select Category"
                                            :rules="[v => !!v || 'Category is required!']" dense required>
                                        </v-autocomplete> -->
                                    </v-col>
                                    <v-col cols="12" lg="3">
                                        <v-text-field disabled label="Subcategory" :value="subcategory"></v-text-field>
                                        <!-- <v-autocomplete disabled :items="allSubcategory" v-model="form.subcat_id"
                                            label="Select Subcategory" :rules="[v => !!v || 'Subcategory is required!']"
                                            dense  required></v-autocomplete> -->
                                    </v-col>

                                    <v-col cols="12" lg="3">
                                        <v-text-field disabled v-model="form.name" label="Product Name or Model"
                                            :rules="[v => !!v || 'Product Name or Model is required!']"
                                            placeholder="Enter Product Product Name or Model" dense  required>
                                        </v-text-field>
                                    </v-col>

                                    <v-col cols="12" lg="3">
                                        <v-text-field disabled v-model="form.serial" label="Serial Number"
                                            :rules="[v => !!v || 'Serial number is required!']"
                                            placeholder="Enter Product Serial number" dense  required>
                                        </v-text-field>
                                    </v-col>



                                    <v-col cols="12" lg="4">
                                        <div class="small text-danger" v-if="form.errors.has('operation_id')"
                                            v-html="form.errors.get('operation_id')" />
                                        <v-autocomplete :items="operation" v-model="form.operation_id"
                                            label="Select Operation" :rules="[v => !!v || 'Operation is required!']"
                                            dense  required></v-autocomplete>
                                    </v-col>

                                    <v-col cols="12" lg="4">
                                        <div class="small text-danger" v-if="form.errors.has('business_unit')"
                                            v-html="form.errors.get('business_unit')" />
                                        <v-autocomplete :items="business_unit" v-model="form.business_unit"
                                            label="Select Business Unit" :rules="[v => !!v || 'Business Unit is required!']"
                                            dense  required></v-autocomplete>
                                    </v-col>

                                    <v-col cols="12" lg="4">
                                        <div class="small text-danger" v-if="form.errors.has('office')"
                                            v-html="form.errors.get('office')" />
                                        <v-autocomplete :items="allOffice" v-model="form.office"
                                            label="Select Office Name" :rules="[v => !!v || 'Office is required!']"
                                            dense  required></v-autocomplete>
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <!-- Details -->
                                    <v-col cols="8">
                                        <div class="small text-danger" v-if="form.errors.has('remarks')"
                                            v-html="form.errors.get('remarks')" />
                                        <label>Details :</label>
                                        <vue-editor
                                            :class="{ error_bg: (form.remarks && ( form.remarks.length <= 10 || form.remarks.length >= 20000 )) }"
                                            v-model="form.remarks" :editorToolbar="customToolbar"></vue-editor>
                                        <v-row>
                                            <v-col cols="10">
                                                <span v-if="(form.remarks && form.remarks.length <= 10)"
                                                    class="small text-danger">10 chars minimum or more.</span>
                                                <span v-if="(form.remarks && form.remarks.length >= 20000)"
                                                    class="small text-danger">Description must be 20,000 characters or
                                                    less.</span>
                                            </v-col>
                                            <v-col cols="2">
                                                <span class="float-right">{{ form.remarks.length }}/ 20,000</span>
                                            </v-col>
                                        </v-row>
                                    </v-col>

                                    <v-col cols="4">
                                        <v-col cols="12">
                                            <div class="small text-danger" v-if="form.errors.has('rec_name')"
                                                v-html="form.errors.get('rec_name')" />
                                            <v-text-field v-model="form.rec_name" :rules="[v => !!v || 'Reciver Name is required!']" label="Receiver name" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <div class="small text-danger" v-if="form.errors.has('rec_contact')"
                                            v-html="form.errors.get('rec_contact')" />
                                            <v-text-field v-model="form.rec_contact" :rules="[v => !!v || 'Reciver Contact is required!']" label="Receiver Contact" dense required></v-text-field>
                                        </v-col>

                                        <v-col cols="12" >
                                            <div class="small text-danger" v-if="form.errors.has('rec_position')"
                                            v-html="form.errors.get('rec_position')" />
                                            <v-text-field v-model="form.rec_position" :rules="[v => !!v || 'Reciver Position is required!']" label="Receiver Position" required></v-text-field>
                                        </v-col>

                                    </v-col>

                                </v-row>






                                <v-btn type="submit" block depressed :loading="dataModalLoading"
                                    color="primary">
                                    <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                                </v-btn>

                            </form>
                        </v-form>

                    </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>



<script>
// vform
import Form from 'vform';
import {VueEditor} from "vue2-editor";
import vue2EditorToolbar from "./../../pages/common/js/vue2_editor_toolbar"
export default {

    props:['currentData','category', 'subcategory'],

    data(){
        return{
            deliverModal: true,

            allOffice: [],
            business_unit: [],
            operation: [],



            // deliver Form
            form: new Form({
                id: '',
                cat_id: '',
                subcat_id: '',
                serial: '',
                name: '',
                remarks: '',
                operation_id: '',
                business_unit: '',
                office: '',
                rec_name: '',
                rec_contact: '',
                rec_position: '',

            }),

            // Custom Toolbar for vue2 text editor
            ...vue2EditorToolbar,


            currentUrl: '/inventory/admin/new_product',
        }
    },

    components: {
        VueEditor
    },

    
    methods:{
        // getOffice
        getOffice() {
            axios.get(this.currentUrl+'/office').then(response => {
                console.log(response.data);
                // zone_office
                response.data.office.forEach(element => {
                    this.allOffice.push({
                        value: element.zone_office,
                        text: element.zone_office
                    }) ;
                    //console.log('getOffice',  this.allOffice, element);
                });

                // business_unit
                response.data.business_unit.forEach(element => {
                    this.business_unit.push({
                        value: element.business_unit,
                        text: element.business_unit
                    }) ;
                    //console.log('business_unit',  this.allOffice, element);
                });

                // operation
                response.data.operation.forEach(element => {
                    this.operation.push({
                        value: element.id,
                        text: element.name
                    }) ;
                    //console.log('operation',  this.allOffice, element);
                });

            }).catch(error => {
                console.log(error)
            })
        },




        deliveryData(){

            this.form.post(this.currentUrl + '/deliver?id=' + this.form.id).then((response) => {
                //console.log(response);
                Swal.fire(
                    'Delivered!',
                    'Your Product has been Delivered.',
                    'success'
                );
                // Refresh Tbl Data with current page
                this.getResults(this.currentPageNumber);
                this.deliverModal = false;
                this.$Progress.finish();

            }).catch((data) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Somthing Going Wrong<br>'+data.message,
                    customClass: 'text-danger'
                });
                // Swal.fire("Failed!", data.message, "warning");
            });

        },
    },

    mounted(){
        
        this.getOffice();

        this.form.id = this.currentData.id
        this.form.cat_id =  this.currentData.cat_id
        this.form.subcat_id =  this.currentData.subcat_id
        this.form.name =  this.currentData.name
        this.form.serial =  this.currentData.serial
    },


}
</script>